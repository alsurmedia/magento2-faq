<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */



namespace Alsurmedia\Faq\Controller\Adminhtml\Faqcategory;

use Alsurmedia\Faq\Model\ResourceModel\Faqcategory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Alsurmedia_Faq::category_delete';

    /**
     * Delete FAQ Category
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $category_id = $this->getRequest()->getParam('category_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($category_id && (int) $category_id > 0) {
            $title = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Alsurmedia\Faq\Model\Faqcategory');
                $category = $model->load($category_id);

                if ($category->getCategoryId()) {
                    $title = $model->getTitle();

                    $model->delete();

                    $this->messageManager->addSuccess(__('The "'.$title.'" Category has been deleted.'));

                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $category_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Category to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
