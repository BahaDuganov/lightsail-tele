<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Catalog;

class Gridlayout implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('Default')], 
            ['value' => 'isotope', 'label' => __('Isotope Grid')]
        ];
    }

    public function toArray()
    {
        return [
            1 => __('Default'),
            2 => __('Isotope Grid')
        ];
    }
}