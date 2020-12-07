<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Helper;

/**
 * Category Helper
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class Category extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Alsurmedia\Faq\Model\ResourceModel\Faqcategory
     */
    protected $_faqCatResourceModel;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Alsurmedia\Faq\Model\ResourceModel\Faqcategory $faqCatResourceModel
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Alsurmedia\Faq\Model\ResourceModel\Faqcategory $faqCatResourceModel,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_faqCatResourceModel     = $faqCatResourceModel;
        $this->_storeManager    = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get the list of categories
     *
     * @return array|null
     */
    public function getCategoriesList()
    {
        return $this->_faqCatResourceModel->getCategoriesList();
    }
}
