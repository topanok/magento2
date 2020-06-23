<?php

namespace Tasks\Task2\Plugins;

class Product
{
    private $helper;
    /** @param \Tasks\Task2\Helper\Data $helper */
    public function __construct(\Tasks\Task2\Helper\Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Plugin change product price
     * @return float
     */
    public function aftergetPrice(\Magento\Catalog\Model\Product $product){
        $price = $product->getData('price');
        //$price = $product->getPriceModel();
        //$basePrice = $price->getBasePrice($product);
        //$finalPrice = $price->getFinalPrice(null, $product);
        //$specialPrice = $this->helper->getSpecialPrice();
        //$tierPrice = $price->getTierPrice(null, $product);
        //$catalogRulePrice = $this->helper->getRulePrice();
        $values= $this->helper->getCheckboxValues();
        $enable=$this->helper->getEnableDisableValue();
        if($price > 50){
            $price = 999.99;
        }
        return $price;
    }
}