<?php
namespace Chupaprecios\Quotes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Quotes extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('quote_request', 'quote_id');
    }
}
