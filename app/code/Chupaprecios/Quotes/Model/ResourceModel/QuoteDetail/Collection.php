<?php
namespace Chupaprecios\Quotes\Model\ResourceModel\QuoteDetail;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Chupaprecios\Quotes\Model\QuoteDetail as QuoteDetailModel;
use Chupaprecios\Quotes\Model\ResourceModel\QuoteDetail as QuoteDetailResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'detail_id';
    protected $_eventPrefix = 'quote_request_detail_collection';
    protected $_eventObject = 'quote_detail_collection';

    protected function _construct()
    {
        $this->_init(QuoteDetailModel::class, QuoteDetailResourceModel::class);
    }
}
