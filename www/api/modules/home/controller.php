<script class='controller'>
    setTimeout(function() {

        /*           ACTUALIZAR CONTADORES               */
        $(document).off('click', "#updateCharts");
        $(document).on('click', '#updateCharts', function(e) {
            $('.waitPls').velocity("transition.slideUpIn");
            var formData = new FormData();
            formData.append('meth', 'feedHome');
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

                        // INDICADORES
                        $('#newClis').html(data.treg.length);
                        $('#newProv').html(data.tdoc.length);
                        $('#allped').html(data.tped.length);
                        $('#peda').html(data.tpeda.length);
                        $('#pedab').html(data.tpedab.length);

                        // OBJETOS
                        $('#newClis_obj').html(JSON.stringify(data.treg));
                        $('#newProv_obj').html(JSON.stringify(data.tdoc));
                        $('#allped_obj').html(JSON.stringify(data.tped));
                        $('#peda_obj').html(JSON.stringify(data.tpeda));
                        $('#pedab_obj').html(JSON.stringify(data.tpedab));

                        // ALIMENTAMOS LSO GRAFICOS
                        buidlEchart(data);
                        buidDonut(data);
                        buildArea(data);
                        initMap(data);

                        console.log('indicadores actualizados');
                    } else {
                        console.log('hubo un error #3343234');
                    }
                },
                error: function(error) {
                    console.log("Hubo un error de internet, intente de nuevo");
                    console.log(error);
                }
            });
        });

        /*           FILTROS DE MAPA DE CALOR               */
        $(document).off('click', "#filterMedic");
        $(document).on('click', '#filterMedic', function(e) {

            for (var i = 0; i < tdocMarker.length; i++) {
                tdocMarker[i].setAnimation(google.maps.Animation.DROP);
                tdocMarker[i].setMap(mapHome);
            }
            for (var i = 0; i < tregMarker.length; i++) {
                tregMarker[i].setMap(null);
            }
            for (var i = 0; i < tpedMarker.length; i++) {
                tpedMarker[i].setMap(null);
            }
        });
        $(document).off('click', "#filterClient");
        $(document).on('click', '#filterClient', function(e) {
            for (var i = 0; i < tregMarker.length; i++) {
                tregMarker[i].setAnimation(google.maps.Animation.DROP);
                tregMarker[i].setMap(mapHome);
            }
            for (var i = 0; i < tdocMarker.length; i++) {
                tdocMarker[i].setMap(null);
            }
            for (var i = 0; i < tpedMarker.length; i++) {
                tpedMarker[i].setMap(null);
            }
        });
        $(document).off('click', "#filterPed");
        $(document).on('click', '#filterPed', function(e) {
            for (var i = 0; i < tpedMarker.length; i++) {
                tpedMarker[i].setAnimation(google.maps.Animation.DROP);
                tpedMarker[i].setMap(mapHome);
            }
            for (var i = 0; i < tregMarker.length; i++) {
                tregMarker[i].setMap(null);
            }
            for (var i = 0; i < tdocMarker.length; i++) {
                tdocMarker[i].setMap(null);
            }
        });
        $(document).off('click', "#filterAll");
        $(document).on('click', '#filterAll', function(e) {
            for (var i = 0; i < tregMarker.length; i++) {
                tregMarker[i].setAnimation(google.maps.Animation.DROP);
                tregMarker[i].setMap(mapHome);
            }
            for (var i = 0; i < tdocMarker.length; i++) {
                tdocMarker[i].setAnimation(google.maps.Animation.DROP);
                tdocMarker[i].setMap(mapHome);
            }
            for (var i = 0; i < tpedMarker.length; i++) {
                tpedMarker[i].setAnimation(google.maps.Animation.DROP);
                tpedMarker[i].setMap(mapHome);
            }
        });

        var formData = new FormData();
        formData.append('meth', 'feedHome');
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
                    $('.card').velocity("callout.swing", {
                        stagger: 300
                    });

                    // INDICADORES
                    $('#newClis').html(data.treg.length);
                    $('#newProv').html(data.tdoc.length);
                    $('#allped').html(data.tped.length);
                    $('#peda').html(data.tpeda.length);
                    $('#pedab').html(data.tpedab.length);

                    // ACTIVAR CONTADORES
                    $('.countInd').countUp();

                    // OBJETOS
                    $('#newClis_obj').html(JSON.stringify(data.treg));
                    $('#newProv_obj').html(JSON.stringify(data.tdoc));
                    $('#allped_obj').html(JSON.stringify(data.tped));
                    $('#peda_obj').html(JSON.stringify(data.tpeda));
                    $('#pedab_obj').html(JSON.stringify(data.tpedab));

                    // ALIMENTAMOS LSO GRAFICOS
                    buidlEchart(data);
                    setTimeout(function() {
                        buidDonut(data);
                    }, 2000);
                    setTimeout(function() {
                        buildArea(data);
                    }, 3000);
                    setTimeout(function() {
                        initMap(data);
                    }, 4000);
                } else {
                    console.log('hubo un error #642356');
                }
            },
            error: function(error) {
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });

    }, 1000);

    /** GOOGLE MAPS */
    var mapOptions, mapElement, mapHome, tregMarker = [],
        tdocMarker = [],
        tpedMarker = [];

    function initMap(data) {
        mapOptions = {
            zoom: 14,
            center: new google.maps.LatLng(-0.1827847, -78.4843605), // QUITO
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
        mapElement = document.getElementById('mapShow');
        mapHome = new google.maps.Map(mapElement, mapOptions);

        for (var i = 0; i < data.treg.length; i++) {

            tregMarker.push(new google.maps.Marker({
                map: mapHome,
                position: {
                    lat: Number(data.treg[i].latitude),
                    lng: Number(data.treg[i].longitude)
                },
                title: data.treg[i].first_name + ' ' + data.treg[i].last_name + ' | ' + data.treg[i].email,
                icon: {
                    url: apiURI + "assets/img/usermarker.png",
                    scaledSize: new google.maps.Size(35, 50)
                }
            }));
        }
        for (var i = 0; i < data.tdoc.length; i++) {
            tdocMarker.push(new google.maps.Marker({
                map: mapHome,
                position: {
                    lat: Number(data.tdoc[i].latitude),
                    lng: Number(data.tdoc[i].longitude)
                },
                title: data.tdoc[i].first_name + ' ' + data.tdoc[i].last_name + ' | ' + data.tdoc[i].email,
                icon: {
                    url: apiURI + "assets/img/doctormarker.png",
                    scaledSize: new google.maps.Size(35, 50)
                }
            }));
        }
        for (var i = 0; i < data.tped.length; i++) {
            tpedMarker.push(new google.maps.Marker({
                map: mapHome,
                position: {
                    lat: Number(data.tped[i].latitude_client),
                    lng: Number(data.tped[i].longitude_client)
                },
                title: data.tped[i].email_client + ' | ' + data.tped[i].created_at.substring(5, 10),
                icon: {
                    url: apiURI + "assets/img/jobmarker.png",
                    scaledSize: new google.maps.Size(35, 50)
                }
            }));
        }
        $('#dataMap_obj').html(JSON.stringify(data));
    }

    // CREAR ARREGLO DE FECHAS DIA POR DIA
    function getDateArray() {
        // CREAMOS EL RANGO DE FECHAS QUE SE MOSTRARA EN EL GRAFICO
        var startDate = new Date("2019-11-11");
        var today = new Date(),
            dd = today.getDate() + 1,
            mm = today.getMonth() + 1,
            yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        today = yyyy + '-' + mm + '-' + dd;
        var endDate = new Date(today);

        var arr = new Array();
        var dt = new Date(startDate);
        while (dt <= endDate) {
            var thisday = new Date(dt),
                d = thisday.getDate() + 1,
                m = thisday.getMonth() + 1,
                y = thisday.getFullYear();
            if (d < 10) {
                d = '0' + d;
            }
            if (m < 10) {
                m = '0' + m;
            }
            if (m == 11) {
                if (d == 31) {
                    d = '01';
                    m = '12';
                }
            }
            thisday = m + '-' + d;
            arr.push(thisday);
            dt.setDate(dt.getDate() + 1);
        }

        return arr;
    }

    function buidlEchart(data) {

        var dateArr = getDateArray();
        dateArr.splice(-1, 1);
        var chartDates = [];
        for (var i = 0; i < dateArr.length; i++) {
            chartDates.push(dateArr[i]);
        }
        //var tot = chartDates.length;
        //var reme = +tot - 7;
        //chartDates.splice(0, reme); // CONTENEDOR DEL RANGO ULTIMOS 7 DIAS

        // OBTENEMOS LOS NUEVOS CLIENTES POR DIA
        var tregDays = [];
        for (var i = 0; i < chartDates.length; i++) {
            var counter = 0;
            for (var ii = 0; ii < data.treg.length; ii++) {
                var created = data.treg[ii].created_at.substring(5, 10);
                if (chartDates[i] == created) {
                    counter++;
                }
            }
            tregDays.push(counter);
        }

        // OBTENEMOS LOS PEDIDOS  POR DIA
        var tpedDays = [];
        for (var i = 0; i < chartDates.length; i++) {
            var counter = 0;
            for (var ii = 0; ii < data.tped.length; ii++) {
                var created = data.tped[ii].created_at.substring(5, 10);
                if (chartDates[i] == created) {
                    counter++;
                }
            }
            tpedDays.push(counter);
        }

        var chart = document.getElementById('activacioChart');
        var barChart = echarts.init(chart);
        var chartdata = [{
                name: 'Nuevos Clientes',
                type: 'line',
                smooth: true,
                data: tregDays,
                lineStyle: {
                    normal: {
                        width: 1
                    }
                },
                symbolSize: 10,
                lineStyle: {
                    normal: {
                        width: 3
                    }
                },
            },
            {
                name: 'Pedidos Nuevos',
                type: 'bar',
                smooth: true,
                data: tpedDays,
                lineStyle: {
                    normal: {}
                },
                itemStyle: {
                    normal: {
                        width: 1,
                        barBorderRadius: [3, 3, 0, 0],
                        color: new echarts.graphic.LinearGradient(
                            0, 0, 0, 1, [{
                                offset: 0,
                                color: '#4d83ff'
                            }, {
                                offset: 1,
                                color: '#4d83ff'
                            }]
                        )
                    }
                },
            }
        ];
        var option = {
            grid: {
                top: '6',
                right: '0',
                bottom: '17',
                left: '25',
            },
            xAxis: {
                data: chartDates,
                axisLine: {
                    lineStyle: {
                        color: 'rgba(167, 180, 201,.1)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#a7b4c9'
                }
            },
            tooltip: {
                show: true,
                showContent: true,
                alwaysShowContent: true,
                triggerOn: 'mousemove',
                trigger: 'axis',
                axisPointer: {
                    label: {
                        show: false,
                    }
                }
            },
            yAxis: {
                splitLine: {
                    lineStyle: {
                        color: 'rgba(167, 180, 201,.1)'
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: 'rgba(167, 180, 201,.1)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#a7b4c9'
                }
            },
            series: chartdata,
            color: ['#ffc94d', '#4d83ff']
        };
        barChart.setOption(option);
    }

    function buidDonut(data) {

        // GRAFICO DE DONA
        // OBTENEMOS LOS SINTOMAS 
        var contot = 0;
        for (var i = 0; i < data.tsym.length; i++) {
            contot = +contot + +data.tsym[i].total;
        }

        var tsymtotal = [];
        for (var i = 0; i < data.tsym.length; i++) {
            var cont = {};
            cont.label = data.tsym[i].symptom.substring(0, 15);
            cont.labelfull = data.tsym[i].symptom;
            cont.value = (+data.tsym[i].total * 100) / +contot;
            cont.value = cont.value.toFixed();
            tsymtotal.push(cont);
            if (i == 0) {
                $(".currentSintoma > h1").velocity("callout.pulse", 200).html(cont.labelfull + ' ' + cont.value + '%');
            }
        }
        $('#sitomorriss').html('');
        new Morris.Donut({
            element: 'sitomorriss',
            data: tsymtotal,
            colors: [
                '#4dffc9', '#4d83ff', '#ff4d83', '#ffc94d'

            ],
            formatter: function(x) {
                return x + "%"
            }
        }).on('click', function(i, row) {
            $(".currentSintoma > h1").velocity("callout.pulse", 200).html(row.labelfull + ' ' + row.value + '%');
        });
    }

    function buildArea(data) {

        var dateArr = getDateArray();
        dateArr.splice(-1, 1);
        var chartDates = [];
        for (var i = 0; i < dateArr.length; i++) {
            chartDates.push(dateArr[i]);
        }
        //var tot = chartDates.length;
        //var reme = +tot - 7;
        //chartDates.splice(0, reme); // CONTENEDOR DEL RANGO ULTIMOS 7 DIAS

        // OBTENEMOS LOS NUEVOS DOCTORES POR DIA
        var tdocnDays = [];
        for (var i = 0; i < chartDates.length; i++) {
            var counter = 0;
            for (var ii = 0; ii < data.tdocn.length; ii++) {
                var created = data.tdocn[ii].created_at.substring(5, 10);
                if (chartDates[i] == created) {
                    counter++;
                }
            }
            tdocnDays.push(counter);
        }

        // OBTENEMOS LOS DOCTORES CONECTADOS  POR DIA
        var tdocDays = [];
        for (var i = 0; i < chartDates.length; i++) {
            var counter = 0;
            for (var ii = 0; ii < data.tdoc.length; ii++) {
                var updated = data.tdoc[ii].updated_at.substring(5, 10);
                if (chartDates[i] == updated) {
                    counter++;
                }
            }
            tdocDays.push(counter);
        }

        var areaData2 = [{
                name: 'ult vez',
                type: 'line',
                smooth: true,
                data: tdocDays,
                symbolSize: 20,
                lineStyle: {
                    normal: {
                        width: 4,

                    }
                },

            },
            {
                name: 'creados',
                type: 'line',
                smooth: true,
                data: tdocnDays,
                symbolSize: 20,
                lineStyle: {
                    normal: {
                        width: 4,

                    }
                },
            }
        ];

        var optionArea2 = {
            grid: {
                top: '6',
                right: '12',
                bottom: '17',
                left: '25',
            },
            xAxis: {
                data: chartDates,
                boundaryGap: false,
                axisLine: {
                    lineStyle: {
                        color: 'rgba(167, 180, 201,.1)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#a7b4c9',
                    display: 'false'
                },
            },
            tooltip: {
                show: true,
                showContent: true,
                alwaysShowContent: true,
                triggerOn: 'mousemove',
                trigger: 'axis',
                axisPointer: {
                    label: {
                        show: false,
                    }
                }

            },
            yAxis: {
                splitLine: {
                    lineStyle: {
                        color: 'rgba(167, 180, 201,.1)'
                    },
                    display: false
                },
                axisLine: {
                    lineStyle: {
                        color: 'rgba(167, 180, 201,.1)'
                    },
                    display: false
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#a7b4c9'
                }
            },
            series: areaData2,
            color: ['#ff4d83', '#4d83ff']
        };

        var chartArea2 = document.getElementById('medTwo');
        var areaChart2 = echarts.init(chartArea2);
        areaChart2.setOption(optionArea2);
    }
</script>