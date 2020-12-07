<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Block\Adminhtml;

/**
 * Adminhtml cms blocks content block
 */
class Faqcategory extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Alsurmedia_Faqcategory';
        $this->_controller = 'Adminhtml_Faqcategory';
        $this->_headerText = __('FAQ Categories Manager');
        $this->_addButtonLabel = __('Add New Category');
        parent::_construct();
    }
}
