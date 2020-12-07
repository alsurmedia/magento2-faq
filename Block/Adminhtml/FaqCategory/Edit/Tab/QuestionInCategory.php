<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */



namespace Alsurmedia\Faq\Block\Adminhtml\Faqcategory\Edit\Tab;

class QuestionInCategory extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Active or InActive
     *
     * @var \Alsurmedia\Faq\Model\Config\Source\IsActive
     */
    protected $_status;

    /**
     * @var \Alsurmedia\Faq\Model\Faq
     */
    protected $_faqModel;

    /**
     * @var array
     */
    protected $_optionLocales;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Alsurmedia\Faq\Model\Faq $faqModel,
        \Magento\Framework\Registry $coreRegistry,
        \Alsurmedia\Faq\Model\Config\Source\IsActive $status,
        array $data = []
    ) {
        $this->_faqModel = $faqModel;
        $this->_coreRegistry = $coreRegistry;
        $this->_status = $status;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('region_tab_grid');
        $this->setDefaultSort('faq_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_faqModel->getCollection();
        if ($category_id = $this->getRequest()->getParam('category_id')) {
            $collection->getSelect()->join(['fcat' => 'alsurmedia_faq_category_id'], 'main_table.faq_id = fcat.faq_id', ['category_id'])->where('fcat.category_id =?', (int) $category_id);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'type' => 'text'
            ]
        );

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => $this->_status->getStatusOptions(1)
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Action'),
                'type' => 'action',
                'getter' => 'getFaqId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/faq/edit'
                        ],
                        'field' => 'faq_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/faqcategory/question', ['_current' => true]);
    }
}
