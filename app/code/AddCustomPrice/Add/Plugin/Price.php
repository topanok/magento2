<?php

namespace AddCustomPrice\Add\Plugin;

class Price
{
    /** @var \AddCustomPrice\Add\Helper\Data */
    private $helper;

    /** @param \AddCustomPrice\Add\Helper\Data $helper */
    public function __construct(\AddCustomPrice\Add\Helper\Data $helper)
    {
        $this->helper = $helper;
    }

    /** Change priece on category page */
    public function aftergetPrice(\Magento\Catalog\Model\Product $product){
        $price=$product->getData('price');
        if($this->helper->getEnableModule()) {
            $customPrice = $product->getCustomPrice();
            $currentProduct = $this->helper->getCurrentProduct();
            if (!$currentProduct) {
                if ($customPrice) {
                    $price = $customPrice;
                }
            }
        }
        return $price;
    }
}