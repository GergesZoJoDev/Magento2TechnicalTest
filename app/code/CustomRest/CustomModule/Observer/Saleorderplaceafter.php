<?php

namespace CustomRest\CustomModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class Saleorderplaceafter implements ObserverInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();
            $products= $observer->getEvent()->getOrder()->getAllItems();

            $arrayOrder = array(
                'order_id' => $order->getIncrementId(),
                'state' => $order->getState(),
                'status' => $order->getStatus(),
                'store_id' => $order->getStoreId(),
                'subtotal' => $order->getSubtotal(),
                'grand_total' => $order->getGrandTotal(),
                'total_qty_order' => $order->getTotalQtyOrdered(),
                'customer_email' => $order->getCustomerEmail(),
                'customer_firstname' => $order->getCustomerFirstname(),
                'customer_lastname' => $order->getCustomerLastname(),
                'products' => array()
            );

            foreach ($products as $item) {
                $arrayOrder['products'][] = array(
                    'id' => $item->getData('product_id'),
                    'quantity' => $item->getData('qty_ordered'),
                    'price' => $item->getData('price')
                );
            }

            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/orders_log.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->debug(
                json_encode( $arrayOrder )
            );
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
