<?php
namespace Payment\TopanokPay\Plugin\Model;

class MethodList
{
    public function afterGetAvailableMethods(
                                        \Magento\Payment\Model\MethodList $subject,
                                        $availableMethods,
                                        \Magento\Quote\Api\Data\CartInterface $quote = null
    ){
        $shippingMethod = $this->getShippingMethod($quote);
        foreach ($availableMethods as $key => $method){
            // Here we will hide CashonDeliver method while customer select FlateRate Shipping Method
            if(($method->getCode() == 'topanokpayment') && ($shippingMethod != 'topanokshipping_topanokshipping')){
                unset($availableMethods[$key]);
            }
        }
        return $availableMethods;
    }

    /**
    * @param \Magento\Quote\Api\Data\CartInterface $quote
    * @return string
    */
    private function getShippingMethod($quote){
        if($quote){
            return $quote->getShippingAddress()->getShippingMethod();
        }
        return '';
    }
}
