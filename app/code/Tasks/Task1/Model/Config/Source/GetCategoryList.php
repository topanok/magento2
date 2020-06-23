<?php


namespace Tasks\Task1\Model\Config\Source;


class GetCategoryList
{
    /** @var \Magento\Catalog\Model\CategoryFactory */
    protected $_categoryFactory;
    /** @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory */
    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollFactory
    )
    {
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryCollectionFactory = $categoryCollFactory;
    }
    /**
     * Get source model array
     * @return array
     */
    public function toOptionArray(){
        $data = $this->getCollInArray();
        $source = [];
        foreach ($data as $id => $category){
            $category = $this->_categoryFactory->create()->load($id);
            $categoryName = $category->getName();
            $categoryId = $category->getId();
            $source[] = ['value' => $id, 'label' => $categoryName.'('.$categoryId.')'];
        }
        return $source;
    }
    /**
     * Get categories collection
     * @param bool
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    private function getCategoryColl($isActive = true){
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('multicategories');

        if($isActive){
            $collection->addIsActiveFilter();
        }
        return $collection;
    }
    /** @return array */
    private function getCollInArray()
    {
        $categories = $this->getCategoryColl(true);
        $catagoryList = array();
        foreach ($categories as $category)
        {
            $catagoryList[$category->getEntityId()] = __($category->getName());
        }
        return $catagoryList;
    }

}