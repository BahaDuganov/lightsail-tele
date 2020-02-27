<?php
namespace Wbcom\StoreLocator\Controller\Adminhtml\Store;

class MassDelete extends \Magento\Backend\App\Action {
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_filter;
    /**
     * @var \Wbcom\StoreLocator\Model\ResourceModel\Store\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * MassDelete constructor.
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Wbcom\StoreLocator\Model\ResourceModel\Store\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Wbcom\StoreLocator\Model\ResourceModel\Store\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute() {
        try{
            $collection = $this->_filter->getCollection($this->_collectionFactory->create());
            $itemsDelete = 0;
            foreach ($collection as $item) {
                $item->delete();
                $itemsDelete++;
            }
            $this->messageManager->addSuccess(__('A total of %1 store(s) were deleted successfully.', $itemsDelete));
        }catch(Exception $e){
            $this->messageManager->addError('Something went wrong while deleting the store '.$e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wbstore/store/index');
    }


    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Wbcom_StoreLocator::view');
    }
}