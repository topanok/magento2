<?php

namespace Perspective\RewriteBrightpearl\Plugin;

class Rewrite
{

    /** @var \Magento\Store\Model\StoreManagerInterface  */
    protected $_storeManager;


    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        $this->_storeManager = $storeManager;
    }

    public function afterSaveOtp(\Hotlink\Brightpearl\Model\Config\OAuth2 $subject, $result)
    {
        $something = 23;
        return $result;
    }
}
