<?php
namespace Chupaprecios\Quotes\Model\ResourceModel\Quote;

use Chupaprecios\Quotes\Model\ResourceModel\Quote\Collection;
use Magento\Framework\ObjectManagerInterface;

class CollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return Collection
     */
    public function create(array $data = [])
    {
        return $this->objectManager->create(Collection::class, $data);
    }
}
