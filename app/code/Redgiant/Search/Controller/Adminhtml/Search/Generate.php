<?php
/*
 */

namespace Redgiant\Search\Controller\Adminhtml\Search;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Redgiant\Search\Helper\Data;

/**
 * Class Generate
 * @package Redgiant\Search\Controller\Adminhtml\Search
 */
class Generate extends Action
{
    /**
     * @var \Redgiant\Search\Helper\Data
     */
    protected $moduleHelper;

    /**
     * Generate constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Redgiant\Search\Helper\Data $dataHelper
     */
    public function __construct(
        Context $context,
        Data $dataHelper
    )
    {
        $this->moduleHelper = $dataHelper;

        parent::__construct($context);
    }

    /**
     * execute js file data for all store & customer group
     * then redirect back to the system page
     */
    public function execute()
    {
        $errors = $this->moduleHelper->createJsonFile();
        if (empty($errors)) {
            $this->messageManager->addSuccessMessage(__('Generate search data successfully.'));
        } else {
            foreach ($errors as $error) {
                $this->messageManager->addErrorMessage($error);
            }
        }

        $this->_redirect('adminhtml/system_config/edit/section/rgsearch');
    }
}