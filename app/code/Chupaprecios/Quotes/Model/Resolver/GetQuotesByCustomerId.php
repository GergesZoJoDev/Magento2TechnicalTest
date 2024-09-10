<?php
namespace Chupaprecios\Quotes\Model\Resolver;

use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Chupaprecios\Quotes\Model\ResourceModel\Quote\CollectionFactory as QuoteCollectionFactory;
use Chupaprecios\Quotes\Model\ResourceModel\QuoteDetail\CollectionFactory as QuoteDetailCollectionFactory;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetQuotesByCustomerId implements ResolverInterface
{
    protected $quoteCollectionFactory;
    protected $quoteDetailCollectionFactory;
    protected $customerRepository;
    protected $productRepository;

    public function __construct(
        QuoteCollectionFactory       $quoteCollectionFactory,
        QuoteDetailCollectionFactory $quoteDetailCollectionFactory,
        CustomerRepositoryInterface  $customerRepository,
        ProductRepository            $productRepository
    )
    {
        $this->quoteCollectionFactory = $quoteCollectionFactory;
        $this->quoteDetailCollectionFactory = $quoteDetailCollectionFactory;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
    }

    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    )
    {
        $customerId = $args['customer_id'];
        $quotes = $this->quoteCollectionFactory->create()->addFieldToFilter('customer_id', ['eq' => $customerId]);

        $result = [];
        foreach ($quotes as $quote) {
            $quoteProducts = [];
            $details = $this->quoteDetailCollectionFactory->create()->addFieldToFilter('quote_id', $quote->getId());

            foreach ($details as $detail) {
                $product = $this->productRepository->getById($detail->getProductId());
                $quoteProducts[] = [
                    'product_id' => $detail->getProductId(),
                    'product_sku' => $detail->getProductSku(),
                    'price' => $detail->getPrice(),
                    'quantity' => $detail->getQuantity()
                ];
            }

            $expirationDate = (new \DateTime($quote->getCreatedAt()))->modify('+5 days')->format('Y-m-d H:i:s');
            $pdfBase64 = base64_encode($this->generateQuotePdf($quote));

            $result[] = [
                'quote_id' => $quote->getId(),
                'customer_name' => $quote->getCustomerId() ? $this->customerRepository->getById($quote->getCustomerId())->getFirstname() . ' ' . $this->customerRepository->getById($quote->getCustomerId())->getLastname() : 'Guest',
                'cart_id' => $quote->getCartId(),
                'status' => (bool)$quote->getStatus(),
                'expiration_date' => $expirationDate,
                'products' => $quoteProducts,
                'subtotal' => $quote->getSubtotal(),
                'pdf_base64' => $pdfBase64
            ];
        }

        return $result;
    }

    protected function generateQuotePdf($quote)
    {
// Lógica para generar el PDF (fuera del alcance de este ejemplo).
        return 'PDF data'; // Reemplaza esto con el contenido del PDF generado.
    }
}
