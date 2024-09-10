<?php

namespace Chupaprecios\Quotes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource Model para quote_request
 */
class Quote extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('quote_request', 'quote_id');
    }
}
