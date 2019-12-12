<script class='controller'>
    setTimeout(function() {

        /*           ACTUALIZAR LISTADO               */
        $(document).off('click', "#updateDocs");
        $(document).on('click', '#updateDocs', function(e) {

            $('.waitPls').velocity("transition.slideUpIn");
            feedDocts();
        });

        /*           ACTUALIZAR LISTADO A CONECTADOS               */
        $(document).off('click', "#doctCon");
        $(document).on('click', '#doctCon', function(e) {
            $('.waitPls').velocity("transition.slideUpIn");
            // CREAMOS EL RANGO DE FECHAS QUE SE MOSTRARA EN EL GRAFICO
            var today = new Date(),
                dd = today.getDate(),
                mm = today.getMonth() + 1,
                yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            today = yyyy + '-' + mm + '-' + dd;
            $('div.row.doctorsFetchedList > div.anim').each(function(i) {
                var date = $(this).find('.thisDoctLastCon').html();
                if (date == today) {
                    $(this).addClass('fkon');
                } else {
                    $(this).removeClass('fkon');
                }
            });

            $('.anim').velocity("transition.slideUpBigOut");
            setTimeout(function() {
                $('.fkon').velocity("transition.slideUpBigIn");
                    $('.waitPls').velocity("transition.slideUpBigOut");
            }, 2000);
        });

        /*           ACTUALIZAR LISTADO A INACTIVOS               */
        $(document).off('click', "#doctIn");
        $(document).on('click', '#doctIn', function(e) {
            $('.waitPls').velocity("transition.slideUpIn");
            // CREAMOS EL RANGO DE FECHAS QUE SE MOSTRARA EN EL GRAFICO
            var today = new Date(),
                dd = today.getDate(),
                mm = today.getMonth() + 1,
                yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            today = yyyy + '-' + mm + '-' + dd;
            $('div.row.doctorsFetchedList > div.anim').each(function(i) {
                var date = $(this).find('.thisDoctLastCon').html();
                if (date != today) {
                    $(this).addClass('fkon');
                } else {
                    $(this).removeClass('fkon');
                }
            });

            $('.anim').velocity("transition.slideUpBigOut");
            setTimeout(function() {
                $('.fkon').velocity("transition.slideUpBigIn");
                    $('.waitPls').velocity("transition.slideUpBigOut");
            }, 2000);
        });

        feedDocts();
    }, 1000);

    function feedDocts() {
        var formData = new FormData();
        formData.append('meth', 'feedDoct');
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
                    $('.doctorsFetchedList').remove();
                    $('.side-app').append(data.html);

                    $('.anim').velocity("transition.slideUpBigIn", {
                        stagger: 100
                    });

                } else {
                    console.log('hubo un error #892445');
                }
            },
            error: function(error) {
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });
    }
</script>