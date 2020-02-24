<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Catalog;

class Columns implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 2, 'label' => __('2 Columns')], 
            ['value' => 3, 'label' => __('3 Columns')], 
            ['value' => 4, 'label' => __('4 Columns')], 
        ];
    }

    public function toArray()
    {
        return [
            2 => __('2'),
            3 => __('3'),
            4 => __('4'),
        ];
    }
}