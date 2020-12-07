<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Model\Config\Source;

class Yesno implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [];
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function getYesnoOptions()
    {
        $options = [
            '1' => __('Yes'),
            '0' => __('No'),
        ];

        $this->_options = $options;
        return $this->_options;
    }
}
