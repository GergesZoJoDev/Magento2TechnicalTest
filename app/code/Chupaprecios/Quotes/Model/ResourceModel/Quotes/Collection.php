<?php
namespace Chupaprecios\Quotes\Model\ResourceModel\Quotes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'quote_id';
    protected function _construct()
    {
        $this->_init('Chupaprecios\Quotes\Model\Quotes', 'Chupaprecios\Quotes\Model\ResourceModel\Quotes');
    }
}
