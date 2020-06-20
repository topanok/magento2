<?php

namespace ChangeName\Change\Observer;

use Magento\Framework\Event\Observer;

class Product implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer){
        $collection = $observer->getEvent()->getData('collection');
        foreach ($collection as $product){
            $name = $product->getData('name');
            $finalPrice = $product->getData('final_price');
            $createdAt = $product->getData('created_at');
            $name .= ' Final price-'.$finalPrice.' Created at-'.$createdAt;
            $product->setData('name', $name);
        }
    }
}