<?php
namespace Chupaprecios\Quotes\Controller\Adminhtml\Quotes;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var string[]
     */
    protected $_publicActions = ['index'];

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context        $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Manage Quotes')));
        $this->_setActiveMenu('Chupaprecios_Quotes::quotes');

        $resultPage->addBreadcrumb(__('quotes'), __('Quote'));
        $resultPage->addBreadcrumb(__('quotes'), __('Manage Quotes'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Chupaprecios_Quotes::quotes');
    }
}
