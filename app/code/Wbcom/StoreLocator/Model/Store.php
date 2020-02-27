<?php

namespace Wbcom\StoreLocator\Model;


class Store extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize construct
     */
    public function _construct()
    {
        $this->_init("Wbcom\StoreLocator\Model\ResourceModel\Store");
    }
}
