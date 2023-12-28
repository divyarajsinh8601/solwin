<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Controller\Adminhtml\Contactwidget;

use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Solwin\Contactwidget\Controller\Adminhtml\Contactwidget;

class Delete extends Contactwidget
{

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('contactwidget_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\Solwin\Contactwidget\Model\Contactwidget::class);
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the Contactwidget.'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['contactwidget_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Contactwidget to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}

