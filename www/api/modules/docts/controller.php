<script class='controller'>
    setTimeout(function() {


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
                    $('.side-app').append(data.html);

                    $('.anim').velocity("transition.slideUpBigIn", {
                        stagger: 100
                    });

                } else {
                    console.log('hubo un error #892445');
                }
            },
            error: function(error) {
                $('body').append('<center>revise su conexion</center>');
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });
    }, 1000);
</script>