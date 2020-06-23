<?php

namespace Cron\CacheClear\Cron;

class ClearCache
{
    /**
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     */
    public function __construct(
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    )
    {
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
    }
    public function execute()
    {
        $invalidcache = $this->_cacheTypeList->getInvalidated();
        foreach($invalidcache as $key => $value) {
            $this->_cacheTypeList->cleanType($key);
        }
    }
}