<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Model;

class Faqcategory extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'alsurmedia_faq_category';

    protected function _construct()
    {
        $this->_init('Alsurmedia\Faq\Model\ResourceModel\Faqcategory');
    }

}
