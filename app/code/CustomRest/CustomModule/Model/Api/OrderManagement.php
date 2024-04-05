<?php
namespace CustomRest\CustomModule\Model\Api;


use CustomRest\CustomModule\Api\OrderManagementInterface;
use CustomRest\CustomModule\Api\RequestItemInterface;
use CustomRest\CustomModule\Api\ResponseItemInterface;
use Magento\Catalog\Model\ResourceModel\Product\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class OrderManagement implements OrderManagementInterface {
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * @var Response
     */
    private $response;

    /**
     * @param DirectoryList $directoryList
     * @param LoggerInterface $logger
     * @param Response $response
     */
    public function __construct(
        DirectoryList $directoryList,
        LoggerInterface $logger,
        \Magento\Framework\Webapi\Rest\Response $response
    ) {
        $this->directoryList =$directoryList;
        $this->logger = $logger;
        $this->response = $response;
    }
    /**
     * {@inheritDoc}
     *
     * @param int $id
     * @return ResponseItemInterface
     * @throws NoSuchEntityException
     */
    public function getOrder(int $id) : mixed
    {
        $fileName = '/orders_log.log';
        $contents = '';
        try {
            $path = $this->directoryList->getPath(DirectoryList::LOG).$fileName ;
            $lines = file($path);
            foreach($lines as $line) {
                if( intval(json_decode( explode("): ", $line)[1] )->order_id) == $id ) {
                    $contents = json_decode( explode("): ", $line)[1] ) ;
                    $this->response->setHeader('Content-Type', 'application/json', true)
                        ->setBody(json_encode($contents))
                        ->sendResponse();
                }
            }
        } catch (FileSystemException $e) {
            $this->logger->error($e->getMessage());
        }

        return $contents;
    }
}
