<?php

namespace TaskOrder\Order\Plugin;

class RequireMiddleName
{
    /** @var \Magento\Backend\Model\Session\Quote  */
    private $quote;

    public function __construct(\Magento\Backend\Model\Session\Quote $quote)
    {
        $this->quote = $quote;
    }
    /**
     * Add required to field middle name if shipping method is Free
     *
     * @param \Magento\Customer\Model\Metadata\Form $subject
     * @param $result
     */
    public function afterGetAttributes(\Magento\Customer\Model\Metadata\Form $subject, $result)
    {
        $quote = $this->quote->getQuote();
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        if ($shippingMethod == 'freeshipping_freeshipping') {
            if (isset($result['middlename'])) {
                $result['middlename']->setData('required', true);
            }
        } else {
            if (isset($result['middlename'])) {
                $result['middlename']->setData('required', false);
            }
        }
        return $result;
    }
}
