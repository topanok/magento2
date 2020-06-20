<?php


namespace ChangePrice\Change\Plugins;


class Product
{
    public function aftergetPrice(\Magento\Catalog\Model\Product $product){
        $price=$product->getData('price');
        if($price > 50){
            $price = 999.99;
        }
        else{
            $price = 10.99;
        }
        return $price;
    }
}