define([
    "jquery"
], function($){
    $(document).on('click', '[name="product[use_config_custom_price]"]', function () {
        let value = $(this).val();
        if(value === '0'){
            $('[name="product[custom_price]"]').removeAttr( 'disabled' );
            $('[data-index="custom_price"]').attr( 'class','admin__field' );
        }
        else {
            $('[name="product[custom_price]"]').attr( 'disabled', 'true' );
            $('[data-index="custom_price"]').attr( 'class','admin__field _disabled' );
        }
    })
});