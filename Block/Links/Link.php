<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Links;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var \Alsurmedia\Faq\Helper\Config
     */
    protected $_configHelper;

    /**
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Alsurmedia\Faq\Helper\Config $configHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Alsurmedia\Faq\Helper\Config $configHelper,
        array $data = []
    ) {
        $this->_configHelper = $configHelper;
        parent::__construct($context, $data);
    }

    /**
     * Prepare url using passed id path and return it
     * or return false if path was not found in url rewrites.
     *
     * @throws \RuntimeException
     * @return string|false
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getHref()
    {
        return $this->_configHelper->getFaqPage();
    }

    /**
     * Return label
     *
     * @return string
     */
    public function getLabel()
    {
         return __('Frequently Asked Questions');
    }
}
