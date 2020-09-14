define([
    'jquery',
    'uiComponent',
    'Magento_Checkout/js/checkout-data',
    'Magento_Ui/js/modal/confirm'
], function ($, Component, checkoutData, confirmation){
    'use strict';

    /**
     * Get options from config
     *
     * @see \Declarative\UiApp\Model\Ui\Frontend\Checkout\ShippingOptionsConfigProvider
     * @array
     */
    return Component.extend({
        optionsArray: window.checkoutConfig.shipping_options,

        initialize: function (){
            this._super();
            if(!this.optionsArray.enabled){
                return false;
            }
            this.checkShippingMethod();
        },

        checkShippingMethod: function (){
            let self = this;
            console.log(checkoutData.getSelectedPaymentMethod());
            $('body').on('click', '#cashondelivery', function (){
                self.showConfirmation();
            });
            if(checkoutData.getSelectedPaymentMethod()
                && checkoutData.getSelectedPaymentMethod() === 'cashondelivery'){
                self.showConfirmation();
            }
        },

        showConfirmation: function (){
            let self = this;
            confirmation({
                title: $.mage.__(self.optionsArray.title),
                class: 'action-secondary action-dismiss',
                buttons: [
                    {
                        text: $.mage.__('Cancel'),
                        click: function (event) {
                            this.closeModal(event);
                        }
                    },
                    {
                        text: $.mage.__('Confirm'),
                        class: 'action-primary action-accept',
                        click: function (event) {
                            this.closeModal(event, true);
                        }
                    }
                ]
            })
        }
    })

})