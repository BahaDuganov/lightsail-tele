<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Catalog;

class Imagetype implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('Default')], 
            ['value' => 'hover', 'label' => __('Show 2nd Image When Hover')], 
            ['value' => 'gallery', 'label' => __('Show Product Image gallery')]
        ];
    }

    public function toArray()
    {
        return [
            '' => __('Default'),
            'hover' => __('Show 2nd Image When Hover'),
            'gallery' => __('Show Product Image gallery')
        ];
    }
}