<?php

namespace Cart\Ajax\Helper;

use Magento\Store\Model\ScopeInterface;

class Helper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var array  */
    protected $data = [];

    /** @var \Magento\Catalog\Api\ProductRepositoryInterface  */
    protected $productRepo;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepo
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Catalog\Api\ProductRepositoryInterface $productRepo
    ){
        $this->productRepo = $productRepo;
        parent::__construct($context);
    }

    /**
     * Get Request params
     */
    private function getParams()
    {
        return parent::_getRequest()->getParams();
    }

    /**
     * @return int
     */
    public function getProductId(){
        $data = $this->getParams();
        $id = $data['id'];
        return $id;
    }

    /** @return string */
    public function getQty(){
        $data = $this->getParams();
        return $data['qty'];
    }
}