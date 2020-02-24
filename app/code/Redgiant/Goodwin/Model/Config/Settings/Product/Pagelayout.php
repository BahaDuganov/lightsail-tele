<?php
namespace Redgiant\Goodwin\Model\Config\Settings\Product;

class Pagelayout implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('Default')],
            ['value' => 'fixed_image', 'label' => __('Fixed Image')],
            ['value' => 'fixed_content', 'label' => __('Fixed Content')],
            ['value' => 'full_width_image', 'label' => __('Full Width Image')],
            ['value' => 'vertical_gallery', 'label' => __('Vertical Gallery')],
            ['value' => 'vertical_gallery_right', 'label' => __('Vertical Gallery Right')]
        ];
    }

    public function toArray()
    {
        return [
            'default' => __('Default'),
            'fixed_image' => __('Fixed Image'),
            'fixed_content' => __('Fixed Content'),
            'full_width_image' => __('Full Width Image'),
            'vertical_gallery' => __('Vertical Gallery'),
            'vertical_gallery_right' => __('Vertical Gallery Right')
        ];
    }
}