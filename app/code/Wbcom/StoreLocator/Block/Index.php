<?php

namespace Wbcom\StoreLocator\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Wbcom\StoreLocator\Model\StoreFactory
     */
    protected $storesFactory;
    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_coreSession;

    /**
     * Index constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Wbcom\StoreLocator\Model\StoreFactory $storesFactory
     * @param \Magento\Framework\Session\SessionManagerInterface $coreSession
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Wbcom\StoreLocator\Model\StoreFactory $storesFactory,
        \Magento\Framework\Session\SessionManagerInterface $coreSession
    )
    {
        $this->formKey = $formKey;
        $this->storesFactory = $storesFactory;
        $this->_objectManager = $objectmanager;
        $this->_scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_coreSession = $coreSession;
        parent::__construct($context);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl(){
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();
        return $baseUrl;
    }

    /**
     * @return array
     */
    public function getStoreConfigurationData(){
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

    public function getMainStoreDetails(){
        $storeData = [];
        $storeData['main_store_name'] = $this->_scopeConfig->getValue('wbstore/general/main_store_name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['main_store_description'] = $this->_scopeConfig->getValue('wbstore/general/main_store_description', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['main_store_mobile'] = $this->_scopeConfig->getValue('wbstore/general/main_store_mobile', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $storeData['main_store_email'] = $this->_scopeConfig->getValue('wbstore/general/main_store_email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $storeData;
    }
    /**
     * @return array
     */
    public function getStoresList(){
        $postParams = $this->getPostParams();
        $storeList = $this->storesFactory->create()->getCollection()
            ->addFieldToFilter('status', 'Active');
        if (!empty($postParams)){
            if (isset($postParams['store-text'])) {
                $storeList->addFieldToFilter(
                    array('store_name', 'store_description'),
                    array(
                        array('like' => '%' . $postParams['store-text'] . '%'),
                        array('like' => '%' . $postParams['store-text'] . '%')
                    )
                );
            }
            if (isset($postParams['country'])) {
                $storeList->addFieldToFilter(
                    array('country'),
                    array(
                        array('like' => '%' . $postParams['country'] . '%')
                    )
                );
            }
            if (isset($postParams['state'])) {
                $storeList->addFieldToFilter(
                    array('state'),
                    array(
                        array('like' => '%' . $postParams['state'] . '%')
                    )
                );
            }
            if (isset($postParams['city'])) {
                $storeList->addFieldToFilter(
                    array('city'),
                    array(
                        array('like' => '%' . $postParams['city'] . '%')
                    )
                );
            }
            if (isset($postParams['zipcode'])) {
                $storeList->addFieldToFilter(
                    array('zipcode'),
                    array(
                        array('like' => '%' . $postParams['zipcode'] . '%')
                    )
                );
            }
            if ((isset($postParams['min-range'])) && (isset($postParams['max-range']))) {
                $listStore = $storeList->getData();
                $mapSession = $this->getMapSession();
                $storeNewList = [];
                if ((!empty($mapSession)) && (!empty($mapSession['latitude'])) && (!empty($mapSession['longitude']))){
                    foreach ($listStore as $data){
                        $distance = $this->distance($data,$mapSession);
                        if (($postParams['min-range'] <= $distance) && ($distance <= $postParams['max-range'])){
                            $storeNewList[] = $data;
                        }
                    }
                    return $storeNewList;
                }
            }
        }
        $storeList = $storeList->getData();
        return $storeList;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaBaseUrl(){
        $pubMedia = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $pubMedia;
    }

    /**
     * @return array
     */
    public function getWeekList(){
        $week = array(
            "Sun"=>'sunday',
            "Mon"=>'monday',
            "Tue"=>'tuesday',
            "Wed"=>'wesnesday',
            "Thu"=>'thursday',
            "Fri"=>'friday',
            "Sat"=>'saturday',
        );
        return $week;
    }

    /**
     * @return string
     */
    public function getPlaceholderImage() {
        return sprintf('<img src="%s" class="wb-image"/>', $this->getViewFileUrl('Magento_Catalog::images/product/placeholder/thumbnail.jpg'));
    }

    /**
     * @return string
     */
    public function getFormKey(){
        return $this->formKey->getFormKey();
    }

    /**
     * @return array
     */
    public function getPostParams(){
        $data = $this->getRequest()->getParams();
        if ((!empty($data)) && (isset($data['latitude']))){
            $location = $this->getMapSession();
            if ((empty($location)) || (empty($location['latitude']))){
                $this->setMapSession($data);
            }
        }
        return $data;
    }

    /**
     * @param $data
     */
    public function setMapSession($data){
        $this->_coreSession->start();
        $location = [];
        $location['latitude'] = $data['latitude'];
        $location['longitude'] = $data['longitude'];
        $this->_coreSession->unsLocation();
        $this->_coreSession->setLocation($location);
    }

    /**
     * @return mixed
     */
    public function getMapSession(){
        $this->_coreSession->start();
        return $this->_coreSession->getLocation();
    }

    /**
     * @param $data
     * @param $mapSession
     * @return float|int
     */
    public function distance($data,$mapSession) {
        $lat1 = $data['lattitude'];
        $lon1 = $data['longitude'];
        $lat2 = $mapSession['latitude'];
        $lon2 = $mapSession['longitude'];
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            return ($miles * 1.609344);
        }
    }

    public function getCountryList(){
       return $this->_objectManager->create('Wbcom\StoreLocator\Helper\Data')->getCountryList();
    }
}

