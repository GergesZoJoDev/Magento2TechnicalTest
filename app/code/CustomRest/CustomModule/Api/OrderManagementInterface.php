<?php
namespace CustomRest\CustomModule\Api;


interface OrderManagementInterface {


    /**
     * Return a filtered order.
     *
     * @param int $id
     * @return string 
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOrder(int $id);
}
