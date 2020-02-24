<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Installation;

class Demoversion implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => __('All')], 
            ['value' => 'demo01', 'label' => __('Demo 1 - Fashion 1')], 
            ['value' => 'demo02', 'label' => __('Demo 2 - Fashion 2')], 
            ['value' => 'demo03', 'label' => __('Demo 3 - Electronics 1')], 
            ['value' => 'demo04', 'label' => __('Demo 4 - Electronics 2')], 
            ['value' => 'demo05', 'label' => __('Demo 5 - Furniture')], 
            ['value' => 'demo06', 'label' => __('Demo 6 - Nutrition')], 
            ['value' => 'demo07', 'label' => __('Demo 7 - Sport')], 
            ['value' => 'demo08', 'label' => __('Demo 8 - Tools')],
            ['value' => 'demo09', 'label' => __('Demo 9 - Watches')],
            ['value' => 'demo10', 'label' => __('Demo 10 - T-Shirts')],
            ['value' => 'demo11', 'label' => __('Demo 11 - Toys 1 (Slides)')],
            ['value' => 'demo12', 'label' => __('Demo 12 - Toys 2')],
            ['value' => 'demo13', 'label' => __('Demo 13 - Plumbing')],
            ['value' => 'demo14', 'label' => __('Demo 14 - RTL')]
        ];
    }

    public function toArray()
    {
        return [
            '0' => __('All'), 
            'demo01' => __('Demo 1 - Fashion 1'), 
            'demo02' => __('Demo 2 - Fashion 2'), 
            'demo03' => __('Demo 3 - Electronics 1'), 
            'demo04' => __('Demo 4 - Electronics 2'), 
            'demo05' => __('Demo 5 - Furniture'), 
            'demo06' => __('Demo 6 - Nutrition'), 
            'demo07' => __('Demo 7 - Sport'),
            'demo08' => __('Demo 8 - Tools'),
            'demo09' => __('Demo 9 - Watches'),
            'demo10' => __('Demo 10 - T-Shirts'),
            'demo11' => __('Demo 11 - Toys 1 (Slides)'),
            'demo12' => __('Demo 12 - Toys 2'),
            'demo13' => __('Demo 13 - Plumbing'),
            'demo14' => __('Demo 14 - RTL'),
        ];
    }
}
