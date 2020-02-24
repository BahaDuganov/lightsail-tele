<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Header;

class Notice implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('No')], 
            ['value' => 'above_header', 'label' => __('Above of Header')], 
            ['value' => 'below_header', 'label' => __('Below of Header')]
        ];
    }

    public function toArray()
    {
        return [
            '' => __('No'), 
            'above_header' => __('Above of Header'), 
            'below_header' => __('Below of Header')
        ];
    }
}