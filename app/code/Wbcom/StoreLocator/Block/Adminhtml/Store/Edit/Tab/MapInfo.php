<?php

namespace Wbcom\StoreLocator\Block\Adminhtml\Store\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;

class MapInfo extends Generic implements TabInterface{
    /**
     * @var Config
     */
    protected $_wysiwygConfig;
    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $_websiteFactory;
    /**
     * @var \Magento\Backend\Block\Widget\Form\Renderer\Fieldset
     */
    protected $_rendererFieldset;

    protected $_country;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Magento\Store\Model\WebsiteFactory $websiteFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Backend\Block\Widget\Form\Renderer\Fieldset $rendererFieldset,
        \Magento\Directory\Model\Config\Source\Country $country,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_coreSession = $coreSession;
        $this->_websiteFactory = $websiteFactory;
        $this->_rendererFieldset = $rendererFieldset;
        $this->_country = $country;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('store');
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Map Details')]
        );
        $fieldset->addField(
            "zoom_level",
            'text',
            [
                'name' => 'zoom_level',
                'label' => __('Zoom Level'),
                'comment' => __('Zoom Level'),
                'required' => true,
                'class' => 'validate-number validate-not-negative-number validate-greater-than-zero validate-integer'
            ]
        );
        $fieldset->addField(
            "lattitude",
            'text',
            [
                'name' => 'lattitude',
                'label' => __('Lattitude'),
                'comment' => __('Lattitude'),
                'required' => true,
                'class' => 'validate-number'
            ]
        );
        $fieldset->addField(
            "longitude",
            'text',
            [
                'name' => 'longitude',
                'label' => __('Longitude'),
                'comment' => __('Longitude'),
                'required' => true,
                'class' => 'validate-number'
            ]
        );
        /*codes for store map*/
       /* $fieldset->addField(
            'map',
            'text',
            [
                'name' => 'map',
                'label' => __('Store Status'),
                'title' => __('Store Status')
            ]
        )->setRenderer($this->_rendererFieldset->setTemplate('Wbcom_StoreLocator::map.phtml'));*/

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabLabel()
    {
        return __('Store');
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabTitle()
    {
        return __('Store');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
