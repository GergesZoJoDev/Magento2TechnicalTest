<?php
namespace Chupaprecios\Quotes\Model;

use Magento\Framework\Model\AbstractModel;

class QuoteDetail extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Chupaprecios\Quotes\Model\ResourceModel\QuoteDetail::class);
    }
}
