<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */



namespace Alsurmedia\Faq\Controller\Adminhtml\Faqcategory;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Alsurmedia\Faq\Model\ResourceModel\Faqcategory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     *
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;

    /**
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_directoryList = $directoryList;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data['title'] = $data['faqcat_title'];
            $data['is_active'] = $data['faqcat_is_active'];

            $id = $this->getRequest()->getParam('category_id');

            /** @var \Alsurmedia\Faq\Model\Faqcategory $model */
            $model = $this->_objectManager->create('Alsurmedia\Faq\Model\Faqcategory')->load($id);
            if (!$model->getCategoryId() && $id) {
                $this->messageManager->addError(__('This Category no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $faq_path_upload = $this->_directoryList->getRoot().DIRECTORY_SEPARATOR.DirectoryList::PUB.DIRECTORY_SEPARATOR.DirectoryList::MEDIA.DIRECTORY_SEPARATOR;

            $delete_image = null;

            if (!empty($data['image'])) {
                if (is_array($data['image'])) {
                    $delete_image = !empty($data['image']['delete']) ? $data['image']['delete'] : 0;
                    if ($delete_image) {
                        $image_file = $data['image']['value'];
                        $data['image'] = '';
                    } else {
                        $data['image'] = $data['image']['value'];
                    }
                }
            }

            $model->setData($data);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('You saved the Category.'));

                $category_id = $model->getCategoryId();

                if ($delete_image) {
                    if (file_exists($faq_path_upload.$image_file)) {
                        unlink($faq_path_upload.$image_file);
                    }
                }

                try {
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => 'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

                    $uploader->setAllowRenameFiles(true);

                    $image = $uploader->save($faq_path_upload.Faqcategory::FAQ_CATEGORY_FILE_PATH_UPLOADED);

                    if (!empty($image['file'])) {
                        $image_old = !empty($data['image']) ? $data['image'] : 'icon_faq_category.png';
                        $data['image'] = $image['file'];
                        $data['category_id'] = $category_id;
                        $model->setData($data);
                        try {
                            $model->save();
                            if (file_exists($faq_path_upload.$image_old)) {
                                unlink($faq_path_upload.$image_old);
                            }
                        } catch (\Exception $e) {
                            $this->messageManager->addError($e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
                        $this->messageManager->addError(__('Can not save the Category icon: '.$e->getMessage()));
                        return $resultRedirect->setPath('*/*/edit', ['category_id' => $model->getCategoryId()]);
                    }
                }

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['category_id' => $model->getCategoryId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Category: '.$e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            if ($this->getRequest()->getParam('category_id')) {
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $this->getRequest()->getParam('category_id')]);
            }
            return $resultRedirect->setPath('*/*/new');
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed('Alsurmedia_Faq::category_create') || $this->_authorization->isAllowed('Alsurmedia_Faq::category_edit')) {
            return true;
        }
        return false;
    }
}
