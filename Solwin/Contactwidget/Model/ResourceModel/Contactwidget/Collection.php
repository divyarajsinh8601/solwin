<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Model\ResourceModel\Contactwidget;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Solwin\Contactwidget\Model\Contactwidget;
use Solwin\Contactwidget\Model\ResourceModel\Contactwidget as ContactwidgetResourceModel;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'contactwidget_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Contactwidget::class,
            ContactwidgetResourceModel::class
        );
    }
}

