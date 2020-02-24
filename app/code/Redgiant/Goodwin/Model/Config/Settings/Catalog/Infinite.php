<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Catalog;

class Infinite implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Disable')], 
            ['value' => 2, 'label' => __('Load More')], 
            ['value' => 3, 'label' => __('Infinite Scroll')]
        ];
    }

    public function toArray()
    {
        return [
            1 => __('Disable'),
            2 => __('Load More'),
            3 => __('Infinite Scroll')
        ];
    }
}