<?php
namespace Chupaprecios\Quotes\Model;

use Magento\Framework\Model\AbstractModel;

/**
 *  Modelo encargado de la tabla quote_request
 */
class Quote extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Chupaprecios\Quotes\Model\ResourceModel\Quote::class);
    }
}
