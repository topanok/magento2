<?php

namespace AddCustomPrice\Add\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var string  */
    const ENABLE = 'enable_custom_price';

    /** @var array  */
    const FIELD = 'percent';

    /** @var string  */
    const XML_PATH = 'custom_price/';

    /** @var \Magento\Framework\Registry */
    protected $registry;

    protected $status;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Module\Status $status
     * @param \Magento\Config\Model\ResourceModel\Config $config
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Framework\Registry $registry,
                                \Magento\Framework\Module\Status $status,
                                \Magento\Config\Model\ResourceModel\Config $config)
    {

        $this->registry = $registry;
        $this->status = $status;
        $this->config = $config;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Catalog\Model\Category|null
     */
    public function getCurrentCategory()
    {
        $currCategory = $this->registry->registry('current_category');
            return $currCategory;
    }

    /**
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getCurrentProduct()
    {
        $currProduct = $this->registry->registry('current_product');
        return $currProduct;
    }

    /**
     * @return float
     */
    public function getCustomPrice(){
        if($this->getEnableModule()) {
            $price = $this->getCurrentProduct()->getPrice();
            $percent = $this->getConfigValue(self::XML_PATH . 'general/' . self::FIELD);
            $onePercent = $price / 100;
            $customPrice = $price + $percent * $onePercent;
            return round($customPrice, 2);
        }
        return null;
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
     * Verify enable/disable module
     * @return boolean
     */
    public function getEnableModule(){
        $enable = $this->getConfigValue(self::XML_PATH .'general/'. self::ENABLE);
        if ($enable == 1){
            return true;
        }else{
            return false;
            $this->status->setIsEnabled(true, ['AddCustomPrice_Add']);
        }
    }
}