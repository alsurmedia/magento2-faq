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
class Faq extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Alsurmedia_Faq';
        $this->_controller = 'Adminhtml_Faq';
        $this->_headerText = __('FAQs Manager');
        $this->_addButtonLabel = __('Add New FAQ');
        parent::_construct();
    }
}
