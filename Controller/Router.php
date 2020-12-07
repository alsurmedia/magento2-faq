<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 26/9/20
 * Time: 13:52
 */

namespace Alsurmedia\Faq\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Router constructor.
     *
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory
    ) {
        $this->actionFactory = $actionFactory;
    }

    /**
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        if(strpos($identifier, 'faq') !== false) {
            $request->setModuleName('faq')-> //module name
            setControllerName('faq')-> //controller name
            setActionName('view'); //action name
        } else {
            return false;
        }

        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}