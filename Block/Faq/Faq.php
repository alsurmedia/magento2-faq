<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Faq;

use Magento\Framework\View\Element\Template\Context;
use Alsurmedia\Faq\Helper\Question as QuestionHelper;
use Alsurmedia\Faq\Helper\Category as CategoryHelper;
use Alsurmedia\Faq\Model\ResourceModel\Faq as FaqResourceModel;
use Magento\Framework\App\Filesystem\DirectoryList;
use Alsurmedia\Faq\Helper\Config as ConfigHelper;
use Magento\Cms\Model\Template\FilterProvider;

class Faq extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Alsurmedia\Faq\Helper\Question
     */
    protected $_questionHelper;

    /**
     * @var \Alsurmedia\Faq\Helper\Category
     */
    protected $_categoryHelper;

    /**
     * @var \Alsurmedia\Faq\Model\ResourceModel\Faq
     */
    protected $_faqResourceModel;

    /**
     *
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;

    /**
     * @var array
     */
    protected $_faqCategoriesList = null;

    /**
     * @var \Alsurmedia\Faq\Helper\Config
     */
    protected $_configHelper;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     *
     * @param Context $context
     * @param QuestionHelper $questionHelper
     * @param CategoryHelper $categoryHelper
     * @param DirectoryList $directoryList
     * @param FaqResourceModel $faqResourceModel
     * @param ConfigHelper $configHelper
     * @param FilterProvider $filterProvider
     */
    public function __construct(
        Context $context,
        QuestionHelper $questionHelper,
        CategoryHelper $categoryHelper,
        DirectoryList $directoryList,
        FaqResourceModel $faqResourceModel,
        ConfigHelper $configHelper,
        FilterProvider $filterProvider
    ) {
        $this->_questionHelper = $questionHelper;
        $this->_categoryHelper = $categoryHelper;
        $this->_directoryList = $directoryList;
        $this->_faqResourceModel = $faqResourceModel;
        $this->_configHelper = $configHelper;
        $this->filterProvider = $filterProvider;
        parent::__construct($context);
    }

    /**
     *
     * @return parent
     */
    protected function _prepareLayout()
    {
        $this->_faqCategoriesList = $this->_categoryHelper->getCategoriesList();

        $this->pageConfig->getTitle()->set(__('Frequently Asked Questions'));

        $this->pageConfig->setKeywords(__('Frequently Asked Questions'));

        $this->pageConfig->setDescription(__('Frequently Asked Questions'));

        $breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs');

        $breadcrumbBlock->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Home'),
                'link' => $this->_storeManager->getStore()->getBaseUrl(),
            ]
        );

        $breadcrumbBlock->addCrumb(
            'faq',
            [
                'label' => __('Frequently Asked Questions'),
                'title' => __('Frequently Asked Questions')
            ]
        );

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
     * Get the questions most frequently
     *
     * @return array|bool
     */
    public function getFrequentlyAskedQuestion()
    {
        return $this->getFaq(1);
    }

    /**
     * Get the lastest questions
     *
     * @return array|bool
     */
    public function getLastestFAQ()
    {
        return $this->getFaq(null, 1);
    }

    /**
     * Get the questions
     *
     * @return array|bool
     */
    public function getFaq($frequently = null, $lastest = null)
    {
        $select = $this->_faqResourceModel->getConnection()->select()
            ->from(['faq' => $this->_faqResourceModel->getMainTable()])
            ->joinLeft(
                ['faq_store' => $this->_faqResourceModel->getTable('alsurmedia_faq_store')],
                'faq.faq_id = faq_store.faq_id',
                ['store_id']
            )
            ->where('faq_store.store_id =?', $this->_storeManager->getStore()->getStoreId())
            ->where('faq.is_active = ?', '1');

        if ($frequently) {
            $select->where('faq.most_frequently = ?', '1');
        }

        $select->group('faq.faq_id');

        if ($frequently) {
            $select->order('faq.sort_order ASC');
        }

        if ($lastest) {
            $select->where('faq.most_frequently <> ?', '1');
            $select->order('faq.faq_id DESC');
        }

        $select->limit(8);

        if ($results = $this->_faqResourceModel->getConnection()->fetchAll($select)) {
            return $results;
        }
        return false;
    }

    /**
     * Get the list of categories
     *
     * @return array|bool
     */
    public function getFaqCategoriesList()
    {
        return $this->_faqCategoriesList;
    }

    /**
     * Get URL of the category
     *
     * @param $identifier
     * @return string
     */
    public function getFaqcategoryFullPath($identifier)
    {
        return $this->_configHelper->getFaqcategoryFullPath($identifier);
    }

    /**
     * Get URL of the files in pub/media folder
     *
     * @param $path
     * @return string
     */
    public function getFileBaseUrl($path)
    {
        return $this->_configHelper->getFileBaseUrl($path);
    }

    /**
     * Get URL of the question
     *
     * @param $identifier
     * @return string
     */
    public function getFaqFullPath($identifier)
    {
        return $this->_configHelper->getFaqFullPath($identifier);
    }
}
