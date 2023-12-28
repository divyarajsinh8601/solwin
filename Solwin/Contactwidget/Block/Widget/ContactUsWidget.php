<?php
/**
 * Solwin Infotech
 * Solwin Contact Form Widget Extension
 *
 * @category   Solwin
 * @package    Solwin_Contactwidget
 * @copyright  Copyright © 2006-2020 Solwin (https://www.solwininfotech.com)
 * @license    https://www.solwininfotech.com/magento-extension-license/
 */
namespace Solwin\Contactwidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Widget\Block\BlockInterface;

class ContactUsWidget extends Template implements BlockInterface
{
    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setTemplate('widget/custom_widget.phtml');
    }

    /**
     * Get form action url
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('contactwidget/widget/index');
    }

    /**
     * Get config value
     */
    public function getConfigValue($value = '')
    {
        return $this->_scopeConfig
                ->getValue(
                    $value,
                    ScopeInterface::SCOPE_STORE
                );
    }
}
