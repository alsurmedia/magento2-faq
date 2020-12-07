<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Model\ResourceModel\Faq;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'faq_id';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Alsurmedia\Faq\Model\Faq', 'Alsurmedia\Faq\Model\ResourceModel\Faq');
    }
}
