<?php

namespace Wbcom\StoreLocator\Model\ResourceModel;

class Store extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_idFieldName = 'id';
    /**
     * Initialize construct
     */
    public function _construct()
    {
        $this->_init("wbcom_store", "id");
    }
}
