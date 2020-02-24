<?php
namespace Redgiant\Goodwin\Block\System\Config\Form\Button\Import;

class Demo extends \Magento\Config\Block\System\Config\Form\Field
{
    protected $_buttonLabel = 'Import';

    protected $_actionUrl;

    protected $_demoVersion;

    private $_helper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Redgiant\Goodwin\Helper\Data $helper
    ) {
        $this->_helper = $helper;

        parent::__construct($context);
    }

    public function setButtonLabel($buttonLabel)
    {
        $this->_buttonLabel = $buttonLabel;

        return $this;
    }

    public function getActionUrl()
    {
        return $this->_actionUrl;
    }

    public function setActionUrl($actionUrl)
    {
        $this->_actionUrl = $actionUrl;

        return $this;
    }

    public function getDemoVersion()
    {
        return $this->_demoVersion;
    }

    public function setDemoVersion($demoVersion)
    {
        $this->_demoVersion = $demoVersion;

        return $this;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/demo_button.phtml');
        }

        return $this;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    public function getDemos()
    {
        return  [
            ['demo_version' => 'demo01', 'label' => __('Demo 1 - Fashion 1')], 
            ['demo_version' => 'demo02', 'label' => __('Demo 2 - Fashion 2')], 
            ['demo_version' => 'demo03', 'label' => __('Demo 3 - Electronics 1')], 
            ['demo_version' => 'demo04', 'label' => __('Demo 4 - Electronics 2')], 
            ['demo_version' => 'demo05', 'label' => __('Demo 5 - Furniture')], 
            ['demo_version' => 'demo06', 'label' => __('Demo 6 - Nutrition')], 
            ['demo_version' => 'demo07', 'label' => __('Demo 7 - Sport')], 
            ['demo_version' => 'demo08', 'label' => __('Demo 8 - Tools')], 
            ['demo_version' => 'demo09', 'label' => __('Demo 9 - Watches')], 
            ['demo_version' => 'demo10', 'label' => __('Demo 10 - T-Shirts')], 
            ['demo_version' => 'demo11', 'label' => __('Demo 11 - Toys 1 (Slides)')], 
            ['demo_version' => 'demo12', 'label' => __('Demo 12 - Toys 2')], 
            ['demo_version' => 'demo13', 'label' => __('Demo 13 - Plumbing')], 
            ['demo_version' => 'demo14', 'label' => __('Demo 14 - RTL')],
        ];
    }
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $buttonLabel = !empty($originalData['button_label']) ? $originalData['button_label'] : $this->_buttonLabel;
        $action = !empty($originalData['action_url']) ? $originalData['action_url'] : '';
        if($action) {
            $this->setActionUrl($action);
        }
        
        $button_class = "";
        $this->addData(
            [
                'button_label' => __($buttonLabel),
                'button_class' => $button_class,
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $this->_urlBuilder->getUrl($action),
            ]
        );
        return $this->_toHtml();
    }
}