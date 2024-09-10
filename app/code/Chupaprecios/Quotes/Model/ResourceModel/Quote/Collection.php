<?php
namespace Chupaprecios\Quotes\Model\ResourceModel\Quote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Chupaprecios\Quotes\Model\Quote as QuoteModel;
use Chupaprecios\Quotes\Model\ResourceModel\Quote as QuoteResourceModel;

/**
 * Colección para tabla quote_request
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'quote_id';
    /**
     * @var string
     */
    protected $_eventPrefix = 'quote_request_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'quote_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(QuoteModel::class, QuoteResourceModel::class);
    }
}
