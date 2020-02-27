<?php

namespace Wbcom\StoreLocator\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_objectManager;

    protected $_logger;

    protected $_scopeConfig;

    protected $storeManager;

    protected $country;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Directory\Model\Config\Source\Country $country,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->country = $country;
        $this->_objectManager = $objectManager;
        $this->_scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getConfigData(){
        $storeData = [];
        $storeData['title'] = $this->_scopeConfig->getValue('wbstore/general/page_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['pageHeading'] = $this->_scopeConfig->getValue('wbstore/general/page_heading', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['lattitude'] = $this->_scopeConfig->getValue('wbstore/general/lattitude', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['longitude'] = $this->_scopeConfig->getValue('wbstore/general/longititude', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['googleApi'] = $this->_scopeConfig->getValue('wbstore/general/apikey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['zoomLevel'] = $this->_scopeConfig->getValue('wbstore/general/mapzoom', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['min-range'] = $this->_scopeConfig->getValue('wbstore/filter/min_range', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['max-range'] = $this->_scopeConfig->getValue('wbstore/filter/max_range', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['average-range'] = $this->_scopeConfig->getValue('wbstore/filter/average_range', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $storeData;
    }

    public function getCountryList(){
        return $this->country->toOptionArray(false);
    }
}
