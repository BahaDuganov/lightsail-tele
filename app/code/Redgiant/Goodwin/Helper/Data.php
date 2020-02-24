<?php
namespace Redgiant\Goodwin\Helper;

use Magento\Framework\Registry;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_objectManager;
    private $_registry;
    protected $_filterProvider;
    private $_messageManager;
    protected $_configFactory;
    private $_checkedPurchaseCode;
    protected $_categoryHelper;
    protected $_categoryFlatConfig;
    protected $_categoryRepository;
    protected $_localeCurrency;
    protected $_logo;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $configFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        Registry $registry
    ) {
        $this->_storeManager = $storeManager;
        $this->_objectManager = $objectManager;
        $this->_filterProvider = $filterProvider;
        $this->_registry = $registry;
        $this->_messageManager = $messageManager;
        $this->_configFactory = $configFactory;
        $this->_categoryHelper = $categoryHelper;
        $this->_categoryFlatConfig = $categoryFlatState;
        $this->_categoryRepository = $categoryRepository;
        $this->_localecurrency = $localeCurrency;
        $this->_logo = $logo;

        parent::__construct($context);
    }

    public function isAdmin() {
        $om = \Magento\Framework\App\ObjectManager::getInstance(); 
        $app_state = $om->get('\Magento\Framework\App\State');
        $area_code = $app_state->getAreaCode();
        if($area_code == \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get logo image URL
     *
     * @return string
     */
    public function getLogoSrc()
    {    
        return $this->_logo->getLogoSrc();
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getBaseLinkUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getModel($model) {
        return $this->_objectManager->create($model);
    }

    public function getRootCategoryId() {
        return $this->_storeManager->getStore()->getRootCategoryId();
    }

    public function getCurrentStore() {
        return $this->_storeManager->getStore();
    }

    public function filterContent($content) {
        return $this->_filterProvider->getPageFilter()->filter($content);
    }

    public function getCategoryProductIds($current_category) {
        $category_products = $current_category->getProductCollection()
            ->addAttributeToSelect('*')
            //->addAttributeToFilter('is_saleable', 1, 'left')
            ->addAttributeToSort('position','asc');
        $cat_prod_ids = $category_products->getAllIds();
        
        return $cat_prod_ids;
    }

    public function getPrevProduct($product) {
        $current_category = $product->getCategory();
        if(!$current_category) {
            foreach($product->getCategoryCollection() as $parent_cat) {
                $current_category = $parent_cat;
            }
        }
        if(!$current_category)
            return false;
        $cat_prod_ids = $this->getCategoryProductIds($current_category);
        $_pos = array_search($product->getId(), $cat_prod_ids);
        if (isset($cat_prod_ids[$_pos - 1])) {
            $prev_product = $this->getModel('Magento\Catalog\Model\Product')->load($cat_prod_ids[$_pos - 1]);
            return $prev_product;
        }
        return false;
    }

    public function getNextProduct($product) {
        $current_category = $product->getCategory();
        if(!$current_category) {
            foreach($product->getCategoryCollection() as $parent_cat) {
                $current_category = $parent_cat;
            }
        }
        if(!$current_category)
            return false;
        $cat_prod_ids = $this->getCategoryProductIds($current_category);
        $_pos = array_search($product->getId(), $cat_prod_ids);
        if (isset($cat_prod_ids[$_pos + 1])) {
            $next_product = $this->getModel('Magento\Catalog\Model\Product')->load($cat_prod_ids[$_pos + 1]);
            return $next_product;
        }
        return false;
    }

    public function getCurrentProduct() {
        return $this->_registry->registry('current_product');
    }
    public function getColClass($perrow = null) {
        if(!$perrow) {
            $perrow = $this->getConfig('goodwin_settings/catalog/product_per_row');
        }

        switch($perrow){
            case 2:
                return 'col-12 col-sm-6 col-md-6 col-xl-6';
                break;
            case 3:
                return 'col-12 col-sm-6 col-md-4 col-xl-4';
                break;
            case 4:
                return 'col-12 col-sm-6 col-md-4 col-xl-3';
                break;
            case 5:
                return 'col-12 col-sm-6 col-md-4 col-xl-c2';
                break;
            case 6:
                return 'col-12 col-sm-6 col-md-4 col-xl-2';
                break;
        }
        
        return;
    }
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }
    public function getActiveChildCategories($category)
    {
        $children = [];
        if ($this->_categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildrenCategories();
        }
        foreach($subcategories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $children[] = $category;
        }
        return $children;
    }
    public function getSidebarmenuHtml($categoryId = 0, $max_level = 2) {
        $categoryId = $categoryId ? $categoryId : $this->getRootCategoryId();
        $category = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($categoryId);
        $categories = $this->getActiveChildCategories($category);
        $html = "";
        if(count($categories) > 0){
            $html = "<ul>";
            foreach ($categories as $cat) {
                $children = $this->getActiveChildCategories($cat);
                $html .= '<li class="active"><a href="'.$this->_categoryHelper->getCategoryUrl($cat).'" class="level-top">';
                $html .= '<span>'.$cat->getName().'</span></a>';
                if(count($children) > 0) {
                    $html .= '<div class="open-children-toggle"></div>';
                    $html .= $this->getSubmenuHtml($children, 1, $max_level);
                }
                $html .= "</li>";
            }
            $html .= "</ul>";
        }
        return $html;
    }
    public function getSubmenuHtml($children, $level = 1, $max_level) {
        $html = '';
        if(!$max_level || ($max_level && $max_level == 0) || ($max_level && $max_level > 0 && $max_level-1 >= $level)) {
            $html = "<ul class='children'>";
            foreach($children as $child) {
                $cat_model = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($child->getId());
                
                $sub_children = $this->getActiveChildCategories($child);
                $item_class = 'level'.$level.' ';
                if(count($sub_children) > 0)
                    $item_class .= 'parent ';
                $html .= '<li class="ui-menu-item active '.$item_class.'">';
                if(count($sub_children) > 0 && $level < ($max_level - 1)) {
                    $html .= '<div class="open-children-toggle"></div>';
                }
                $html .= '<a href="'.$this->_categoryHelper->getCategoryUrl($child).'">';
                $html .= '<span>'.$child->getName();
                $html .= '</span></a>';
                if(count($sub_children) > 0) {
                    $html .= $this->getSubmenuHtml($sub_children, $level+1, $max_level);
                }
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQuickViewUrl($product_id) {
        return $this->_urlBuilder->getUrl('weltpixel_quickview/catalog_product/view', array('id' => $product_id));
    }

    public function getCurrencySymbol($currency_code) {
        return $this->_localecurrency->getCurrency($currency_code)->getSymbol();
    }
}