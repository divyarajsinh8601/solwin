<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Controller\Widget;

use Magento\Framework\App\Filesystem\DirectoryList;
use Solwin\Contactwidget\Api\Data\ContactwidgetInterfaceFactory;
use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use RuntimeException;
use Solwin\Contactwidget\Helper\Data;
use Zend_Validate;
use Solwin\Contactwidget\Api\ContactwidgetRepositoryInterface;

class Index extends Action
{
    public const EMAIL_TEMPLATE = 'contactwidget_section/emailsend/emailtemplate';
    public const EMAIL_SENDER = 'contactwidget_section/emailsend/emailsenderto';
    public const XML_PATH_EMAIL_RECIPIENT = 'contactwidget_section/emailsend/emailto';
    public const REQUEST_URL = 'https://www.google.com/recaptcha/api/siteverify';
    public const REQUEST_RESPONSE = 'g-recaptcha-response';

    /**
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Data $helper
     * @param ContactwidgetInterfaceFactory $contactwidgetInterfaceFactory
     */
    public function __construct(
        Context $context,
        private TransportBuilder $transportBuilder,
        private StateInterface $inlineTranslation,
        private ScopeConfigInterface $scopeConfig,
        private StoreManagerInterface $storeManager,
        private Data $helper,
        private ContactwidgetInterfaceFactory $contactwidgetInterfaceFactory,
        private ContactwidgetRepositoryInterface $contactwidgetRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $remoteAddr = filter_input(
            INPUT_SERVER,
            'REMOTE_ADDR',
            FILTER_DEFAULT
        );
        $data = $this->getRequest()->getParams();
        if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {
            try {
                $uploader = $this->_objectManager->create(
                    'Magento\MediaStorage\Model\File\Uploader',
                    ['fileId' => 'attachment']
                );
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $uploader->setAllowCreateFolders(true);

                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                    ->getDirectoryRead(DirectoryList::MEDIA);

                $result = $uploader->save(
                    $mediaDirectory->getAbsolutePath('Solwin_Contactwidget')
                );

                $data['attachment'] = 'Solwin_Contactwidget/' . $result['file'];

            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $contactwidget = $this->contactwidgetInterfaceFactory->create();
        $contactwidget->setData($data);
        $this->contactwidgetRepository->save($contactwidget);
        $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));

        $resultRedirect = $this->resultRedirectFactory->create();

        $data['name'] = $this->removeScriptTag($data['name']);
        if ($data['name'] == "") {
            $this->messageManager->addError(__('Name is required field. Please Enter correct value.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['subject'] = $this->removeScriptTag($data['subject']);
        if ($data['subject'] == "") {
            $this->messageManager->addError(__('Subject is required field. Please Enter correct value.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['comment'] = $this->removeScriptTag($data['comment']);
        if ($data['comment'] == "") {
            $this->messageManager->addError(__('What’s on your mind? is required field. Please Enter correct value.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $redirectUrl = $data['currUrl'];
        $secretkey = $this->helper
                ->getConfigValue(
                    'contactwidget_section/recaptcha/recaptcha_secretkey'
                );
        $sitekey = $this->helper
                ->getConfigValue(
                    'contactwidget_section/recaptcha/recaptcha_sitekey'
                );
        $enablerecaptcha = $data['enablerecaptcha'];
        if ($enablerecaptcha && ($sitekey == "" || $secretkey == "")) {
            $this->messageManager->addError('Recaptcha enabled but the captcha site key or secret key may be empty. Please contact the store admin for this issue.');
            return $resultRedirect->setUrl($redirectUrl);
        }

        $captchaErrorMsg = $this->helper
                ->getConfigValue(
                    'contactwidget_section/recaptcha/recaptcha_errormessage'
                );

        if ($data['enablerecaptcha']) {
            if ($captchaErrorMsg == '') {
                $captchaErrorMsg = 'Invalid captcha. Please try again.';
            }
            $captcha = '';
            if (filter_input(INPUT_POST, 'g-recaptcha-response') !== null) {
                $captcha = filter_input(INPUT_POST, 'g-recaptcha-response');
            }

            if (!$captcha) {
                $this->messageManager->addError($captchaErrorMsg);
                return $resultRedirect->setUrl($redirectUrl);
            } else {
                $response = file_get_contents(
                    "https://www.google.com/recaptcha/api/siteverify"
                        . "?secret=" . $secretkey
                        . "&response=" . $captcha
                    . "&remoteip=" . $remoteAddr
                );
                $response = json_decode($response, true);

                if ($response["success"] === false) {
                    $this->messageManager->addError($captchaErrorMsg);
                    return $resultRedirect->setUrl($redirectUrl);
                }
            }
        }

        try {
            $postObject = new DataObject();
            $data['choose_movie'] = implode(',', $data['choose_movie']);
            $postObject->setData($data);
            $error = false;

            if (!Zend_Validate::is(trim($data['name']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['email']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['checked_number']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['choose_movie']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['favorite_name']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['datepicker']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['Intrested']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['subject']), 'NotEmpty')) {
                $error = true;
            }

            if (!Zend_Validate::is(trim($data['comment']), 'NotEmpty')) {
                $error = true;
            }

            if ($error) {
                throw new Exception();
            }

            // send mail to recipients
            $this->inlineTranslation->suspend();
            $storeScope = ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder->setTemplateIdentifier(
                $this->scopeConfig->getValue(
                    self::EMAIL_TEMPLATE,
                    $storeScope
                )
            )->setTemplateOptions(
                [
                                'area' => Area::AREA_FRONTEND,
                                'store' => $this->storeManager
                                        ->getStore()
                                        ->getId(),
                            ]
            )->setTemplateVars(['data' => $postObject])
                    ->setFrom($this->scopeConfig->getValue(
                        self::EMAIL_SENDER,
                        $storeScope
                    ))
                    ->addTo($this->scopeConfig->getValue(
                        self::XML_PATH_EMAIL_RECIPIENT,
                        $storeScope
                    ))
                    ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();

            $this->messageManager->addSuccess(__('Contact Us request has been '
                    . 'received. We\'ll respond to you very soon.'));
            return $resultRedirect->setUrl($redirectUrl);
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addException($e, __('Something went wrong '
                    . 'while sending the contact us request.'));
        }
        return $resultRedirect->setUrl($redirectUrl);
    }

    /**
     * Remove Script Tag
     *
     * @param $original_string
     * @param $replace_string
     * @return array|string|string[]|null
     */
    public function removeScriptTag($original_string, $replace_string = "")
    {
        return preg_replace("/<\s*script.*?>.*?(<\s*\/script.*?>|$)/is", $replace_string, $original_string);
    }
}
