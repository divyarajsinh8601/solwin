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
namespace Solwin\Contactwidget\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class WidgetWidth implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '100%', 'label' => __('100%')],
            ['value' => '75%', 'label' => __('75%')],
            ['value' => '50%', 'label' => __('50%')],
            ['value' => '25%', 'label' => __('25%')]];
    }
}
