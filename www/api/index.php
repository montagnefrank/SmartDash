<?php
/*
 *          ***********************************************************
 *          ***********||  DESCOMPLICATE ADMINISTRATIVO   ||***********
 *          ***********************************************************
 * 
 *          @date               2019-11-15
 *          @author             Bayman Burton <bayman@burtonservers.com>
 *          @copyright          2019-2020 Burton Technology https://burtonservers.com
 *          @license            https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License (GPL v3)
 *          International Registered Trademark & Property of Burton Technology  https://burtonservers.com
 * 
 *          This source file is subject to the GNU General Public License (GPL v3)
 *          that is bundled with this package in the file LICENSE.txt.
 *          It is also available through the world-wide-web at this URL:
 *          https://www.gnu.org/licenses/gpl-3.0.en.html
 *          If you did not receive a copy of the license and are unable to
 *          obtain it through the world-wide-web, please send an email
 *          to dev@burtonservers.com so we can send you a copy immediately.
 *          This software is built and distributed by Burton Technology https://burtonservers.com
 *          By using this software you are Aware it is strictly prohibited its comercial distribution or 
 *          modification of any aspect of the aplication
 *
 *          Desc:
 *          Custom admin dashboard for descomplicate apps published on the market.
 * 
 *          WARNING
 *          Please do not edit this file or the aplication could stop working as intended, also
 *          any modifications will be overwritten by newer versions in the future
 *          
 */

//  DEBUG EN PANTALLA   //
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//  HABILITAMOS EL ACCESO PUBLICO PARA REALIZAR LLAMADAS AJAX DESDE DOMINIOS PUBLICOS   /
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');
header('Content-type: application/javascript; charset=utf-8');

//   RESCATAMOS TODO EL OUTPUT  //
/**  PARA IMPRIMIRLO EN JSON
 * $output = ob_get_contents(); ob_end_clean();
 */
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/plugins/PHPMailer/src/Exception.php';
require 'assets/plugins/PHPMailer/src/PHPMailer.php';
require 'assets/plugins/PHPMailer/src/SMTP.php';

require 'assets/scripts/utils.php';
require 'assets/scripts/conn.php';

$json = array();

