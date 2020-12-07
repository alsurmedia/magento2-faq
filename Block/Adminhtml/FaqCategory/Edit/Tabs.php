<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Adminhtml\Faqcategory\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('faqcategory_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Category Information'));
    }

    protected function _beforeToHtml()
    {
        $this->setActiveTab('general_section');
        return parent::_beforeToHtml();
    }

    /**
     * Prepare Layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->addTab(
            'general_section',
            [
                'label' => __('General Information'),
                'content' => $this->getLayout()->createBlock('Alsurmedia\Faq\Block\Adminhtml\Faqcategory\Edit\Tab\General')->toHtml()
            ]
        );

        $this->addTab(
            'optimisation_section',
            [
                'label' => __('Search Engine Optimisation'),
                'content' => $this->getLayout()->createBlock('Alsurmedia\Faq\Block\Adminhtml\Faqcategory\Edit\Tab\SearchEngineOptimisation')->toHtml()
            ]
        );

        $this->addTab(
            'websites_section',
            [
                'label' => __('FAQ Category in Websites'),
                'content' => $this->getLayout()->createBlock('Alsurmedia\Faq\Block\Adminhtml\Faqcategory\Edit\Tab\Websites')->toHtml()
            ]
        );

        if ($this->getRequest()->getParam('category_id')) {
            $this->addTab('question_section', ['label' => __('FAQs in Category'), 'url' => $this->getUrl('*/faqcategory/question', ['_current' => true]), 'class' => 'ajax']);
        }
        return parent::_prepareLayout();
    }
}
