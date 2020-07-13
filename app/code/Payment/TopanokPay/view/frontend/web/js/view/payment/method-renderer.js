define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'topanokpayment',
                component: 'Payment_TopanokPay/js/view/payment/method-renderer/topanokpayment'
            }
        );
        return Component.extend({});
    }
);