if ($_POST || $_GET) {
    if ($_POST['meth']) {
        $method = broom('reg', $_POST['meth']);
    } else {
        $method = broom('reg', $_GET['meth']);
    }

    //          USUARIO INICIA SESION           //
    if ($method == 'login') {

        $username = broom('reg', $_POST["username"]);
        $password = hash('sha512', $_POST['password']);
        $apiuri = $_POST['apiuri'];

        ////            CONSULTAMOS EL USUARIO EN LA BASE DE DATOS A VER SI EXISTE              ////
        $query = " SELECT * "
            . "FROM tb_usuario "
            . "WHERE userUsuario = '" . $username . "'";
        $result = $c->query($query);
        if (!$result) {
            $json['scriptResp'] = "userqueryFail";
            $json['q'] = $query;
            $output = ob_get_contents();
            ob_end_clean();
            $json['output'] = $output;
            echo json_encode($json);
            return;
        }
        $rows = $result->num_rows;
        $row = $result->fetch_array(MYSQLI_ASSOC);

        ////          RETORNAMOS UN JSON AL AJAX PARA ALIMENTAR EL JAVASCRIPT          ////

        if (($rows != 0) && (strcmp($row["userUsuario"], $username) == 0) && ($row['passUsuario'] == $password)) {

            //   VERIFICAMOS SI TIENE IMAGEN CARGADA || CARGAMOS IMAGEN PREDETERMINADA        //
            $isavatar = "assets/img/users/" . $row["idUsuario"] . ".jpg";
            if (file_exists($isavatar)) {
                $row['userImg'] = $apiuri . $isavatar;
            } else {
                $isavatar2 = "assets/img/users/" . $row["idUsuario"] . ".png";
                if (file_exists($isavatar2)) {
                    $row['userImg'] = $apiuri . $isavatar2;
                } else {
                    $row['userImg'] = $apiuri . "assets/img/users/default.jpg";
                }
            }
            $row['panelView'] = file_get_contents('modules/' . $row["panelUsuario"] . '/view.php');
            $row['login'] = "YES";

            $val_update = "UPDATE tb_usuario SET loginUsuario = '" . date('Y-m-d H:i:s') . "' WHERE idUsuario = '" . $row["idUsuario"] . "';";
            $val_result = $c->query($val_update) or die("{'scriptResp' : 'queryFailedd', 'query' : '" . $val_update . "'}");

            $json['userIntel'] = $row;
            $json['scriptResp'] = "match";
            $output = ob_get_contents();
            ob_end_clean();
            $json['output'] = $output;
            echo json_encode($json);
            return;
        } else {
            $json['scriptResp'] = "noMatch";
            $json['passwo'] = $password;
            $json['password'] = $row['passUsuario'];
            $json['q'] = $query;
            $output = ob_get_contents();
            ob_end_clean();
            $json['output'] = $output;
            echo json_encode($json);
            return;
        }
    }

    //          USUARIO INICIA SESION  CON GOOGLE         //
    if ($method == 'googlelogin') {

        $fullname = broom('reg', $_POST["fullname"]);
        $pic = $_POST['pic'];
        $email = $_POST['email'];

        $row = [];
        $row['idUsuario'] = $email;
        $row['rolUsuario'] = 'Administrador';
        $row['userImg'] = $pic;
        $row['nombreUsuario'] = $fullname;
        $row['temaUsuario'] = '1';
        $row['panelUsuario'] = 'home';

        $row['panelView'] = file_get_contents('modules/' . $row["panelUsuario"] . '/view.php');
        $row['login'] = "YES";

        $json['userIntel'] = $row;
        $json['scriptResp'] = "match";
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          GESTIONAR EL PANEL A MOSTRAR            //
    if ($method == 'loadPanel') {
        $panel = broom('reg', $_POST["panel"]);
        $user = broom('reg', $_POST["user"]);

        if ($panel == 'undefined') {
            $panelView = file_get_contents('assets/views/login.php');
            $json['scriptResp'] = "loaded";
            $json['panel'] = $panelView;
            $json['panelName'] = 'login';
            $output = ob_get_contents();
            ob_end_clean();
            $json['output'] = $output;
            echo json_encode($json);
            return;
        }

        $panelView = file_get_contents('modules/' . $panel . '/view.php');
        $panelcontrol = file_get_contents('modules/' . $panel . '/controller.php');
        //        $select = "UPDATE tb_usuario SET panelUsuario = '" . $panel . "' WHERE idUsuario = '" . $user . "'";
        //        $result = $c->query($select);

        $json['scriptResp'] = "loaded";
        $json['panel'] = $panelView;
        $json['control'] = $panelcontrol;
        $json['panelName'] = $panel;
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          RETORNAR EL MENU LATERAL AUTORIZADO PARA EL USUARIO            //
    if ($method == 'showSideBar') {
        $user = $_POST["user"];

        if ($user == 'undefined') {
            $json['scriptResp'] = "error";
            $json['output'] = $output;
            echo json_encode($json);
            return;
        }

        $isGoog = explode('@', $user);
        if ($isGoog[1]) {
            $viewSidebar = file_get_contents('assets/views/sidebarAdmin.php');
            $json['scriptResp'] = "loaded";
            $json['sideb'] = $viewSidebar;
            $output = ob_get_contents();
            ob_end_clean();
            $json['output'] = $output;
            echo json_encode($json);
            return;
        }
        $select = "SELECT *  FROM tb_usuario  WHERE idUsuario = '" . $user . "'";
        $result = $c->query($select);
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if ($row['temaUsuario'] == '1') {
            $viewSidebar = file_get_contents('assets/views/sidebarAdmin.php');
        }
        if ($row['temaUsuario'] == '2') {
            $viewSidebar = file_get_contents('assets/views/sidebarNot.php');
        }

        $json['scriptResp'] = "loaded";
        $json['sideb'] = $viewSidebar;
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          GESTIONAR EL PANEL A MOSTRAR            //
    if ($method == 'construct') {

        $getJuice = file_get_contents('assets/scripts/juice.php');
        $video = getBGVideo();

        $json['scriptResp'] = "done";
        $json['view'] = $panelView;
        $json['video'] = $video;
        $json['juice'] = $getJuice;
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          ALIMENTAR LOS INDICADORES            //
    if ($method == 'feedHome') {

        // TOTAL REGISTRADOS DESDE LANZAMINEOT //
        $query = "SELECT * FROM public.user WHERE created_at >= '2019-11-11' and is_provider = 'f'";
        $result = pg_query($dbconn, $query);
        $treg = pg_fetch_all($result);

        // DOCTORES CREADOS EN LA PLATAFORMA //
        $query = "SELECT * FROM public.user WHERE created_at >= '2019-11-11' and is_provider = 't'";
        $result = pg_query($dbconn, $query);
        $tdocn = pg_fetch_all($result);

        // DOCTORES ACTIVOS EN LA PLATAFORMA //
        $query = "SELECT * FROM public.user WHERE updated_at >= '2019-11-11' and is_provider = 't'";
        $result = pg_query($dbconn, $query);
        $tdoc = pg_fetch_all($result);

        // TOTAL DE PEDIDOS REALZIADOS EN LA PLATAFORMA //
        $query = "SELECT * FROM public.des_service_doctor_historical WHERE (created_at >= '2019-11-11') AND (symptom NOT ILIKE '%prueba%' OR symptom IS NULL)";
        $result = pg_query($dbconn, $query);
        $tped = pg_fetch_all($result);

        // TOTAL DE PEDIDOS ATENDIDOS //
        $query = "SELECT * FROM public.des_service_doctor_historical WHERE (created_at >= '2019-11-11' AND provider_arrived = 't')  AND (symptom NOT ILIKE '%prueba%' OR symptom IS NULL)";
        $result = pg_query($dbconn, $query);
        $tpeda = pg_fetch_all($result);

        // TOTAL DE PEDIDOS ABANDONADOS //
        $query = "SELECT * FROM public.des_service_doctor_historical WHERE (created_at >= '2019-11-11' AND provider_arrived != 't' OR provider_arrived IS NULL) AND (symptom NOT ILIKE '%Prueba%' OR symptom IS NULL)";
        $result = pg_query($dbconn, $query);
        $tpedab = pg_fetch_all($result);

        // TOP de SINTOMAS DE PEDIDOS //
        $query = "SELECT symptom,count(symptom) total FROM public.des_service_doctor_historical WHERE created_at >= '2019-11-11' AND symptom NOT ILIKE '%Prueba%' GROUP BY symptom ORDER BY total DESC";
        $result = pg_query($dbconn, $query);
        $tsym = pg_fetch_all($result);

        $json['scriptResp'] = "done";
        $json['treg'] = $treg;
        $json['tdoc'] = $tdoc;
        $json['tdocn'] = $tdocn;
        $json['tped'] = $tped;
        $json['tpeda'] = $tpeda;
        $json['tpedab'] = $tpedab;
        $json['tsym'] = $tsym;
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          ALIMENTAR LOS DOCTORES            //
    if ($method == 'feedDoct') {
        $apiuri = $_POST['apiuri'];

        // DOCTORES ACTIVOS EN LA PLATAFORMA //
        $query = "SELECT * FROM public.user WHERE updated_at >= '2019-11-11' and is_provider = 't' ORDER BY updated_at DESC";
        $result = pg_query($dbconn, $query);
        $tdoc = pg_fetch_all($result);

        $htmlDocs = '<div class="row doctorsFetchedList">';
        foreach ($tdoc as $doctor) {
            //   VERIFICAMOS SI TIENE IMAGEN CARGADA || CARGAMOS IMAGEN PREDETERMINADA        //
            $isavatar = "assets/img/doc/" . $doctor['identification_card'] . ".JPG";
            if (file_exists($isavatar)) {
                $avatar = $apiuri . 'assets/img/doc/' . $doctor['identification_card'] . '.JPG';
            } else {
                $avatar =  $apiuri . "assets/img/doctor.jpg";
            }
            $htmlDocs .= ' 
				<div class="col-md-4 anim">
                    <div class="card user-wideget user-wideget-widget widget-user">
                        <div class="widget-user-header bg-cyan">
                            <h5 class="">' . $doctor['first_name'] . ' ' . $doctor['last_name'] . '</h5>
                            <h5 class="widget-user-desc">' . $doctor['email'] . '</h5>
                        </div>
                        <div class="widget-user-image">
                            <img src="' . $avatar . '" class=" drImg" alt="User Avatar">
                        </div>
                        <div class="user-wideget-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">' . $doctor['identification_card'] . '</h5>
                                        <span class="description-text">ID</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header thisDoctLastCon">' . substr($doctor['updated_at'], 0, 10) . '</h5>
                                        <span class="description-text">Ult. Conex.</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">' . $doctor['cell_phone_number'] . '</h5>
                                        <span class="description-text">Telefono</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        $htmlDocs .= '</div>';

        $json['scriptResp'] = "done";
        $json['tdoc'] = $tdoc;
        $json['html'] = $htmlDocs;
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          ALIMENTAR LOS PEDIDOS            //
    if ($method == 'feedPed') {
        $apiuri = $_POST['apiuri'];

        // TOTAL DE PEDIDOS REALZIADOS EN LA PLATAFORMA //
        $query = "  SELECT us.first_name nomb, us.last_name apel, us.cell_phone_number cel, dsdh.email_client email, dsdh.provider_arrived 
                        arri, dsdh.created_at creado, dsdh.forma_pago forma, latitude_client lat, longitude_client long, address_client addr, 
                        address_reference refe, symptom symp, score sco, us.identification_card cedu, usi.first_name nombdoc, usi.last_name 
                        apeldoc, dsdh.email_provider emaildoc
                    FROM public.des_service_doctor_historical dsdh 
                    LEFT JOIN \"user\" us ON (dsdh.email_client = us.email) 
                    LEFT JOIN \"user\" usi ON (dsdh.email_provider = usi.email) 
                    WHERE (dsdh.created_at >= '2019-11-11') AND (symptom NOT ILIKE '%prueba%' OR symptom IS NULL)
                    ORDER BY servdoctorhis_id DESC";
        $result = pg_query($dbconn, $query);
        $tped = pg_fetch_all($result);

        $htmlPeds = '';
        foreach ($tped as $pedido) {
            if ($pedido['arri'] == 't') {
                $resp = 'Atendido <i class="fa fa-smile-o fa-2x"></i>';
            } else {
                $resp = 'Sin Atender <i class="fa fa-frown-o fa-2x"></i>';
            }
            $htmlPeds .= ' 
                            <tr>
                                <td>' . $pedido['nomb'] . ' ' . $pedido['apel'] . '</td> 
                                <td>' . $pedido['cel'] . '</td>
                                <td>' . $resp . '</td>
                                <td>' . substr($pedido['creado'], 0, 10) . '</td>
                                <td>' . substr($pedido['creado'], 11, 8) . '</td>
                                <td>' . $pedido['forma'] . '</td>
                                <td>
                                    <a  class="text-white btn btn-primary verDetallesPedido" >
                                        <i class="fa fa-share-square-o vericon"></i><span>Ver</span>
                                        <div class="offscreen detNomb">' . $pedido['nomb'] . '</div>
                                        <div class="offscreen detApel">' . $pedido['apel'] . '</div>
                                        <div class="offscreen detCel">' . $pedido['cel'] . '</div>
                                        <div class="offscreen detEmail">' . $pedido['email'] . '</div>
                                        <div class="offscreen detArri">' . $resp . '</div>
                                        <div class="offscreen detCreado">' . $pedido['creado'] . '</div>
                                        <div class="offscreen detForma">' . $pedido['forma'] . '</div>
                                        <div class="offscreen detLat">' . $pedido['lat'] . '</div>
                                        <div class="offscreen detLong">' . $pedido['long'] . '</div>
                                        <div class="offscreen detAddr">' . $pedido['addr'] . '</div>
                                        <div class="offscreen detRefe">' . $pedido['refe'] . '</div>
                                        <div class="offscreen detSymp">' . $pedido['symp'] . '</div>
                                        <div class="offscreen detSco">' . $pedido['sco'] . '</div>
                                        <div class="offscreen detCedu">' . $pedido['cedu'] . '</div>
                                        <div class="offscreen detNombDoc">' . $pedido['nombdoc'] . '</div>
                                        <div class="offscreen detApelDoc">' . $pedido['apeldoc'] . '</div>
                                        <div class="offscreen detEmailDoc">' . $pedido['emaildoc'] . '</div>
                                    </a>
                                </td>
                            </tr>
            ';
        }

        $json['scriptResp'] = "done";
        $json['tped'] = $tped;
        $json['html'] = $htmlPeds;
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }

    //          DEBUG           //
    if ($method == 'debug') {
        $output = ob_get_contents();
        $json['descomplicate'] = hash('sha512', 'descomplicate');;
        $json['output'] = $output;
        ob_end_clean();
        echo json_encode($json);
        return;
    }

    //          REPORT           //
    if ($method == 'report') {
        $apiuri = $_POST['apiuri'];

        // DOCTORES ACTIVOS EN LA PLATAFORMA //
        $query = "SELECT * FROM public.user WHERE created_at >= '2019-11-11' and is_provider = 'f'";
        $result = pg_query($dbconn, $query);
        $treg = pg_fetch_all($result);
        $num_fields = count($treg);

        $headers = array('Nombre', 'Apellido', 'Email', 'Creado en', 'Telefono');

        $fp = fopen('php://output', 'w');
        if ($fp && $result) {
            fputcsv($fp, $headers, ';');
            foreach ($treg as $userReg) {
                $row = [];
                $row[] = $userReg['first_name'];
                $row[] = $userReg['last_name'];
                $row[] = $userReg['email'];
                $row[] = $userReg['created_at'];
                $row[] = $userReg['cell_phone_number'];
                fputcsv($fp, $row, ';');
            }
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=usuariosregistrados" . date('Ymd-His') . ".csv");
            return;
        }

        $json['scriptResp'] = "done";
        $json['tdoc'] = count($treg);
        $output = ob_get_contents();
        ob_end_clean();
        $json['output'] = $output;
        echo json_encode($json);
        return;
    }
}

//   Si no se llamó ningún método de la API     //
$json['post'] = json_encode($_POST);
$json['get'] = json_encode($_GET);
$json['files'] = json_encode($_FILES);
$json['msg'] = "Mute API";
$json['output'] = $output;
ob_end_clean();
echo json_encode($json);
return;
