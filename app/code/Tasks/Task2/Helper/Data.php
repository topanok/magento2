<?php

namespace Tasks\Task2\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var string  */
    const ENABLE = 'enable3';

    /** @var array  */
    const FIELDS = ['base_price', 'final_price', 'special_price', 'tier_price', 'catalog_rule_price'];

    /** @var string  */
    const XML_PATH = 'modify_product2/';

    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $objectManager;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /** @var \Magento\Catalog\Api\SpecialPriceInterface */
    protected $specialPrice;

    /** @var \Magento\Customer\Model\Session */
    protected $customerSession;

    /** @var \Magento\Framework\Registry */
    protected $registry;

    /** @var \Magento\Catalog\Pricing\Render */
    protected $render;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Api\SpecialPriceInterface $specialPrice
     * @param \Magento\Catalog\Pricing\Render $render
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Framework\ObjectManagerInterface $objManager,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Framework\Registry $registry,
                                \Magento\Catalog\Api\SpecialPriceInterface $specialPrice,
                                \Magento\Catalog\Pricing\Render $render,
                                \Magento\Customer\Model\Session $customerSession)
    {

        $this->customerSession = $customerSession;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->objectManager = $objManager;
        $this->specialPrice = $specialPrice;
        $this->render = $render;
        parent::__construct($context);
    }

    /**
     * @param string $field
     * @param null $storeId
     * @return string
     */
    private function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @return array
     */
    public function getConfigValues(){
        $values = [];
        foreach (self::FIELDS as $field) {
            $values[] = $this->getConfigValue(self::XML_PATH .'general/'. $field);
        }
        $keyValue = array_combine(self::FIELDS, $values);
        return $keyValue;
    }
    /**
     * @return array
     */
    public function getPricesNames(){
        $values = $this->getConfigValues();
        $checked = [];
        foreach ($values as $key => $value) {
            if($value == 1){
                $checked[] = $key;
            }
        }
       return $checked;
    }

    /**
     * Verify enable/disable module
     * @return boolean
     */
    public function getEnableModule(){
        $enable = $this->getConfigValue(self::XML_PATH .'general/'. self::ENABLE);
        if ($enable == 1){
            return true;
        }else{
            return false;
        }
    }
    /**
     * Get discount in %
     * @param \Magento\Catalog\Model\Product
     * @return array
     */
    public function getRulesDiscounts($product){
        $productId = $product->getId();
        $storeId = $product->getStoreId();
        $store = $this->storeManager->getStore($storeId);
        $customerGroupId = $this->getGroupId();
        $websiteId = $store->getWebsiteId();
        /**
         * @var \Magento\Framework\Stdlib\DateTime\DateTime
         */
        $date = $this->objectManager->create('\Magento\Framework\Stdlib\DateTime\DateTime');
        $dateTs = $date->gmtDate();
        /**
         * @var \Magento\CatalogRule\Model\ResourceModel\Rule
         */
        $resource = $this->objectManager->create('\Magento\CatalogRule\Model\ResourceModel\Rule');
        $rules = $resource->getRulesFromProduct($dateTs, $websiteId, $customerGroupId, $productId);
        $discounts = [];
        if(!empty($rules)){
            foreach($rules as $rule){
                $discounts[$rule['rule_id']] = $rule['action_amount'];
            }
        }
        return $discounts;
    }
    /**
     * @return integer|null
     */
    private function getGroupId()
    {
        if ($this->customerSession->isLoggedIn()) {
            $customerGroup = $this->customerSession->getCustomer()->getGroupId();
            return $customerGroup;
        }
    }

    /*public function getSpecialPrices($sku){
        $specialPrices = $this->specialPrice->get([$sku]);
        return $specialPrices;
    }*/
}