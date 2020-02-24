<?php
namespace Redgiant\Goodwin\Controller\Adminhtml\System\Config;

abstract class Cms extends \Magento\Backend\App\Action {
    protected function _import()
    {
        return $this->_objectManager->get('Redgiant\Goodwin\Model\Import\Cms')
            ->importCms($this->getRequest()->getParam('import_type'), $this->getRequest()->getParam('demo_version'), $this->getRequest()->getParam('overwrite'));
    }
}