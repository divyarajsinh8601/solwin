<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Controller\Adminhtml\Contactwidget;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Solwin\Contactwidget\Model\Contactwidget;
use Solwin\Contactwidget\Model\ContactwidgetFactory;
use Solwin\Contactwidget\Api\ContactwidgetRepositoryInterface;
use Solwin\Contactwidget\Model\ImageUploader;
use Solwin\Contactwidget\Api\Data\ContactwidgetInterfaceFactory;

class Save extends Action
{

    protected $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ContactwidgetRepositoryInterface $contactwidgetRepository
     * @param ImageUploader $imageUploader
     * @param ContactwidgetInterfaceFactory $contactwidgetInterfaceFactory
     * @param ContactwidgetFactory $contactwidgetFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        private ContactwidgetRepositoryInterface $contactwidgetRepository,
        private ImageUploader $imageUploader,
        private ContactwidgetInterfaceFactory $contactwidgetInterfaceFactory,
        private ContactwidgetFactory $contactwidgetFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        if (isset($data['entity_id'])) {
            $model = $this->contactwidgetRepository->get($data['contactwidget_id']);
        } else {
            $model = $this->contactwidgetFactory->create();
        }
        $data['favorite_name'] = implode(',', $data['favorite_name']);
        $contactwidget = $this->contactwidgetInterfaceFactory->create();
        $contactwidget->setData($data);
        $this->imageData($model, $data);
        $this->contactwidgetRepository->save($contactwidget);
        $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Get Image Data
     *
     * @param Contactwidget $model
     * @param array $data
     * @return mixed
     * @throws LocalizedException
     */
    public function imageData($model, $data): mixed
    {
        if ($model->getEntityId()) {
            $pageData = $this->contactwidgetRepository->get($model->getContactwidgetId());
            if (isset($data['attachment'][0]['name'])) {
                $imageName1 = $pageData->getAttachment();
                $imageName2 = $data['attachment'][0]['name'];
                if ($imageName1 != $imageName2) {
                    $imageUrl = $data['attachment'][0]['url'];
                    $imageName = $data['attachment'][0]['name'];
                    $data['attachment'] = $this->imageUploader->saveMediaImage($imageName, $imageUrl);
                } else {
                    $data['attachment'] = $data['attachment'][0]['name'];
                }
            } else {
                $data['attachment'] = '';
            }
        } else {
            if (isset($data['attachment'][0]['name'])) {
                $imageUrl = $data['attachment'][0]['url'];
                $imageName = $data['attachment'][0]['name'];
                $data['attachment'] = $this->imageUploader->saveMediaImage($imageName, $imageUrl);
            }
        }
        $model->setData($data);
        return $model;
    }
}

