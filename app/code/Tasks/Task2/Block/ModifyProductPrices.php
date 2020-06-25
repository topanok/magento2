<?php

namespace Tasks\Task2\Block;

class ModifyProductPrices extends \Magento\Framework\View\Element\Template
{
    /** @var \Tasks\Task2\Helper\Data  */
    protected $helper;

    /** @var \Magento\Framework\Registry */
    protected $registry;

    /**
     * @param \Tasks\Task2\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(\Tasks\Task2\Helper\Data $helper,
                                \Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Framework\Registry $registry,
                                array $data=[])
    {
        $this->registry = $registry;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     *  @return \Magento\Catalog\Model\Product
     */
    private function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get rules prices
     *  @return array|null
     */
    private function getRulesPrices(){
        $product = $this->getCurrentProduct();
        if($product){
            $basePrice = $product->getData('price');
            if(!empty($this->helper->getRulesDiscounts($product))){
                $rulePrices = [];
                $discounts = $this->helper->getRulesDiscounts($product);
                foreach ($discounts as $id => $discount){
                    $onePercent = $basePrice / 100;
                    $discountSum = $onePercent * $discount;
                    $rulePrices[$id] = $basePrice - $discountSum;
                }
                return $rulePrices;
            }
            else{
                return null;
            }
        }
    }

    /**
     * Get all config prices
     *  @return array|null
     */
    public function getPrices(){
        if($this->helper->getEnableModule()) {
            $product = $this->getCurrentProduct();
            $prices = [];
            if ($product) {
                $prices['base_price'] = round($product->getData('price'), 2);
                $prices['final_price'] = round($product->getFinalPrice(), 2);
                if($product->getSpecialPrice()){
                    $prices['special_price'] = round($product->getSpecialPrice(),2);
                }
                if($this->getRulesPrices()){
                    $prices['catalog_rule_price'] = $this->getRulesPrices();
                }
                if(!empty($product->getTierPrice())){
                    $prices['tier_price'] = $product->getTierPrice();
                }
                //$sku = $product->getSku();
                //$spec = $product->getPriceInfo()->getPrice('special_price')->getValue();
                //$spec2 = $product->getSpecialPrice();
                //$spec3 = $this->helper->getSpecialPrices($sku);

                return $prices;
            }
            return null;
        }
        return null;
    }

    /**
     * Get enabled prices in config
     *  @return array|null
     */
    public function getEnabledPrices(){
        if($this->helper->getEnableModule()) {
            $enabledNames = $this->helper->getPricesNames();
            $prices = $this->getPrices();
            foreach ($prices as $key => $price){
                if (!in_array($key, $enabledNames)){
                    unset($prices[$key]);
                }
            }
            return $prices;
        }
        return null;
    }
}