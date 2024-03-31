<?php

declare(strict_types=1);

namespace CustomVendor\CustomModule\Controller\Index;

use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{

    /**
     * @var RedirectFactory
     */
    private $redirectFactory;

    /**
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(RedirectFactory $redirectFactory)
    {
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->redirectFactory->create()->setUrl('/custommodule/index/other');
    }
}
