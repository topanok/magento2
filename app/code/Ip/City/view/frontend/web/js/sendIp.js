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
            innerScroll: true
        };

        var popup = modal(options, $('#big-popup'));
        $(".button-choose-location").click(function () {
            $('.mini-popup').hide();
            $('.modal-footer').hide();
            $('#livesearch-input').val('');
            $("#big-popup").modal("openModal");
        });

        $('.action-close').on('click', function (){
            let ip = $('#user-ip').val();
            if(!$.cookie(ip)) {
                $('.mini-popup').show();
            }
        })

        $.getJSON("https://api.ipify.org/?format=json", function(e) {
            let ip = e.ip;
            if(!$.cookie(ip)) {
                $('.mini-popup').show();
            }
            $('#user-ip').val(e.ip);
            if(!$.cookie(ip)) {
                let ipStackAccessKey = '7bc3519d07085d7f07d82e5026b819c7';
                $.ajax({
                    url: 'http://api.ipstack.com/' + ip,
                    data: {
                        'access_key': ipStackAccessKey
                    },
                    success: function (res) {
                        $.ajax({
                            type: 'GET',
                            url: 'https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=' + res.latitude + '&longitude=' + res.longitude + '&localityLanguage=uk',
                            success: function (result) {
                                let city = result.city;
                                if(!city){
                                    city = result.principalSubdivision;
                                }
                                $('.city-name').html(city).css('text-decoration-color', 'white');
                                $('#insert-chosen-city').html(city);
                                $('#user-city-hidden').val(city);
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
            else{
                $('.mini-popup').hide();
                $('.city-name').html($.cookie(ip));
            }
        });

        $('#confirm-city').on('click', function (){
            let ip = $('#user-ip').val();
            var city = $('#user-city-hidden').val();
            $.cookie(ip, city, { expires : 30 });
            $('.mini-popup').hide();
        });

        $('#livesearch-input').on('keyup', function (){
            let str = $(this).val();
            if (str.length>=3) {
                var settings = {
                    "url": "https://api.novaposhta.ua/v2.0/json/",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "content-type": "application/json"
                    },
                    "data": JSON.stringify({"modelName":"Address",
                        "calledMethod":"getCities",
                        "methodProperties": {
                            "FindByString": str
                        },
                        "apiKey":"c6ff540b4e52b8dfa2efe5482d6e7fe7"
                    }),
                };

                $.ajax(settings).done(function (response) {
                    var html = '';
                    for(let i=0; i<response.data.length; i++) {
                        html += '<div class="selectmenu-item" onmouseover="this.style.background=\'#C0C0C0\'" onmouseout="this.style.background=\'\'" id="' + response.data[i].Ref + '">' + response.data[i].Description + '</div>';
                    }
                    document.getElementById("livesearch").innerHTML = html;
                    document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
                    $('#livesearch').show();
                });
            }
            else {
                $('#livesearch').hide();
            }
        });

        document.getElementById("livesearch").addEventListener("click", function (e){
            let cityForChoose = e.target;
            var choosenCity = $(cityForChoose).text();
            $('#livesearch-input').val(choosenCity).css('color', 'green');
            $('#livesearch').hide();
        });

        $('#saveChosenCity').on('click', function (){
            let city = $('#livesearch-input').val();
            let ip = $('#user-ip').val();
            $('.city-name').html(city);
            if($.cookie(ip)) {
                $.cookie(ip, '', {expires: -1});
            }
            $.cookie(ip, city, { expires : 30 });
            $('.mini-popup').hide();
        })
    });