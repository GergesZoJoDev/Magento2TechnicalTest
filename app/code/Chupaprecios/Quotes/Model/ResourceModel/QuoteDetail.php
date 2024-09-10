<?php
namespace Chupaprecios\Quotes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class QuoteDetail extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('quote_request_detail', 'detail_id');  // Especificar tabla y clave primaria
    }
}
