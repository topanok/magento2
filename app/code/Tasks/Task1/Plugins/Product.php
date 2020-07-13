<?php

namespace Tasks\Task1\Plugins;

class Product
{
    private $helper;
    /** @param \Tasks\Task1\Helper\Data $helper */
    public function __construct(\Tasks\Task1\Helper\Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Plugin change product name
     * @return string
     */
    public function aftergetName(\Magento\Catalog\Model\Product $product){
        $name=$product->getData('name');
        if($this->helper->isInCategory() && $this->helper->enableDisable()) {
            $categoryName = $this->helper->getCurrentCategoryName();
            $productId = $product->getId();
            $sku = $product->getSku();
            $type = $product->getTypeId();
            $name .= $categoryName . '_' . $productId . '_' . $sku . '_' . $type;
        }
        return $name;
    }
}