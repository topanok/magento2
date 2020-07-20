define([
    'jquery',
    'Magento_Checkout/js/model/cart/cache',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/customer-data'
], function ($, cache, getTotalsAction, totalsProcessor, quote, customerData) {

    $(document).ready(function(){
        $(document).on('change', 'input[name$="[qty]"]', function(){
            var form = $('#form-validate');
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (res) {
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find("#form-validate");
                    var sections = ['cart'];
                    $("#form-validate").replaceWith(result);
                    /* Minicart reloading */
                    customerData.reload(sections, true);
                    /* Totals summary reloading */
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });
        $('.action-delete').on('click',function () {
            let id = this.dataset.itemId;
            var formKey = $("input[name='form_key']").val();
            var self = this ;
            $.ajax({
                url: '/checkout/cart/delete/',
                data: {'id':id,
                    'form_key':formKey},
                method: 'post',
                showLoader: true,
                success: function (res) {
                    var sections = ['cart'];
                    customerData.reload(sections, true);
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find("#form-validate");
                    customerData.reload(sections, true);
                    $(self).closest("tbody").css('display','none');
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });
        var form = $('#discount-coupon-form');
        $(form).submit(function (e) {
            e.preventDefault();
        });
        $(document).on('click','.apply', function () {
            $.ajax(
                {
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    showLoader: true,
                    success: function (response) {
                        $('#discount-coupon-form').hide();
                        cache.clear('cartVersion');
                        var deferred = $.Deferred();
                        getTotalsAction([], deferred);
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }
                }
            );
        });
        $(document).on('click','.cancel', function () {
            $.ajax(
                {
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    showLoader: true,
                    success: function (response) {
                        $('#discount-coupon-form').hide();
                        cache.clear('cartVersion');
                        var deferred = $.Deferred();
                        getTotalsAction([], deferred);
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }
                }
            );
        });
        $(document).on('click','.swatch-option',function () {
            if($(this).hasClass('text')){
                var product = $(this).data('product_id');
                var color = $('#'+product+'-color-selected');
                let text = $(this).text();

                var textAttributeId = $(this).data('option_attribute_id');
                var textValueId = $(this).data('option_id');

                var colorAttributeId = color.data('option_attribute_id');
                var colorValueId = color.data('option_id');
                $('.swatch-attribute-selected-option-size-'+product).text(text);
                $('.text-product-'+product).removeClass('selected');
                $(this).addClass('selected');
            } else if($(this).hasClass('color')) {
                var product = $(this).data('product_id');
                var text = $('#'+product+'-text-selected');
                let colorText = $(this).data('option_inner_text');
                var colorAttributeId = $(this).data('option_attribute_id');
                var colorValueId = $(this).data('option_id');

                var textAttributeId = text.data('option_attribute_id');
                var textValueId = text.data('option_id');
                $('.swatch-attribute-selected-option-color-'+product).text(colorText);
                $('.color-product-'+product).removeClass('selected');
                $(this).addClass('selected');
            }
            let id = $('.action-delete').data('item-id');
            let qty = $('input[name$="[qty]"]').val();
            super_attribute = {};
            super_attribute[colorAttributeId] = colorValueId;
            super_attribute[textAttributeId] = textValueId;
            $.ajax({
                url: '/checkout/cart/updateItemOptions/id/'+id+'/',
                data: {
                    id: id,
                    product: product,
                    selected_configurable_option: "",
                    related_product: "",
                    item: id,
                    form_key: "kXdqqjZ4B2OocxMm",
                    super_attribute,
                    qty: qty
                },
                method: 'post',
                showLoader: true,
                success: function (res) {
                    console.log(super_attribute);
                    cache.clear('cartVersion');
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find("#form-validate");
                    var sections = ['cart'];
                    $("#form-validate").replaceWith(result);
                    /* Minicart reloading */
                    customerData.reload(sections, true);
                    /* Totals summary reloading */
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                }
            });
        });
    });
});