<?php

if (true)   //(isset($_POST['token'])) 
{
    /* Obtengo las variables del formulario de soporte, almaceno el pedido, muestro el resultado y envío correo */

    /*Activo errores
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/
    

    // Para generar PDF
    require('fpdm.php');

    // Conexión con la bbdd - cambiar a producción cuando esté listo
    include_once 'class.Database.inc.php';

    // Recibimos y decodificamos la cadena json
    $data = json_decode(file_get_contents('php://input'), true);

    if (  $data["totales"]["pedido"]["total"] != 0)
    {
        
        $con = new Database;

        $query = "INSERT INTO `wvisionwin`.`pedidosvisionwin` (`usuariosgestion`, `usuarioscontabilidad`, `idsoportegestionlocal`, " .
            "`idsoportecontabilidadlocal`, `idsoportegestionnube`, `idsoportecontabilidadnube`, `periodicidad`, `bruto`, " .
            "`descuento`, `base`, `ivapor`, `ivaimp`, `recargo`, `total`, `cuponnombre`, `exento`, `nombre`, `direccion`, " .
            "`cp`, `poblacion`, `nif`, `telefono`, `email`, `formapago`, `iban`, `pagado`, `facturado`, `copias`) " .
            "VALUES (";

        // Inicializo algunos valores que pueden crear confusión
        if ($data["totales"]["soporte"]["gestionnube"]==0) {
            $data["totales"]["usuariosnube"]["gestion"]=0;
        }

        if ($data["totales"]["soporte"]["contabilidadnube"]==0){
            $data["totales"]["usuariosnube"]["contabilidad"]=0;
        }

        $query .= "'" . $data["totales"]["usuariosnube"]["gestion"] . "',";
        $query .= "'" . $data["totales"]["usuariosnube"]["contabilidad"] . "',";
        $query .= "'" . $data["totales"]["soporte"]["gestionlocal"] . "',";
        $query .= "'" . $data["totales"]["soporte"]["contabilidadlocal"] . "',";
        $query .= "'" . $data["totales"]["soporte"]["gestionnube"] . "',";
        $query .= "'" . $data["totales"]["soporte"]["contabilidadnube"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["periodicidad"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["bruto"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["descuento"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["base"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["ivapor"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["ivaimp"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["recargo"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["total"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["cuponnombre"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["exento"] . "',";
        $query .= "'" . sanear_string ($data["nombre"]) . "',";
        $query .= "'" . sanear_string ($data["direccion"]) . "',";
        $query .= "'" . sanear_string ($data["cp"]) . "',";
        $query .= "'" . sanear_string ($data["poblacion"]) . "',";
        $query .= "'" . sanear_string ($data["nif"]) . "',";
        $query .= "'" . sanear_string ($data["telefono"]) . "',";
        $query .= "'" . $data["email"] . "',";
        $query .= "'" . $data["totales"]["pedido"]["formapago"] . "',";
        $query .= "'" . $data["IBAN"] . "',";
        $query .= "'N','N',";
        $query .= "'" . $data["totales"]["soporte"]["copias"] . "' )";

        $con->ejecutar_idu($query);

        // Obtiene el número del registro añadido
        $row = $con->get_Row("SELECT @@identity AS numero");
        $ultimo = $row['numero'];

        // Recojo los datos del pedido ya grabado
        $row = $con->get_Row("SELECT numero,fecha,usuariosgestion,usuarioscontabilidad,idsoportegestionlocal,idsoportecontabilidadlocal," .
            "idsoportegestionnube,idsoportecontabilidadnube,periodicidad,total,descuento,recargo,formapago,exento,copias FROM pedidosvisionwin where numero='" . $ultimo . "'");

        $soportes = [
            1 => "Actualizaciones",
            2 => "Soporte Básico",
            3 => "Soporte Profesional"
        ];

        // Pirula para convertir la cadena de fecha a un objeto datetime que se pueda manipular
        $fecha = strtotime($row['fecha']);

        // Monto la cadena que se muestra por pantalla y que se envía por email
        $cadena  = 'Identificador del pedido : <b>' . sprintf("%' 6d\n", $row['numero']) . '</b><br>';
        $cadena .= 'Fecha : ' . date('d/m/Y', $fecha) . '<br>';
        $cadena .= '<hr>';
        $cadena .= '<b>Datos de facturación</b><br/>';
        $cadena .= 'Nombre : ' . $data["nombre"] . '<br/>';
        $cadena .= 'Direccion : ' . $data["direccion"] . '<br/>';
        $cadena .= 'CP - Poblacion : ' . $data["cp"] . ' ' . $data["poblacion"] . '<br/>';
        $cadena .= 'NIF : ' . $data["nif"] . '<br/>';
        $cadena .= 'Tel : ' . $data["telefono"] . '<br/>';
        $cadena .= 'email : ' . $data["email"] . '<br/>';

        $cadena .= '<hr>';
        $cadena .= '<b>Soportes contratados</b><br/>';

        if ($row['idsoportegestionlocal'] != 0) {
            $cadena .= '1 x Visionwin Gestión (instalación local): ' . $soportes[$row['idsoportegestionlocal']] . '<br/>';
        }

        if ($row['idsoportecontabilidadlocal'] != 0) {
            $cadena .= '1 x Visionwin Contabilidad (instalación local): ' . $soportes[$row['idsoportecontabilidadlocal']] . '<br/>';
        }

        if ($row['copias'] != 0) {
            $cadena .= 'Copias en servidor seguro ';
        }
      
        if ($row['idsoportegestionnube'] != 0) {
            $cadena .= '1 x Visionwin Gestión (en la nube): ' . $soportes[$row['idsoportegestionnube']] . '<br/>';
            $cadena .= '- Usuarios : <b>' . $row['usuariosgestion'] . '</b><br/>';
            $cadena .= '- Periodicidad : <b>';
            if ($row['periodicidad'] == 1) {
                $cadena .= 'ANUAL';
            } else {
                $cadena .= 'MENSUAL';
            }
            $cadena .= '</b><br/>';
        }

        if ($row['idsoportecontabilidadnube'] != 0) {
            $cadena .= '1 x Visionwin Contabilidad (en la nube): ' . $soportes[$row['idsoportecontabilidadnube']] . '<br/>';
            $cadena .= '- Usuarios : <b>' . $row['usuarioscontabilidad'] . '</b><br/>';
            $cadena .= '- Periodicidad : <b>'; 
            if ($row['periodicidad'] == 1) {
                $cadena .= 'ANUAL';
            } else {
                $cadena .= 'MENSUAL';
            }
            $cadena .= '</b><br/>';
        }
        $cadena .= '<hr>';
        $cadena .= 'Total Pedido : <b>' . $row['total'] . '</b><br>';

        if ($row['descuento'] != 0) {
            $cadena .= 'Descuentos aplicados : ' . $row['descuento'] . '€<br>';
        }

        if ($row['recargo'] != 0) {
            $cadena .= 'Recargos por paypal : ' . $row['recargo'] . '€<br>';
        }

        if ($row['exento'] == "si") {
            $cadena .= '<b>EXENTO DE IVA</b><br/>';
        }

        $cadena .= 'Forma de Pago : ' . $row['formapago'] . '<br>';

        if ($row['formapago'] == 'recibo') {
            $cadena .= '<br>IBAN : ' . $data['IBAN'] . '<br/>';
        }

        if ($row['formapago'] == 'transferencia') {
            $cadena .= '<br>Cuenta : La Caixa - ES30 2100 2312 7102 0020 0799<br/>';
        }

        echo $cadena;

        // Genero el PDF cuando la forma de pago es recibo
        if ($row['formapago'] == 'recibo') {
            $campos = array(
                'referencia'    => $row['numero'],
                'nombre' => $data["nombre"],
                'iban' => $data["IBAN"],
                'titular' => $data["nombre"],
                'direccion' => $data["direccion"],
                'cp' => $data["cp"], 
                'poblacion' => $data["poblacion"],
                'fecha' => date('d/m/Y', $fecha)
            );

            $nombrefichero = "sepa" . $row['numero'] . ".pdf";

            $pdf = new FPDM('plantillasepa.pdf');
            $pdf->Load($campos, true); // true = UTF8
            $pdf->Merge();
            $pdf->Output("F", 'tmp/' . $nombrefichero, true);
        }

        // Envío del correo electrónico
        $para  = 'info@visionwin.com';

        // título
        $titulo = 'Software Visionwin - Nuevo Pedido Recibido';

        // mensaje
        $mensaje = '
                    <!DOCTYPE html>
                    <html lang="es">
                        <head>
                            <meta charset="utf-8">
                            <title>Software Visionwin - Pedido</title>
                        </head>
                        <body>' . $cadena . '
                        </body>
                    </html>';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";

        // Enviarlo
        mail($para, $titulo, $mensaje, $cabeceras);

        // ------------- Envío al cliente --------------------------
        $para  = $data["email"];

        // titulo
        $titulo = 'Software Visionwin - Pedido';

        // mensaje
        $mensaje = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="es">
        <head>
            <meta charset="utf-8">
                <title>Software Visionwin - Pedido</title>
                <style>
                    .texto {
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                    }
                
                    .fondo {
                        background-color: #F5F5F5;
                    }
                
                    .mensaje {
                        background-color: white;
                        padding: 20px;
                        border: 1px solid;
                        border-color: lightslategray;
                        border-radius: 5px;
                        margin: 0 5% 0 5%;
                        text-align: left;
                    }
                
                    .separa {
                        padding-bottom: 25px;
                    }
                </style>
            </head>
                
            <body>
                <div class="fondo texto">
                    <div class="separa"></div>
                    <div class="mensaje">
                        <h2>&iexcl;Pedido recibido!</h2>
                            <p>Gracias por tu compra, hemos recibido correctamente tu pedido. En cuanto est&eacute;
                                confirmado
                                el pago del mismo te mandaremos la factura correspondiente y tu c&oacute;digo de cliente que te
                                permitir&aacute; registrar el programa y acceder a nuestro servicio de soporte.</p>
                            <p>
                                Este es el resumen de tu pedido : 
                            </p>
                
                            <p>
                                <!-- cadena del pedido -->
                                ' . iconv("UTF-8", "CP1252", $cadena) . '
                                <br/>
                                ';
    if ($row['formapago'] == 'recibo') {                            
        $mensaje.= '<b>Por favor, recuerda devolvernos firmada la solicitud de domiciliación de recibos en formato SEPA que se adjunta en este correo.</b><br/>';
    }

    if ($row['formapago'] == 'transferencia') {                            
        $mensaje.= '<b>Recuerda que puedes enviarnos copia de la transferencia a info@visionwin.com para agilizar el proceso de compra.</b><br/>';
    }

    $mensaje.= '
                            </p>

                            <p>
                                <br/>
                                <br/>
                            </p>


                            <!-- Firma -->
                            <hr style="border-top: 1px dashed lightgray;" />
                            <table style="width: 314px;">
                                <tbody>
                                    <tr style="height: 97px;">
                                        <td style="width: 107px; height: 97px;">
                                            <p><img style="display: block; margin-left: auto; margin-right: auto; border-radius: 95%;"
                                                    src="http://www.visionwin.com/correos/sonia_ok.jpg" alt="" width="100"
                                                    height="100" />
                                            </p>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-left: 2px; padding-right: 2px;"><a
                                                                href="https://www.facebook.com/visionwin"><img
                                                                    src="http://www.visionwin.com/correos/facebook_gris.png" alt=""
                                                                    width="28" height="28" /></a></td>
                                                        <td style="padding-left: 2px; padding-right: 2px;"><a
                                                                href="https://twitter.com/visionwin"><img
                                                                    src="http://www.visionwin.com/correos/twitter_gris.png" alt=""
                                                                    width="28" height="28" /></a></td>
                                                        <td style="padding-left: 2px; padding-right: 2px;"><a
                                                                href="https://www.youtube.com/visionwinsoftware"><img
                                                                    src="http://www.visionwin.com/correos/youtube_gris.png" alt=""
                                                                    width="28" height="28" /></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width: 205px; height: 97px;">
                                            <p style="font-size: 11pt; color: #000000;">Sonia<br /><span
                                                    style="color: #808080; font-size: 10pt;">Tu asistente virtual</span></p>
                                            <a href="https://www.visionwin.com"><img
                                                    src="http://www.visionwin.com/correos/mailing/visionwin.png" alt="" width="128"
                                                    height="34" /></a><br />
                                            <p style="color: #777777; font-size: 9pt;"><a
                                                    style="color: #777777; text-decoration: none;"
                                                    href="mailto:info@visionwin.com">info@visionwin.com</a><br />Telf. 964455551</p>
                                            <p style="color: #999999; font-size: 8pt;">Edificio Vinalab, C/ Galicia,
                                                12<br />12500-Vinar&ograve;s (Castell&oacute;n) Spain</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="font-size: 7pt; color: #999999; width: 100%;" align="justify">De conformidad con el reglamento
                                europeo
                                en materia de protecci&oacute;n de datos 2016/679 del parlamento europeo y del consejo del 27 de
                                abril
                                del
                                2016 relativo a la protecci&oacute;n de datos de las personas f&iacute;sicas (RGPD), le informamos
                                que
                                los
                                datos recibidos por cualquiera de los medios y/o canales de contacto previstos en el sitio
                                web&nbsp;<a style="color: #999999;" href="http://www.visionwin.com/" target="_blank"
                                    rel="noopener">www.visionwin.com</a>&nbsp;son objeto de tratamiento por parte de Visionwin Software 
                                    S.L&nbsp; (en adelante, Visionwin). Visionwin se exonera de toda responsabilidad por el incumplimiento
                                de las obligaciones derivadas del RGPD o de la normativa correspondiente en materia de protecci&oacute;n de
                                datos
                                por parte del usuario y/o cliente en lo que a su actividad le corresponda y que se encuentre
                                relacionado
                                con
                                la ejecuci&oacute;n del contrato o relaciones comerciales que le unan a SI Inform&aacute;tica. Estos
                                datos
                                son tratados &uacute;nicamente con la finalidad de realizar las gestiones que en el mismo se
                                especifiquen y
                                en virtud de la relaci&oacute;n que nos une. Si usted desea ejercitar sus derechos de acceso,
                                rectificaci&oacute;n, supresi&oacute;n, limitaci&oacute;n o portabilidad, puede enviarnos un email
                                a&nbsp;<a style="color: #999999;" href="mailto:info@visionwin.com" target="_blank"
                                    rel="noopener">info@visionwin.com</a>. M&aacute;s informaci&oacute;n sobre protecci&oacute;n de
                                datos en
                                nuestra p&aacute;gina web&nbsp;<a style="color: #999999;"
                                    href="http://www.visionwin.com/web/politica-de-privacidad" target="_blank"
                                    rel="noopener">http://www.visionwin.com/web/politica-de-privacidad</a>&nbsp;o contactando
                                directamente
                                con nosotros.</p>
                    </div>
                    <div class="separa"></div>
                </div>    
        </body>
        </html>    
    ';



        // Enviarlo
        //cabecera del email 
        $cabeceras = "MIME-Version: 1.0\r\n";
        //$cabeceras .= 'To: <' . $data["email"] . '>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";


        // Si hay recibo adjunto mandato sepa para rellenar
        if ($row['formapago'] == 'recibo') {

            $archivoNombre = $nombrefichero; //nombre del archivo a ser enviado (sin la ruta, solo el nombre con la extensión, por ejemplo: imagen.jpg)
            $archivo = "/var/www/vhosts/visionwin.com/httpdocs/php/tmp/".$nombrefichero; //ruta temporal del archivo a ser adjuntado (ubicación fisica del archivo subido en el servidor)
            $archivo = file_get_contents($archivo); //leeo del origen temporal el archivo y lo guardo como un string en la misma variable (piso la variable $archivo que antes contenía la ruta con el string del archivo)
            $archivo = chunk_split(base64_encode($archivo)); //codifico el string leido del archivo en base64 y la fragmento segun RFC 2045
            $uid = md5(uniqid(time())); //frabrico un ID único que usaré para el "boundary"

            $cabeceras .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";

            //armado del mensaje y attachment
            $msg = "--" . $uid . "\r\n";
            $msg .= "Content-type:text/html; charset=utf-8\r\n";
            $msg .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $msg .= $mensaje . "\r\n\r\n";
            $msg .= "--" . $uid . "\r\n";
            $msg .= "Content-Type: application/octet-stream; name=\"" . $archivoNombre . "\"\r\n";
            $msg .= "Content-Transfer-Encoding: base64\r\n";
            $msg .= "Content-Disposition: attachment; filename=\"" . $archivoNombre . "\"\r\n\r\n";
            $msg .= $archivo . "\r\n\r\n";
            $msg .= "--" . $uid . "--";

            mail($para, $titulo, $msg, $cabeceras);

            // Elimino el fichero
            unlink ("/var/www/vhosts/visionwin.com/httpdocs/php/tmp/".$nombrefichero);

        } else {
            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
            $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            mail($para, $titulo, $mensaje, $cabeceras);
        }

        //Refresco el panel del crm
        $url = 'https://crm.visionwin.com/backend/api/panel/info';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close ($ch); 
    } else{
        echo '<h1>El pedido no se ha almacenado correctamente, vuelve a intentarlo</h1>';
    }
}

    function sanear_string($string) {
        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", ),
        '',
        $string
    );


    return $string;
}

?>


