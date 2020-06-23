<?php


namespace Topanok\Topanok\Helper;


class Validator extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var array */
    private $_availableSku = [
        'MJ01',
        'Mj01',
        'MJ02',
        'MJ12'
    ];

    /**
     * Validate template visualization by SKU
     *
     * @param string $sku
     * @return bool
     */
    public function validateProductBySku($sku){
        if(in_array($sku, $this->_availableSku)){
            return true;
        }else{
            return false;
        }
    }
}