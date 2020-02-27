<?php

namespace Wbcom\StoreLocator\Block\Adminhtml\Store\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    /**
     * Initialize construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('store_create_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Store Information'));
    }

    /**
     * @return WidgetTabs
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'store_create_tabs',
            [
                'label' => __('General Information'),
                'title' => __('General Information'),
                'content' => $this->getLayout()->createBlock(
                    'Wbcom\StoreLocator\Block\Adminhtml\Store\Edit\Tab\Info'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'store_create_tabs_map',
            [
                'label' => __('Map Information'),
                'title' => __('Map Information'),
                'content' => $this->getLayout()->createBlock(
                    'Wbcom\StoreLocator\Block\Adminhtml\Store\Edit\Tab\MapInfo'
                )->toHtml(),
                'active' => false
            ]
        );
        $this->addTab(
            'store_create_tabs_time',
            [
                'label' => __('Working Time'),
                'title' => __('Working Time'),
                'content' => $this->getLayout()->createBlock(
                    'Wbcom\StoreLocator\Block\Adminhtml\Store\Edit\Tab\TimeInfo'
                )->toHtml(),
                'active' => false
            ]
        );
        return parent::_beforeToHtml();
    }
}
