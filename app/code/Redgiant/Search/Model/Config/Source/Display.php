<?php
namespace Redgiant\Search\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Display
 * @package Redgiant\Search\Model\Config\Source
 */
class Display implements ArrayInterface
{
    const DISPLAY_PRICE = 'price';
    const DISPLAY_IMAGE = 'image';
    const DISPLAY_DESCRIPTION = 'description';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::DISPLAY_PRICE       => __('Price'),
            self::DISPLAY_IMAGE       => __('Image'),
            self::DISPLAY_DESCRIPTION => __('Short Description')
        ];
    }
}
