define([
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'jquery'
], function(
            quote,
            totalsDefaultProvider,
            $){
    $(".action-delete").click(function () {
        let id = this.dataset.itemId;
        $.ajax({
            type: "POST",
            url: "http://mage2.loc/renewcart/cart/delete",
            data: {
                'id': id
            },
            success: function (data) {
                totalsDefaultProvider.estimateTotals(quote.shippingAddress());
            },
            error: function (data) {
                console.log('Bida');
            }
        });
    });
});