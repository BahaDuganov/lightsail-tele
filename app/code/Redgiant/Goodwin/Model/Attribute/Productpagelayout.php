<?php
namespace Redgiant\Goodwin\Model\Attribute;

class Productpagelayout extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '', 'label' => __('-')], 
                ['value' => 'default', 'label' => __('Default')],
                ['value' => 'fixed_image', 'label' => __('Fixed Image')],
                ['value' => 'fixed_content', 'label' => __('Fixed Content')],
                ['value' => 'full_width_image', 'label' => __('Full Width Image')],
                ['value' => 'vertical_gallery', 'label' => __('Vertical Gallery')],
                ['value' => 'vertical_gallery_right', 'label' => __('Vertical Gallery Right')]
            ];
        }
        
        return $this->_options;
    }
}
