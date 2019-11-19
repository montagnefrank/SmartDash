<script>
    $(document).ready(function () {

        /*           DETECTAMOS SI HAY SESION ALMACENADA               */
        setTimeout(function () {
            var userIntel = window.localStorage.getItem("userIntel");
            if (userIntel) {
                var jsonObj = $.parseJSON('[' + userIntel + ']');
                userIntel = jsonObj[0];
                showPanel(userIntel.panelUsuario, userIntel.idUsuario);
            } else {
                showPanel();
            }
        }, 3000);

        /*           INICIO DE SESION               */
        $(document).on('click', '#loginBtn', function (e) {
            e.preventDefault();
            var username = $(document).find('.username').val();
            var password = $(document).find('.password').val();

            /// VALIDAMOS QUE NO EXISTAN CAMPOS VACIOS ///
            if (username == '') {
                $.growl.warning({
                    message: "Ingrese su nombre de usuario"
                });
                return false;
            }
            if (password == '') {
                $.growl.warning({
                    message: "Ingrese su contraseña"
                });
                return false;
            }

            $("#loading").slideDown("slow");
            var formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);
            formData.append('apiuri', apiURI);
            formData.append('meth', 'login');
            $.ajax({
                url: apiURI, type: 'POST', dataType: "json", cache: false, contentType: false, processData: false, data: formData,
                success: function (data) {
                    if (data.scriptResp == "noMatch") {
                        $("#loading").slideUp("slow", function () {
                        $.growl.error({
                            message: "Usuario o contraseña incorrectos"
                        })
                        });;
            //    $('.username').val('');
            //    $('.password').val('');
                    }
                    if (data.scriptResp == "match") {
                        window.localStorage.setItem("userIntel", JSON.stringify(data.userIntel));
                        showPanel(data.userIntel.panelUsuario, data.userIntel.idUsuario);
                    }
                },
                error: function (error) {
                    console.log("Hubo un error de internet, intente de nuevo");
                    console.log(error);
                }
            });
        });

        /*           CIERRE DE SESION               */
        $(document).on('click', '.logOutBtn', function (e) {
            $("#loading").slideDown("slow", function () {
                window.localStorage.clear();
                showPanel();
            });
        });

        /*           CAMBIAR DE PANEL MOSTRADO             */
        $(document).on('click', '.changePanel', function (e) {
            var self = this,
                userIntel = JSON.parse(window.localStorage.getItem("userIntel")),
                panelToShow = $(self).attr('data-panel'),
                userId = $('#sidebarLoaded').attr('userIdPanel');

            if(panelToShow != userIntel.panelUsuario){
                $("#loading").slideDown("slow", function () {
                    showPanel(panelToShow, userId);
                });
            }
            ;
        });
        
        /*           INICIAR CON GOOGLE              */
        $(document).on('click', '#googleIn', function (e) {
            $(document).find('.g-signin2 > div').click();
        });
    });

    /** Mostramos el contenido del menu seleccionado, si no se ha seleccionado nigun menu retorna la ventana de Login */
    function showPanel(p, u) {
        var userIntel = window.localStorage.getItem("userIntel");
        var jsonObj = $.parseJSON('[' + userIntel + ']');
        userIntel = jsonObj[0];
        var formData = new FormData();
        formData.append('panel', p);
        formData.append('user', u);
        formData.append('meth', 'loadPanel');
        return $.ajax({
            url: apiURI, type: 'POST', dataType: "json", cache: false, contentType: false, processData: false, data: formData,
            success: function (data) {
                if (data.scriptResp == "loaded") {console.log(data);
                    $('body div.page').remove();
                    $('body').attr("class", data.panelName + ' app sidebar-mini');
                    var view = populate(data.panelName, data.panel);
                    $(view).insertAfter("#loading");
                    $('body').append(data.control);
                    if (data.panelName != 'login') {
                        loadSideBar(userIntel.idUsuario);
                        var userPanel = JSON.parse(window.localStorage.getItem("userIntel"));
                        userPanel.panelUsuario = data.panelName;
                        window.localStorage.setItem("userIntel", JSON.stringify(userPanel));
                    } else {
                        showLogin();
                    }
                    $("#loading").slideUp("slow");
                }
            },
            error: function (error) {
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });
    }

    /** EN STA FUNCION POBLAMOS LAS VARIABLES DE LAS PLANTILLAS HTML CON LOS DATOS DE NUESTRA APP */
    function populate(panel, code) {
        var userIntel = window.localStorage.getItem("userIntel");
        var jsonObj = $.parseJSON('[' + userIntel + ']');
        userIntel = jsonObj[0];
        code = code.split("___DERECHOSDEAUTOR___").join('<a href="#">Descomplicate </a>© 2019. Todos los derechos reservados.');
        code = code.split("___APPNAME___").join('Descomplicate Administrativo');
        code = code.split("___APIURI___").join(apiURI);
        if (panel == "home") {
            return code;
        }
        if (panel == "login") {
            return code;
        }
        if (panel == "sideBar") {
            code = code.split("___PATHTOPROFILEPIC___").join(userIntel.userImg);
            code = code.split("___NOMBRESUSUARIO___").join(userIntel.nombreUsuario);
            code = code.split("___ROLUSUARIO___").join(userIntel.rolUsuario);
            code = code.split("___IDUSUARIO___").join(userIntel.idUsuario);
            return code;
        }
        if (panel == "news") {
            return code;
        }
        if (panel == "cats") {
            return code;
        }
        if (panel == "blog") {
            return code;
        }
        if (panel == "users") {
            return code;
        }
        if (panel == "userconfig") {
            return code;
        }
        return code;
    }

    /** EL USUARIO DEPENDINEDO DE SU ROL RECIBE UN SIDEBAR DIFERENTE */
    function loadSideBar(u) {

        var formData = new FormData();
        formData.append('user', u);
        formData.append('meth', 'showSideBar');
        return $.ajax({
            url: apiURI, type: 'POST', dataType: "json", cache: false, contentType: false, processData: false, data: formData,
            success: function (data) {
                if (data.scriptResp == "loaded") {
                    var view = populate('sideBar', data.sideb);
                    $(view).insertBefore("#appContent");
                    fixsb();
                }
            },
            error: function (error) {
                console.log("Hubo un error de internet, intente de nuevo");
                console.log(error);
            }
        });
    }
    
    /** CARGAMOS LA FUNCIONALIDAD DEL SIDEBAR YA QUE ESTAMOS LLAMANDOLO DE FORMA ASINCRONA */
    function fixsb() {
        (function () {
            "use strict";

            var slideMenu = $('.side-menu');

            // Toggle Sidebar
            $('[data-toggle="sidebar"]').click(function (event) {
                event.preventDefault();
                $('.app').toggleClass('sidenav-toggled');
            });

            if ($(window).width() > 739) {
                $('.app-sidebar').hover(function (event) {
                    event.preventDefault();
                    $('.app').removeClass('sidenav-toggled');
                });
            }

            // Activate sidebar slide toggle
            $("[data-toggle='slide']").click(function (event) {
                event.preventDefault();
                if (!$(this).parent().hasClass('is-expanded')) {
                    slideMenu.find("[data-toggle='slide']").parent().removeClass('is-expanded');
                }
                $(this).parent().toggleClass('is-expanded');
            });

            // Set initial active toggle
            $("[data-toggle='slide.'].is-expanded").parent().toggleClass('is-expanded');

            //Activate bootstrip tooltips
            $("[data-toggle='tooltip']").tooltip();

        })();

        // searching toggle
        var sp = document.querySelector('.search-open');
        var searchbar = document.querySelector('.search-inline');
        var shclose = document.querySelector('.search-close');
        function changeClass() {
            searchbar.classList.add('search-visible');
        }
        function closesearch() {
            searchbar.classList.remove('search-visible');
        }
        sp.addEventListener('click', changeClass);
        shclose.addEventListener('click', closesearch);
    }

    /**  ANIMAMOS LA VENTANA DE LOGIN PARA APARECER */                       
    function showLogin() {
        setTimeout(function () {
            $(document).find("body.login > div.page > div > div.masthead").velocity("transition.slideLeftBigIn", 200);
            $(document).find("body.login > div.page > div > div.masthead .animLv2").delay(500).velocity("transition.slideRightBigIn");
            $(document).find("body.login > div.page > div > div.masthead .animLv3").delay(1200).velocity("transition.slideUpBigIn", {stagger: 200});
            enterSubm();
        }, 1000);
    }

    /** FUNCIONALIDAD DE LOS INPUTS DE LOGIN */
    function enterSubm(){
        $('.submitEnterUser').keypress(function (e) { 
            if (e.which == 13) {
                $('.submitEnter').focus();
            }
        });
        $('.submitEnter').keypress(function (e) { 
            if (e.which == 13) {
                $(document).find('#loginBtn').click();
            }
        });
        setTimeout(function () {
            $(document).find('#submitEnterUser').focus();
        }, 2500);
    }

    /** EN CAS ODE QUE EL USUARIO YA SE HAYA INICIADO CON GOOGLE */
    function onSignIn(googleUser) {
        $("#loading").slideDown("slow", function () {
            var profile = googleUser.getBasicProfile();
            email = profile.getEmail().split("@");
            if(email[1] == 'descomplicate.com.ec'){
                var formData = new FormData();
                formData.append('fullname', profile.getName());
                formData.append('pic', profile.getImageUrl());
                formData.append('email', profile.getEmail());
                formData.append('meth', 'googlelogin');
                $.ajax({
                    url: apiURI, type: 'POST', dataType: "json", cache: false, contentType: false, processData: false, data: formData,
                    success: function (data) {
                        if (data.scriptResp == "match") {
                            window.localStorage.setItem("userIntel", JSON.stringify(data.userIntel));
                            showPanel(data.userIntel.panelUsuario, data.userIntel.idUsuario);
                        }
                    },
                    error: function (error) {
                        console.log("Hubo un error de internet, intente de nuevo");
                        console.log(error);
                    }
                });
            } else {
                $("#loading").slideUp("slow", function () {
                    $.growl.error({
                        message: "Su cuenta de Google no está autorizada para acceder"
                    });
                });
            }
        });
    }
</script>