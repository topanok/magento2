<?php


namespace OneClick\Purchase\Model\Config\Source;


class PaymentMethods
{
    /** @var \OneClick\Purchase\Helper\Help  */
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
        $paymentMethods = $this->helper->getAvailablePaymentMethods();
        $source = [];
        foreach ($paymentMethods as $code => $method){
            $source[] = ['value' => $code, 'label' => $method];
        }
        return $source;
    }
}