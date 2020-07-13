<?php


namespace OneClick\Purchase\Model\Config\Source;


class ShippingMethods
{
    protected $helper;

    public function __construct(\OneClick\Purchase\Helper\Help $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Get source model array
     * @return array
     */
    public function toOptionArray(){
        $shippingMethod = $this->helper->getShippingMethods();
        $source = [];
        foreach ($shippingMethod as $method){
            $source[] = ['value' => $method['value'][0]['value'], 'label' => $method['label']];
        }
        return $source;
    }
}