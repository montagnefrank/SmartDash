<script class='controller'>
    setTimeout(function() {

        
        /*           ACTUALIZAR LISTADO               */
        $(document).off('click', "#updatePeds");
        $(document).on('click', '#updatePeds', function(e) {
            
            $('.waitPls').velocity("transition.slideUpIn");
            feedPeds();
        });

        /*           ACTUALIZAR DETALLES               */
        $(document).off('click', "#updatePeds");
        $(document).on('click', '#updatePeds', function(e) {
            
            $('.waitPls').velocity("transition.slideUpIn");
            feedPeds();
        });

        feedPeds();
    }, 1000);

    function feedPeds(){
        
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

                    $('.animlv1').velocity("transition.slideUpBigIn", {
                        stagger: 100
                    });
                } else {
                    console.log('hubo un error #23788654');
                }
            },
            error: function(error) {
                $('body').append('<center>revise su conexion</center>');
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });
    }
</script>