<?php

namespace Tasks\Task3\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $objectManager;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /** @var \Magento\Catalog\Api\SpecialPriceInterface */
    protected $specialPrice;

    /** @var \Magento\Customer\Model\Session */
    protected $customerSession;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Api\SpecialPriceInterface $specialPrice
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Framework\ObjectManagerInterface $objManager,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Catalog\Api\SpecialPriceInterface $specialPrice,
                                \Magento\Customer\Model\Session $customerSession)
    {
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->objectManager = $objManager;
        $this->specialPrice = $specialPrice;
        parent::__construct($context);
    }

    /**
     * Get rules
     * @param \Magento\Catalog\Model\Product
     * @return array
     */
    public function getRules($product){
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
     * @return integer|null
     */
    private function getGroupId()
    {
        if ($this->customerSession->isLoggedIn()) {
            $customerGroup = $this->customerSession->getCustomer()->getGroupId();
            return $customerGroup;
        }
    }

    /**
     * @param string
     * @return array
     */
    public function getSpecialPrices($sku){
        $specialPrices = $this->specialPrice->get([$sku]);
        return $specialPrices;
    }
}