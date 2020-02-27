<?php

namespace Wbcom\StoreLocator\Block\Adminhtml\Store\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;

class Info extends Generic implements TabInterface{
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
        $countries = $this->_country->toOptionArray(false);
        $model = $this->_coreRegistry->registry('store');
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information')]
        );
        if($model->getId()){
            $storeIds = json_decode($model->getStoreIds());
            $model->setData("store_ids", $storeIds);
            $fieldset->addField(
                'id',
                'hidden',
                ['name' => 'id']
            );
        }
        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Is Active'),
                'title' => __('Is Active'),
                'class' => 'main_acount',
                'values' => [
                    ['label' => __('No'), 'value' => 'Unactive'],
                    ['label' => __('Yes'), 'value' => 'Active']
                ]
            ]
        );
        $fieldset->addField(
            "store_name",
            'text',
            [
                'name' => 'store_name',
                'label' => __('Store Name'),
                'comment' => __('Store Name'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            "contact_email",
            'text',
            [
                'name' => 'contact_email',
                'label' => __('Store Email'),
                'comment' => __('Store Email'),
                'required' => true,
                'class' => 'validate-email'
            ]
        );
        $fieldset->addField(
            'store_ids',
            'multiselect',
            [
                'name'     => 'store_ids[]',
                'label'    => __('Store Views'),
                'title'    => __('Store Views'),
                'required' => true,
                'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );
        $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Store Image'),
                'label' => __('Store Image'),
                'name' => 'image',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );
        $fieldset->addField(
            'country',
            'select',
            [
                'name' => 'country',
                'label' => __('Country'),
                'required' => true,
                'values' => $countries
            ]
        );
        $fieldset->addField(
            'state', 'text', [
                'name' => 'state',
                'label' => __('State'),
                'id' => 'state',
                'title' => __('State')
            ]
        );
        $fieldset->addField(
            'city', 'text', [
                'name' => 'city',
                'label' => __('City'),
                'id' => 'city',
                'title' => __('City'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'zipcode', 'text', [
                'name' => 'zipcode',
                'label' => __('Zipcode'),
                'id' => 'zipcode',
                'title' => __('Zipcode'),
                'required' => true
            ]
        );
        $fieldset->addField(
            "contact_no",
            'text',
            [
                'name' => 'contact_no',
                'label' => __('Number'),
                'comment' => __('Number'),
                'required' => true,
                'class' => 'validate-number'
            ]
        );
        $fieldset->addField(
            "address",
            'textarea',
            [
                'name' => 'address',
                'label' => __('Address'),
                'comment' => __('Address'),
                'required' => true,
                'note' => 'Please add address in short.'
            ]
        );
        $fieldset->addField(
            "store_description",
            'textarea',
            [
                'name' => 'store_description',
                'label' => __('Store Description'),
                'comment' => __('Store Description'),
                'required' => true,
                'note' => 'Please write your description in keywords (maximum 8-10 keywords)'
            ]
        );

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
