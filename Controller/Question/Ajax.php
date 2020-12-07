<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Controller\Question;

class Ajax extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Alsurmedia\Faq\Model\ResourceModel\Faq
     */
    protected $_faqResourceModel;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Alsurmedia\Faq\Model\ResourceModel\Faq $faqResourceModel,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->_faqResourceModel     = $faqResourceModel;
        $this->_resultJsonFactory    = $resultJsonFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        return parent::__construct($context);
    }

    /**
     * Ajax action
     *
     * @return \Magento\Framework\Controller\Result\JsonFactory|\Magento\Framework\Controller\Result\ForwardFactory
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        if ($this->getRequest()->isAjax()) {
            $type = $this->getRequest()->getParam('type');
            $faq_id = (int) $this->getRequest()->getParam('faq_id');
            $model = $this->_objectManager->create('Alsurmedia\Faq\Model\Faq');
            $model->load($faq_id);
            if ($model->getFaqId()) {
                if ($type == '1') {
                    $model->setLiked($model->getLiked() + 1);
                } elseif ($type == '0') {
                    $model->setDisliked($model->getDisliked() + 1);
                }
                $model->save();
            }
            return $result->setData(['status' => 'success']);
        }
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('noroute');
    }
}
