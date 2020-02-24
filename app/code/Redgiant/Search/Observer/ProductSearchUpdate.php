<?php
namespace Redgiant\Search\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Redgiant\Search\Helper\Data;
use Redgiant\Search\Model\Config\Source\Reindex;

/**
 * Class ProductSearchUpdate
 * @package Redgiant\Search\Observer
 */
class ProductSearchUpdate implements ObserverInterface
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * ProductSearchUpdate constructor.
     * @param \Redgiant\Search\Helper\Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->_helper = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        if(!$this->_helper->isEnabled()){
            return $this;
        }

        $reindexConfig = $this->_helper->getConfigGeneral('reindex_search');
        if ($reindexConfig == Reindex::TYPE_PRODUCT_SAVE) {
            $this->_helper->getMediaHelper()->removeJsPath();
        }

        return $this;
    }
}