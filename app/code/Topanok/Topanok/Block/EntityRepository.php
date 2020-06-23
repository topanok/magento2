<?php


namespace Topanok\Topanok\Block;

use Magento\Catalog\Api\Data\ProductInterface;

class EntityRepository extends \Magento\Framework\View\Element\Template
{
     /** @var \Magento\Catalog\Api\ProductRepositoryInterface */
    protected $_productRepository;

    /** @var \Magento\Framework\Api\SearchCriteriaBuilder */
    protected $_searchCriteriaBuilder;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data=[]){
        $this->_productRepository = $productRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }
    /**
     * Get product by id via repository
     *
     * @param int $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductById($productId){
        if (is_null($productId)){
            return null;
        }
        $productModel=$this->_productRepository->getById($productId);
        return $productModel;
    }
    /**
     * Get Pruducts cheaper than X
     *
     * @param $price
     * @return array|ProductInterface[]
     */
    public function getCheapProducts($price){
        if (is_null($price)){
            return null;
        }
        $this->_searchCriteriaBuilder->addFilter(
            ProductInterface::PRICE,
            $price,
            'lt');
        $searchCriteria=$this->_searchCriteriaBuilder->create();
        $productCollection=$this->_productRepository->getList($searchCriteria);
        return $productCollection->getItems();
    }
}