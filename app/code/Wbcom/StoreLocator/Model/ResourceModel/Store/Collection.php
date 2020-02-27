<?php

namespace Wbcom\StoreLocator\Model\ResourceModel\Store;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Initialize construct
     */
    public function _construct()
    {
        $this->_init(
            'Wbcom\StoreLocator\Model\Store',
            'Wbcom\StoreLocator\Model\ResourceModel\Store'
        );
    }
}
