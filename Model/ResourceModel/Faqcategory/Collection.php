<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Model\ResourceModel\Faqcategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'category_id';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Alsurmedia\Faq\Model\Faqcategory', 'Alsurmedia\Faq\Model\ResourceModel\Faqcategory');
    }
}
