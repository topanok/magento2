define([
    'ko',
    'uiComponent',
        'jquery'
],
function(ko, Component, $) {
    'use strict';
    return Component.extend({
        firstName: ko.observable(''),
        initialize: function() {
            this._super();
        },
        removeItem:  function(){
            $.ajax({
                type: "POST",
                url: "http://mage2.loc/renewcart/cart/delete",
                data: {
                    showLoader: true,
                    'id': id
                },
                success: function (data) {
                    alert('Success');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });
});
