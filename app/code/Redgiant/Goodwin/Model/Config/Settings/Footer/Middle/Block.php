<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Footer\Middle;

class Block implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
    {
        return [['value' => '', 'label' => __('Do not show')], ['value' => 'custom', 'label' => __('Custom Block')]];
    }

    public function toArray()
    {
        return ['' => __('Do not show'), 'custom' => __('Custom Block')];
    }
}