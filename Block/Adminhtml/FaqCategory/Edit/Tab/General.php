<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Adminhtml\Faqcategory\Edit\Tab;

class General extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Active or InActive
     *
     * @var \Alsurmedia\Faq\Model\Config\Source\IsActive
     */
    protected $_status;

    /**
     * Yes or No
     *
     * @var \Alsurmedia\Faq\Model\Config\Source\Yesno
     */
    protected $_yesNo;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Alsurmedia\Faq\Model\Config\Source\Yesno $yesNo
     * @param \Alsurmedia\Faq\Model\Config\Source\IsActive $status
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Alsurmedia\Faq\Model\Config\Source\Yesno $yesNo,
        \Alsurmedia\Faq\Model\Config\Source\IsActive $status,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        $this->_yesNo    = $yesNo;
        $this->_status   = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setActive(true);
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }


    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);

        $this->_addElementTypes($fieldset);

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'faqcat_is_active',
                'label' => __('Status'),
                'title' => __('Status'),
                'required' => true,
                'values' => $this->_status->getStatusOptions()
            ]
        );

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'faqcat_title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Category icon'),
                'title' => __('Category icon'),
                'note'  => __('Allow image type: jpg, jpeg, gif, png')
            ]
        );

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
                'size' => '10'
            ]
        );

        $formData = $this->_coreRegistry->registry('alsurmedia_faqcategory');
        if ($formData) {
            if ($formData->getCategoryId()) {
                $fieldset->addField(
                    'category_id',
                    'hidden',
                    ['name' => 'category_id']
                );
            }
            if ($formData->getIsActive() == null) {
                $formData->setIsActive('1');
            }
            $form->setValues($formData->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
