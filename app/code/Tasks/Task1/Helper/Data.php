<?php

namespace Tasks\Task1\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var string  */
    const ENABLE = 'enable2';

    /** @var string  */
    const CATEGORY_SELECTED = 'category_multi';

    /** @var string  */
    const XML_PATH = 'modify_product/';

    /** @var \Magento\Framework\Registry */
    protected $registry;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Block\Product\View $productBlock
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Block\Category\view $categoryBlock
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Framework\Registry $registry)
    {
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * @param string $field
     * @param null $storeId
     * @return string
     */
    protected function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * Verify category vith selected categories
     * @return boolean
     */
    public function isInCategory(){
        $selectedCatId = $this->getConfigValue(self::XML_PATH .'general/'. self::CATEGORY_SELECTED);
        if($selectedCatId){
            $catIds = explode(',', $selectedCatId);
        }else{
            return false;
        }
        $currProduct = $this->getCurrentProduct();
        if($currProduct != null){
            $data = $currProduct->getCategoryIds();
            $currCategoryId = $data[0];
            if (in_array($currCategoryId, $catIds)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /** @return string|null */
    public function getCurrentCategoryName(){
        $category = $this->getCurrentCategory();
        if($category) {
            $currentCategoryName = $category->getName();
            return $currentCategoryName;
        }
        else{
            return null;
        }
    }

    /**
     * @return \Magento\Catalog\Model\Category
     */
    public function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
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
}