<?php

namespace Wbcom\StoreLocator\Controller\Adminhtml\Store;
use Wbcom\StoreLocator\Model\StoreFactory;
use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var bool
     */
    protected $resultPageFactory = false;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * Delete constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param StoreFactory $storeFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        StoreFactory $storeFactory
    )
    {
        parent::__construct($context);
        $this->_resultFactory = $context->getResultFactory();
        $this->storeFactory = $storeFactory;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->storeFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__("Store deleted successfully."));
            } catch (\Exception $e) {
                $this->messageManager->addError('Something went wrong '.$e->getMessage());
            }
        }else{
            $this->messageManager->addError('Store not found, please try once more.');
        }
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('wbstore/store/index');
        return $resultRedirect;
    }
}
