<?php
session_start();
date_default_timezone_set('America/Bogota');
$fechaHoy = date('Y-m-d');
$horaHoy = date('H:i:s');
if (isset($_SESSION['UsuarioIngresoSurveyTools'])) {
    $UsuarioIngresoSurveyTools = $_SESSION['UsuarioIngresoSurveyTools'];
    if (trim($UsuarioIngresoSurveyTools) == "") {
        echo '<script> window.location="logout.php"; </script>';
        exit;
    }
    $IdUserSurveyTools = $_SESSION['IdUserSurveyTools'];
    $AccesoUserSurveyTools = $_SESSION['AccesoUserSurveyTools'];

    include_once("config.php");
    include_once("functions.php");

    $ConexionDB = $FunctionsPHP->ConexionBD();

    $AccesoUserSurveyTools = $_SESSION["AccesoUserSurveyTools"];
    if ($AccesoUserSurveyTools < 1) {
        echo '<script> window.location="logout.php"; </script>';
        exit;
    }

    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

    /* $SelectBuscandoSiHayPreguntas = "EXEC SPR_GET_PREGUNTAS_CRM_CLARO_ID '$IdUserSurveyTools'";
    $ResultConsultaDB = sqlsrv_query($ConexionDB, $SelectBuscandoSiHayPreguntas, $params, $options);

    if (sqlsrv_num_rows($ResultConsultaDB) > 0) {
    } else {
        echo '<script> window.location="CambiarPreguntas.php?IdCambio=ModuloPreguntas";</script>';
        exit;
    } */

    switch ($AccesoUserSurveyTools) {
        case '1':
            echo '<script> window.location="ModuloProcesamientoResultados.php"; </script>';
            break;
        default:
            echo '<script> window.location="logout.php"</script>';
            break;
    }
    exit;
}
session_destroy();
?>

<!doctype html>
<html lang="es">

<?php
require_once("head.php");
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
    body {
        background: url(img/Analitica.webp) no-repeat center center fixed;
        margin: 0;
        padding: 0;
        height: 100vh;
        background-size: cover;
    }



    .header-content {
        margin: auto;
    }

    input {
        text-align: center;
    }

    .copyright {
        color: white !important;
    }





    .LabelErrorCaptcha {
        background: red;
        color: white;
    }
</style>

<body>

    <section class="backgroun" style="">
        <div class="container py-2">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-5 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-3 mx-md-4">

                                    <div class="text-center">
                                        <img src="https://s3.amazonaws.com/media.greatplacetowork.com/peru/best-workplaces-in-peru/2023/2-de-251-a-1000/07-izipay/logo-01.png"
                                            style="width: 50%;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-2">CRM</h4>
                                    </div>

                                    <form>


                                        <div class="form-outline mb-1">
                                            <label class="form-label text-danger" for="form2Example11">Usuario:</label>
                                            <input type="email" id="form2Example11"
                                                class="form-control mr-2 ml-2"
                                                placeholder="jveras@atento.com" />
                                        </div>


                                        <div class="form-outline mb-4">
                                            <label class="form-label text-danger"
                                                for="form2Example22">Contraseña:</label>
                                            <input type="password" id="form2Example22" class="form-control" />

                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-2 text-center">
                                                <div class="form-group mx-auto">
                                                    <!-- Agregado mx-auto para centrar horizontalmente -->
                                                    <div class="g-recaptcha"
                                                        data-sitekey="6LeLaScpAAAAABpGR7VYJAf0qzXA8EplCBoAE3nC"></div>
                                                </div>
                                                <br>
                                                <label class="form-label LabelErrorCaptcha">Por favor completar el
                                                    Captcha...</label>
                                            </div>
                                        </div>
                                        <div class="text-center pt-0 mb-5 pb-0">
                                            <button class="btn btn-block text-light fa-lg gradient-custom-2 mb-3 "
                                                type="button">
                                                Iniciar Session</button>
                                            <!-- <a class="text-muted" href="#!">Olvidaste tu Contraseña?</a> -->
                                        </div>

                                        <!-- <div class="d-flex align-items-center justify-content-center pb-4">
                                                <p class="mb-0 me-2">¿No tienes una cuenta?</p>
                                                <button type="button" class="btn btn-outline-danger">Crear
                                                    Nuevo</button>
                                            </div> -->

                                        <?php

                                        require_once("footer.php");
                                        ?>
                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-4 d-none d-lg-block d-flex align-items-center rounded-5">
                                <img src="https://play-lh.googleusercontent.com/dYeFdsQgBR8sIQCdab-yK9ASGIC4a5NgQnEJQydr84a_tOv4G8uBeGx6NxeLzTSa5A"
                                    style="width: 150%; height: 100%; border-top-right-radius: 35px; border-bottom-right-radius: 35px;"
                                    alt="logo">
                                    
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- 

        <div class="row">
                <div class="col-md-10" id="logo_atento">
                    <div class="">
                        <img src="https://atento.com/wp-content/uploads/2021/01/logo-atento.png">
                    </div>
                </div>
            </div> -->

    </section>

