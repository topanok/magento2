<?php


namespace ChangeName\Change\Model;


class Product extends \Magento\Catalog\Model\Product
{
    public function getSku()
    {
        $sku = parent::getSku();
        $sku .= ' +My SKU )';
        return $sku;
    }
}