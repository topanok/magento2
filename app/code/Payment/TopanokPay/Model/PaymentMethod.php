<?php

namespace Payment\TopanokPay\Model;

class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment Method code
     *
     * @var string
     */
    protected $_code = 'topanokpayment';
}