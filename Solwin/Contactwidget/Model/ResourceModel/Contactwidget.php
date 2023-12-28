<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Contactwidget extends AbstractDb
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('solwin_contactwidget_demo', 'contactwidget_id');
    }
}

