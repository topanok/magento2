define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Payment_TopanokPay/payment/topanokpayment'
            }
        });
    }
);  