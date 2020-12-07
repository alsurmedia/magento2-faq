<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Category;

use Magento\Framework\View\Element\Template\Context;
use Alsurmedia\Faq\Helper\Category as CategoryHelper;
use Alsurmedia\Faq\Helper\Question as QuestionHelper;
use Alsurmedia\Faq\Helper\Config as ConfigHelper;
use Alsurmedia\Faq\Model\ResourceModel\Faq as FaqResourceModel;
use Alsurmedia\Faq\Model\ResourceModel\Faqcategory as FaqCatResourceModel;
use Magento\Cms\Model\Template\FilterProvider;

class Category extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Alsurmedia\Faq\Model\ResourceModel\Faqcategory
     */
    protected $_faqCatResourceModel;

    /**
     * @var \Alsurmedia\Faq\Model\ResourceModel\Faq
     */
    protected $_faqResourceModel;

    /**
     * @var \Alsurmedia\Faq\Helper\Category
     */
    protected $_categoryHelper;

    /**
     * @var array
     */
    protected $_faqCategoryTitle = null;

    /**
     * @var \Alsurmedia\Faq\Helper\Config
     */
    protected $_configHelper = null;

    /**
     * @var string
     */
    protected $_faqCategoryIcon = null;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CategoryHelper $categoryHelper
     * @param Config $pageConfig
     * @param FaqCatResourceModel $faqCatResourceModel
     * @param FaqResourceModel $faqResourceModel
     * @param ConfigHelper $configHelper
     * @param FilterProvider $filterProvider
     */
    public function __construct(
        Context $context,
        CategoryHelper $categoryHelper,
        FaqCatResourceModel $faqCatResourceModel,
        FaqResourceModel $faqResourceModel,
        ConfigHelper $configHelper,
        FilterProvider $filterProvider
    ) {
        $this->_categoryHelper = $categoryHelper;
        $this->_faqCatResourceModel = $faqCatResourceModel;
        $this->_faqResourceModel = $faqResourceModel;
        $this->_configHelper = $configHelper;
        $this->filterProvider = $filterProvider;
        parent::__construct($context);
    }

    /**
     * Get FAQs Category
     * @param $category_id
     * @return array|null
     */
    protected function getFaqcategory()
    {
        return $this->_faqCatResourceModel->getFaqcategoryStore($this->getRequest()->getParam('category_id'));
    }

    /**
     *
     * @return parent
     */
    protected function _prepareLayout()
    {
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');

        $breadcrumbsBlock->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl()
            ]
        );

        $breadcrumbsBlock->addCrumb(
            'faq',
            [
                'label' => __('Frequently Asked Questions'),
                'title' => __('Go to FAQs Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_REQUEST_PATH
            ]
        );

        $faqCategory = $this->getFaqcategory();

        $this->_faqCategoryTitle = __($faqCategory['title']);

        $this->_faqCategoryIcon = $faqCategory['image'];

        $breadcrumbsBlock->addCrumb(
            'faq.category',
            [
                'label' => __($faqCategory['title']),
                'title' => __($faqCategory['title'])
            ]
        );

        $this->pageConfig->setKeywords($faqCategory['meta_keywords']? __($faqCategory['meta_keywords']) : $this->_faqCategoryTitle);

        $this->pageConfig->setDescription($faqCategory['meta_description']? __($faqCategory['meta_description']) : $this->_faqCategoryTitle);

        return parent::_prepareLayout();
    }

    /**
     * Filter provider
     *
     * @param string $content
     * @return string
     */
    public function filterProvider($content)
    {
        return $this->filterProvider->getBlockFilter()
            ->setStoreId($this->_storeManager->getStore()->getId())
            ->filter($content);
    }

    /**
     * Get Category Icon
     *
     * @return string|null
     */
    public function getFaqcategoryIcon()
    {
        return !empty($this->_faqCategoryIcon) ? $this->_configHelper->getFileBaseUrl('alsurmedia/faq/category/'.$this->_faqCategoryIcon) : '';
    }

    /**
     * Get Category Title
     *
     * @return string|null
     */
    public function getFaqcategoryTitle()
    {
        return $this->_faqCategoryTitle;
    }

    /**
     * Get URL of the category
     *
     * @param $identifier
     * @return string|null
     */
    public function getFaqcategoryFullPath($identifier)
    {
        return $this->_configHelper->getFaqcategoryFullPath($identifier);
    }

    /**
     * Get FAQs List
     *
     * @param $category_id
     * @return array|null
     */
    public function getFaqsList()
    {
        return $this->_faqResourceModel->getRelatedQuestion(null, (int) $this->getRequest()->getParam('category_id'));
    }

    /**
     * Get URL of the question
     *
     * @param $identifier
     * @return string|null
     */
    public function getFaqFullPath($identifier)
    {
        return $this->_configHelper->getFaqFullPath($identifier);
    }

    /**
     * Get Short Description of the question
     *
     * @param $content, $identifier
     * @return string|null
     */
    public function getFaqShortDescription($content, $identifier)
    {
        return $this->_configHelper->getFaqShortDescription($content, $identifier);
    }
}
