<?php
namespace CustomVendor\CustomModule\Plugin;
class FinalPricePlugin
{
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig) {
        $this->scopeConfig = $scopeConfig;
    }
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        return $result + $this->scopeConfig->getValue('custommodule/general/display_text_1', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
