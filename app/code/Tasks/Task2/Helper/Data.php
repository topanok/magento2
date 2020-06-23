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

    /** @var \Magento\Framework\Registry */
    protected $registry;

    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $objectManager;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /** @var \Magento\Customer\Model\Session */
    protected $customerSession;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Framework\ObjectManagerInterface $objManager,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Framework\Registry $registry,
                                \Magento\Customer\Model\Session $customerSession)
    {
        $this->customerSession = $customerSession;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->objectManager = $objManager;
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


    public function getCheckboxValues(){
        //$values = [];
        //foreach (self::FIELDS as $field) {
            //$values[] = $this->getConfigValue(self::XML_PATH .'general/'. $field);
       // }
        $value = $this->getConfigValue(self::XML_PATH .'general/'. 'base_price');
        return $value;
    }

    /**
     * @return integer
     */
    public function getEnableDisableValue(){
        $value = $this->getConfigValue(self::XML_PATH .'general/'. self::ENABLE);
        return $value;
    }

    /**
     *  @return \Magento\Catalog\Model\Product
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Verify enable/disable module
     * @return boolean
     */
    public function enableDisable(){
        $enable = $this->getConfigValue(self::XML_PATH .'general/'. self::ENABLE);
        if ($enable == 1){
            return true;
        }else{
            return false;
        }
    }

    public function getRulePrice(){
        $product = $this->getCurrentProduct();
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

        return $rules;
    }
    /**
     * Get special price
     * @return float
     */
    public function getSpecialPrice(){
        $currProduct = $this->getCurrentProduct();
        $specialPrice = $currProduct->getSpecialPrice();
        return $specialPrice;
    }
    private function getGroupId(){
        if($this->customerSession->isLoggedIn()):
            return $customerGroup=$this->customerSession->getCustomer()->getGroupId();
        endif;
    }
}