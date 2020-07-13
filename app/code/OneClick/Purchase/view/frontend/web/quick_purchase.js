require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function(
        $,
        modal
    ) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            modalClass: 'my-first-modal'
        };

        var popup = modal(options, $('#my-popup'));
        $("#one-click-button").click(function () {
            $('.modal-footer').hide();
            $('.my-first-modal').attr('id', 'my-first-modal');
            $("#my-popup").modal("openModal");
        });

        $("#order-submit").click(function () {
            $('.order-form').attr('hidden','hidden');
            $('.preloader').removeAttr('hidden', 'hidden');
            let skuDiv = $('.sku').children('.value');

            let sku = skuDiv[0]['innerHTML'];
            let telephone = $('#order-input-telephone').val();
            let name = $('#order-input-name').val();
            let lastName = $('#order-input-lastname').val();
            let middleName = $('#order-input-middlename').val();
            let email = $('#order-input-email').val();
            $.ajax({
                type: "POST",
                url: "http://mage2.loc/oneclick/index/index",
                data: {
                    'telephone': telephone,
                    'name': name,
                    'last_name' : lastName,
                    'middle_name' : middleName,
                    'email': email,
                    'sku': sku
                },
                success: function (data) {
                    $("#my-popup").modal("closeModal");
                },
                    error: function (data) {
                        console.log(data);
                }
            });
        });

        $('#order-input-email').keyup(function () {

            let email = $(this).val();
            if (validateEmail(email)) {
                $('#order-submit').removeAttr('disabled');
                $(this).css('background', '');
            }
            else{
                $('#order-submit').attr('disabled', 'disabled');
                $(this).css('background', 'pink');
            }
        })
        $('#order-input-telephone').keyup(function () {

            let telephone = $(this).val();
            if (validateTelephone(telephone)) {
                $('#order-submit').removeAttr('disabled');
                $(this).css('background', '');
            }
            else{
                $('#order-submit').attr('disabled', 'disabled');
                $(this).css('background', 'pink');
            }
        })

        function validateEmail(email){
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function validateTelephone(telephone){
            var phoneno = /^\+?([0-9]{3})\)?([0-9]{9})$/;
            if(telephone.match(phoneno)){
                return true;
            }
            else{
                return false;
            }
        }
    });