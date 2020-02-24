<?php
namespace Redgiant\Search\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Reindex
 * @package Redgiant\Search\Model\Config\Source
 */
class Reindex implements ArrayInterface
{
    const TYPE_CRON_JOB = 'cronjob';
    const TYPE_PRODUCT_SAVE = 'product_save';
    const TYPE_MANUAL = 'manual';

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
            self::TYPE_CRON_JOB     => __('Cron job'),
            self::TYPE_PRODUCT_SAVE => __('After Product Save'),
            self::TYPE_MANUAL       => __('Manually (used reindex button bellow)')
        ];
    }
}