</body>

<?php
require_once("script.php");
?>

<script>
    //Para Validar El Logueo Del Aplicativo
    $(document).ready(function () {
        $(".LabelErrorCaptcha").hide();
        $("#FormularioLoginSurveyTools").submit(function (event) {
            event.preventDefault();
            formData = $(this).serializeArray();
            NameRecaptchaResponse = "g-recaptcha-response";
            var ResponseRecaptcha = formData.find(function (element) {
                return element.name === NameRecaptchaResponse;
            });
            if (ResponseRecaptcha) {
                if (ResponseRecaptcha.value === "") {
                    $(".LabelErrorCaptcha").show();
                    $(".CaptchaGroup div div").attr("class", "g-recaptcha-error")
                    return "";
                }
            } else {
                $(".LabelErrorCaptcha").show();
                $(".CaptchaGroup div div").attr("class", "g-recaptcha-error")
                return "";
            }
            $(".LabelErrorCaptcha").hide();
            $(".CaptchaGroup div div").removeAttr("class")
            $.ajax({
                type: 'POST',
                url: 'ValidarLogueoSurveyTools.php',
                data: $(this).serializeArray(),
            }).done(function (ResponseLogin) {
                ResponseLogin = JSON.parse(ResponseLogin);
                if (ResponseLogin.Mensaje === "Exito") {
                    if (ResponseLogin.Cantidad > 0) {
                        if (ResponseLogin.Informacion === "Exitoso") {
                            location.reload();
                        } else if (ResponseLogin.Informacion === "SinAcceso") {
                            swal({
                                title: "Usuario no tiene un perfil asignado.\nPor favor validar nuevamente...",
                                text: "",
                                icon: "warning"
                            });
                            $.ajax({
                                type: 'POST',
                                url: 'logout.php',
                                data: {}
                            });
                        }
                    } else {
                        if (ResponseLogin.Informacion === "ErrorCredenciales") {
                            swal({
                                title: "Usuario o Contraseña incorrecto.\nPor favor validar las credenciales ingresadas...",
                                text: "",
                                icon: "warning"
                            });
                        } else if (ResponseLogin.Informacion === "ErrorCaptcha") {
                            swal({
                                title: "No se ha podido validar el Captcha, por favor intentar nuevamente...",
                                text: "",
                                icon: "warning"
                            });
                        } else if (ResponseLogin.Informacion === "ErrorBD") {
                            swal({
                                title: "No se ha podido conectar con la Base de Datos, por favor intentar nuevamente...",
                                text: "",
                                icon: "error"
                            });
                        }
                    }
                } else {
                    window.location = "logout.php";
                }
            });
        });
    });
</script>
<script>
    window.sr = ScrollReveal();
    sr.reveal('.header-content', {
        duration: 3000,
        origin: 'left',
        distance: '500px'
    });
</script>

</html>