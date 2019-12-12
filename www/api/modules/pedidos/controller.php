<script class='controller'>
    setTimeout(function() {


        /*           ACTUALIZAR LISTADO               */
        $(document).off('click', "#updatePeds");
        $(document).on('click', '#updatePeds', function(e) {

            $('.waitPls').velocity("transition.slideUpIn");
            feedPeds();
        });

        /*           ACTUALIZAR DETALLES               */
        $(document).off('click', ".verDetallesPedido");
        $(document).on('click', '.verDetallesPedido', function(e) {

            var self = this;
            $(self).find('span').hide();
            $(self).find('.vericon').attr('class', 'fa fa-spinner fa-spin');

            $('#detNombCont').html($(self).find('.detNomb').html() + ' ' + $(self).find('.detApel').html());
            $('#detCeduCont').html($(self).find('.detCedu').html());
            $('#detPhoneCont').html($(self).find('.detCel').html());
            $('#detEmailCont').text($(self).find('.detEmail').html());
            $('#detAddrCont').html($(self).find('.detAddr').html());
            $('#detRefeCont').html($(self).find('.detRefe').html());
            $('#detFechaCont').text($(self).find('.detCreado').html().substring(5, 19));
            $('#detSympCont').html($(self).find('.detSymp').html());
            $('#detArriCont').html($(self).find('.detArri').html());
            $('#detScorCont').text($(self).find('.detSco').html());


            /** GOOGLE MAPS */

            function initMapDet() {
                mapOptions = {
                    zoom: 14,
                    center: new google.maps.LatLng(Number($(self).find('.detLat').html()), Number($(self).find('.detLong').html())),
                    styles: [{
                            "featureType": "administrative",
                            "elementType": "all",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "lightness": 33
                                }
                            ]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [{
                                "color": "#f2e5d4"
                            }]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#c5dac6"
                            }]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "labels",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "lightness": 20
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [{
                                "lightness": 20
                            }]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#c5c6c6"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#e4d7c6"
                            }]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#fbfaf7"
                            }]
                        },
                        {
                            "featureType": "water",
                            "elementType": "all",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#acbcc9"
                                }
                            ]
                        }
                    ]
                };
                mapElement = document.getElementById('mapDet');
                mapPed = new google.maps.Map(mapElement, mapOptions);
                mark = new google.maps.Marker({
                    map: mapPed,
                    position: {
                        lat: Number($(self).find('.detLat').html()),
                        lng: Number($(self).find('.detLong').html())
                    },
                    title: $(self).find('.detAddr').html(),
                    icon: {
                        url: apiURI + "assets/img/usermarker.png",
                        scaledSize: new google.maps.Size(35, 50)
                    }
                });
            }
            initMapDet();
            setTimeout(function() {
                $('.animlv1').velocity("transition.slideUpBigOut", function() {
                    $('.animlv2').velocity("transition.slideUpBigIn");
                });
                setTimeout(function() {
                    $(self).find('span').show();
                    $(self).find('.fa-spinner').attr('class', 'fa fa-share-square-o vericon');
                }, 1000);
            }, 1000);

        });

        /*           REGRESAR AL LISTADO               */
        $(document).off('click', ".returntoList");
        $(document).on('click', '.returntoList', function(e) {
            $('.animlv2').velocity("transition.slideUpBigOut", function() {
                $('.animlv1').velocity("transition.slideUpBigIn");
            });
        });

        feedPeds();
    }, 1000);
    var mapOptions, mapElement, mapPed, mark;

    function feedPeds() {

        var formData = new FormData();
        formData.append('meth', 'feedPed');
        formData.append('apiuri', apiURI);
        $.ajax({
            url: apiURI,
            type: 'POST',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                if (data.scriptResp == "done") {
                    $('.waitPls').velocity("transition.slideUpOut");
                    $('#pedidosList > tbody').html(data.html);
                    $('#pedidosList').DataTable();

                    $('.animlv2').velocity("transition.slideUpBigOut");
                    $('.animlv1').velocity("transition.slideUpBigIn", {
                        stagger: 100
                    });
                } else {
                    console.log('hubo un error #23788654');
                }
            },
            error: function(error) {
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });
    }
</script>