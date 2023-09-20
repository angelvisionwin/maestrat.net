<?php   

    $email         = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $idsugerencia  = filter_input(INPUT_POST, 'idsugerencia', FILTER_SANITIZE_NUMBER_INT);
    $votos         = filter_input(INPUT_POST, 'idvotos', FILTER_SANITIZE_NUMBER_INT);

    include_once 'class.Database.inc.php';
    $con = new Database;       

    // Primero compruebo si existe
    $query= "SELECT  `id`,`votos` FROM `wvisionwin`.`form_sugerencias_votos` WHERE id_sugerencia=".$idsugerencia." AND email='".$email."'";
    $row = $con->get_Row($query);
  
    if ($row['id']!=NULL) {
        echo 'Ya se ha registrado un voto en esta sugerencia con su correo.';
    } else {
      
      if ($email!=""){
        
/*         // Añado un registro de voto
        $query="INSERT INTO `wvisionwin`.`form_sugerencias_votos` (`email`, `id_sugerencia`,`votos` ) VALUES ('";
        $query.=$email."','";
        $query.=$idsugerencia."','1')";
        $con->ejecutar_idu ($query);

        // Actualizo el contador de votos de sugerencias
        $votos=$votos+1;
        $query="UPDATE `wvisionwin`.`form_sugerencias` SET `votos`='".$votos."' WHERE  `id`=".$idsugerencia;
        $con->ejecutar_idu ($query);

        echo "Muchas gracias, se ha registrado el voto correctamente.";
         */

        // Añado voto al temporal de votos, se enviará un email para que el CRM lo gestione

        $token = generar_token_seguro (32);

        $query = "INSERT INTO `wvisionwin`.`form_sugerencias_votos_temporal` (`token`, `email`,`id_sugerencia`,`votos` ) VALUES (" ;
        $query.= "'" . $token . "'," ;
        $query.= "'" . $email . "'," ;
        $query.= "'" . $idsugerencia . "'," ;
        $query.= "'1')";

        $con->ejecutar_idu ($query);

        // ------------- Envío al cliente --------------------------
        $para  = $email;

        // titulo
        $titulo = 'Software Visionwin - Confirmación de voto';

        // mensaje
        $mensaje = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="es">
        <head>
            <meta charset="utf-8">
                <title>Software Visionwin - Confirmación de voto</title>
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
                        <h2>&iexcl;Petición de voto recibida!</h2>
                            <p>Gracias por tu votación en nuestro sistema de sugerencias, sólo debes pinchar en el enlace que te mostramos a continuación para confirmar tu voto. </p>
                            <p>
                                <a href =  "https://crm.visionwin.com/backend/api/formularios/sugerencias/validavoto?email='. $email . '&token='. $token . '">
                                <h3> Confirmar voto </h3>
                                </a>
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

        //$cabeceras .= 'To: ' . $email . ' <' . $email . '>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        mail($para, $titulo, $mensaje, $cabeceras);

        echo 'Te hemos enviado un enlace a tu correo para que puedas confirmar la votación, muchas gracias.';
    
      } else {
          echo 'Es necesario registrar un email para emitir un voto';
      }
    }

    function generar_token_seguro($longitud)
    {
        if ($longitud < 4) {
            $longitud = 4;
        }
     
        return bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2));
    }
  
?>
