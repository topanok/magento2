define([
    'jquery',
    'Magento_Checkout/js/checkout-data'
], function ($, checkoutData){
    'use strict';

    return function (target){
        return target.extend({
            /**
             * Вішаємось на метод placeOrder з Magento_Checkout/js/view/payment/default (вказано в requirejs)
             * працює як плагін before
             * @inheritDoc
             */
            placeOrder: function (data, event){
                //Пишемо наш код
                window.location.href = 'https://www.liqpay.ua/checkout/i97771924799';
                $.ajax({
                    type: "POST",
                    url: "https://www.liqpay.ua/api/request",
                    data: {
                        'data': 'eyJ2ZXJzaW9uIjozLCJwdWJsaWNfa2V5IjoiaTk3NzcxOTI0Nzk5IiwiYWN0aW9uIjoicGF5IiwiYW1vdW50IjoiMjIiLCJjdXJyZW5jeSI6IlVBSCIsImRlc2NyaXB0aW9uIjoidG9wYW5va1Rlc3QiLCJvcmRlcl9pZCI6IjAwMDAwMSJ9',
                        'signature': '7O1GJC/bW2FrjT3BG3IF9XkyyFQ='
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                // Код стандартного методу виконається після того , як ми повернемо this._super
                return this._super(data, event);
            }
        })
    }
})