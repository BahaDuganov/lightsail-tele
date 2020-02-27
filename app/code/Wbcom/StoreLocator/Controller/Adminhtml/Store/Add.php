<?php

namespace Wbcom\StoreLocator\Controller\Adminhtml\Store;

use Wbcom\StoreLocator\Model\StoreFactory;
use Magento\Framework\Registry;

class Add extends \Magento\Backend\App\Action
{
    /**
     * @var Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * Add constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param Registry $registry
     * @param StoreFactory $storeFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Session\SessionManagerInterface $coreSession
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Registry $registry,
        storeFactory $storeFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Session\SessionManagerInterface $coreSession
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->storeFactory = $storeFactory;
        $this->_coreSession = $coreSession;
    }

    public function execute()
    {
        $storeId = $this->getRequest()->getParam('id');
        $model= $this->storeFactory->create();
        $model->load($storeId);
        $this->_coreRegistry->register('store', $model);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Wbcom_StoreLocator::add_store');
        $resultPage->getConfig()->getTitle()->prepend(__('Add Store'));
        return $resultPage;
    }
}
