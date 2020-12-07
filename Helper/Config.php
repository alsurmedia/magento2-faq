<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - santiago@alsurmedia.com
 * Site: www.alsurmedia.com
 */

namespace Alsurmedia\Faq\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Alsurmedia\Faq\Model\ResourceModel\Faq as FaqResourceModel;
use Magento\Framework\App\Filesystem\DirectoryList;

class Config
{

	const FAQ_CATEGORY_FILE_PATH_UPLOADED = 'alsurmedia/faq/category/';

    protected $_storeManager;

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    public function getFaqcategoryFullPath($identifier)
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_CATEGORY_PATH.'/'.$identifier.FaqResourceModel::FAQ_DOT_HTML;
    }

    public function getFileBaseUrl($path)
    {
        return '/'.DirectoryList::PUB.'/'.DirectoryList::MEDIA.'/'.$path;
    }

    public function getFaqFullPath($identifier)
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_QUESTION_PATH.'/'.$identifier.FaqResourceModel::FAQ_DOT_HTML;
    }

    public function getFaqPage()
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_REQUEST_PATH;
    }

}
