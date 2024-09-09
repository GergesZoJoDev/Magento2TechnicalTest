<?php
namespace Chupaprecios\Quotes\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use \Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Quotes extends AbstractModel
{
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    protected function _construct()
    {
        $this->_init('Chupaprecios\Quotes\Model\ResourceModel\Quotes');
    }
}
