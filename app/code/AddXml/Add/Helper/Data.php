<?php

namespace AddXml\Add\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /** @var string[]  */
    protected $data = ['enable', 'yesno', 'custom', 'display_text'];

    /** @var string  */
    const XML_PATH_POST = 'posts/';

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
     * @param null $storeId
     * @return array
     */
    public function getAllConfigValues()
    {
        $data = [];
        foreach ($this->data as $code){
            $data[] = $this->getConfigValue(self::XML_PATH_POST .'general/'. $code, null);
        }
        return array_combine($this->data, $data);
    }
}