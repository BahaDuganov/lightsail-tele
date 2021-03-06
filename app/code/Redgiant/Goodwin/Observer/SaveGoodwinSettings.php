<?php
namespace Redgiant\Goodwin\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveGoodwinSettings implements ObserverInterface
{
    protected $_messageManager;
    protected $_cssGenerator;

    public function __construct(
        \Redgiant\Goodwin\Model\Cssconfig\Generator $cssenerator,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->_cssGenerator = $cssenerator;
        $this->_messageManager = $messageManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $message = 'Saved Goodwin Settings...';
        $this->_cssGenerator->generateCss('settings', $observer->getData("website"), $observer->getData("store"));
    }
}