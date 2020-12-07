<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Category;

use Magento\Framework\View\Element\Template\Context;
use Alsurmedia\Faq\Helper\Category as CategoryHelper;
use Alsurmedia\Faq\Model\ResourceModel\Faq;
use Alsurmedia\Faq\Helper\Config as ConfigHelper;

class CategorySidebar extends \Magento\Framework\View\Element\Template
{
    /**
     *
     * @var \Alsurmedia\Faq\Helper\Category
     */
    protected $_categoryHelper;

    /**
     * @var array
     */
    protected $_faqCategoriesList;

    /**
     * @var \Alsurmedia\Faq\Helper\Config
     */
    protected $_configHelper;

    /**
     * @param Context $context
     * @param CategoryHelper $categoryHelper
     * @param ConfigHelper $configHelper
     */
    public function __construct(
        Context $context,
        CategoryHelper $categoryHelper,
        ConfigHelper $configHelper
    ) {
        $this->_categoryHelper = $categoryHelper;
        $this->_configHelper = $configHelper;
        parent::__construct($context);
    }

    /**
     *
     * @return parent
     */
    protected function _prepareLayout()
    {
        $this->_faqCategoriesList = $this->_categoryHelper->getCategoriesList();
        return parent::_prepareLayout();
    }

    /**
     * Get List of Categories
     *
     * @return array|null
     */
    public function getFaqCategoriesList()
    {
        return $this->_faqCategoriesList;
    }

    /**
     * Get URL of the category
     *
     * @param $identifier
     * @return array|null
     */
    public function getFaqcategoryFullPath($identifier)
    {
        return $this->_configHelper->getFaqcategoryFullPath($identifier);
    }
}
