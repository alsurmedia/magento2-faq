<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */



namespace Alsurmedia\Faq\Controller\Category;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Alsurmedia\Faq\Model\ResourceModel\Faqcategory
     */
    protected $_faqCatResourceModel;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Alsurmedia\Faq\Model\ResourceModel\Faqcategory $faqCatResourceModel
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Alsurmedia\Faq\Model\ResourceModel\Faqcategory $faqCatResourceModel,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->_faqCatResourceModel  = $faqCatResourceModel;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_resultPageFactory    = $resultPageFactory;
        return parent::__construct($context);
    }

    /**
     * View action
     *
     * @return \Magento\Framework\View\Result\PageFactory|\Magento\Framework\Controller\Result\ForwardFactory
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('category_id');
        $textSearch =  $this->getRequest()->getParam('s');
        if ($category = $this->_faqCatResourceModel->getFaqcategoryStore($id, $textSearch)) {
            $resultPage = $this->_resultPageFactory->create();

            $resultPage->getConfig()->getTitle()->set(__('FAQs'));

            $resultPage->getConfig()->getTitle()->prepend(__($category['title']));

            return $resultPage;
        }
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('noroute');
    }
}
