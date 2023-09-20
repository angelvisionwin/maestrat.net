<?php   

if (isset($_POST['g-recaptcha-response'])) 
{
   
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $captcha_response = true;
    $recaptcha = $_POST['g-recaptcha-response'];
 
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6Ldip90cAAAAANwrmjgSks8L7oqjS8XaYZ_H1BDs',
        'response' => $recaptcha
    );
    $options = array(
        'http' => array (
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);
    $captcha_response = $captcha_success->success;
 
    if ($captcha_response) {

        echo '<div class="alert alert-light alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'Gracias <strong>'.$nombre.'</strong>, hemos enviado un correo electrónico a la dirección indicada.<br>';
        echo '<br>';
        echo '</div>';


        // Envío del correo electrónico
        // Varios destinatarios
        $para  = 'info@visionwin.com';

        // título
        $título = 'Software Visionwin - Formulario de Distribución';

        // mensaje
        $mensaje = '
                    <!DOCTYPE html>
                    <html lang="es">
                        <head>
                            <meta charset="utf-8">
                            <title>Software Visionwin - Formulario de Distribución</title>
                        </head>
                        <body>
                        Nombre : '.$nombre.'<br/>
                        Email : '.$email.'<br/>
                        <br />
                        <b>Ya se ha enviado la información al interesado</b>
                        </body>
                    </html>';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'To: Visionwin <info@visionwin.com>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";

        // Enviarlo
        mail($para, $título, $mensaje, $cabeceras);


        // mensaje para el distribuidor
        $mensaje = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html lang="es">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Información de distribución</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <style type="text/css">
                    * {
                        font-family: Arial, Helvetica, sans-serif;
                    }
                    p {
                        font-size: 11pt;
                    }
                
                    a{
                        font-size: 11pt;
                        text-decoration:none;
                    }
                
                    a:link {
                        text-decoration:none;
                        color: #1a9fda;
                        }
                    a:visited {
                        text-decoration:none;
                        color: #1a9fda;
                        }
                </style>
            </head>
        <body>
            <div style="width: 650px; padding-top: 5px; padding-left: 10px;">
            <div style="line-height: 18pt;">
            <p>Gracias por solicitar informaci&oacute;n sobre la distribuci&oacute;n del Software Visionwin.</p>
            <p>Te adjunto un documento donde encontrar&aacute;s los detalles sobre la figura de distribuidor.&nbsp; En el caso
                de que tengas alguna consulta, no dudes en contestar este correo o llamar.</p>
            <p>Si quieres hacerte distribuidor, contesta este correo indicando tus datos fiscales, tel&eacute;fono, email y
                persona de contacto y te daremos de alta en nuestro sistema.</p>
            <p>&nbsp;</p>

            <hr style="border-top: 1px dashed lightgray;" />
            <table style="width: 650px;">
            <tbody>
            <tr>
            <td style="width: 65px; vertical-align: top;"><img style="border-radius: 95%;" src="http://www.visionwin.com/correos/sonia_ok.jpg" alt="Sonia" width="75" height="75" /></td>
            <td style="width: 375px; vertical-align: bottom;"><span style="font-size: 11pt; color: #000000; padding-left: 10px;"> Sonia </span>
            <p style="color: #808080; font-size: 9pt; padding-left: 10px; line-height: 14pt;">Tu asistente virtual<br />Tel. 964 455 551 - <a style="color: #808080; font-size: 9pt;" href="mailto:info@visionwin.com">info@visionwin.com</a></p>
            <p style="padding-left: 10px;"><a href="https://www.facebook.com/visionwin"><img src="http://www.visionwin.com/correos/facebook_gris.png" alt="" width="28" height="28" /></a> <a href="https://twitter.com/visionwin"><img src="http://www.visionwin.com/correos/twitter_gris.png" alt="" width="28" height="28" /></a> <a href="https://www.youtube.com/visionwinsoftware"><img src="http://www.visionwin.com/correos/youtube_gris.png" alt="" width="28" height="28" /></a></p>
            </td>
            <td style="width: 200px; vertical-align: top;"><a style="float: right;" href="https://www.visionwin.com"><img src="http://www.visionwin.com/correos/mailing/visionwin.png" alt="" width="128" height="34" /></a><br />
            <p style="float: right; text-align: right; color: #999999; font-size: 9pt;">Edificio Vinalab, C/ Galicia, 12<br />12500-Vinar&ograve;s (Castell&oacute;n) Spain</p>
            </td>
            </tr>
            </tbody>
            </table>
            </div>
            <p style="font-size: 7pt; color: #999999; width: 100%;" align="justify">De conformidad con el reglamento europeo en materia de protecci&oacute;n de datos 2016/679 del parlamento europeo y del consejo del 27 de abril del 2016 relativo a la protecci&oacute;n de datos de las personas f&iacute;sicas (RGPD), le informamos que los datos recibidos por cualquiera de los medios y/o canales de contacto previstos en el sitio web&nbsp; <a style="color: #999999; font-size: 7pt;" href="http://www.visionwin.com/" target="_blank" rel="noopener">www.visionwin.com</a>&nbsp; son objeto de tratamiento por parte de Visionwin Software, S.L&nbsp; (en adelante, Visionwin). Visionwin se exonera de toda responsabilidad por el incumplimiento de las obligaciones derivadas del RGPD o de la normativa correspondiente en materia de protecci&oacute;n de datos por parte del usuario y/o cliente en lo que a su actividad le corresponda y que se encuentre relacionado con la ejecuci&oacute;n del contrato o relaciones comerciales que le unan a Visionwin. Estos datos son tratados &uacute;nicamente con la finalidad de realizar las gestiones que en el mismo se especifiquen y en virtud de la relaci&oacute;n que nos une. Si usted desea ejercitar sus derechos de acceso, rectificaci&oacute;n, supresi&oacute;n, limitaci&oacute;n o portabilidad, puede enviarnos un email a&nbsp;<a style="color: #999999; font-size: 7pt;" href="mailto:info@visionwin.com" target="_blank" rel="noopener">info@visionwin.com</a>. M&aacute;s informaci&oacute;n sobre protecci&oacute;n de datos en nuestra p&aacute;gina web&nbsp; <a style="color: #999999; font-size: 7pt;" href="http://www.visionwin.com/politica-de-privacidad" target="_blank" rel="noopener"> http://www.visionwin.com/politica-de-privacidad </a>&nbsp;o contactando directamente con nosotros.</p>
            
                </div>
            
        </body>
            
        </html>';

        //cabecera del email 
        $cabeceras = "MIME-Version: 1.0\r\n";

        $cabeceras .= 'To: ' . $nombre . ' <' . $email . '>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";


        $archivoNombre = 'documentacion.pdf'; //nombre del archivo a ser enviado (sin la ruta, solo el nombre con la extensión, por ejemplo: imagen.jpg)
        $archivo = "/var/www/vhosts/visionwin.com/httpdocs/php/distribucion.pdf"; //ruta temporal del archivo a ser adjuntado (ubicación fisica del archivo subido en el servidor)
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

        mail($email, 'Información de distribución', $msg, $cabeceras);

        // Mando la petición al CRM para que cree el usuario
        $url = 'https://crm.visionwin.com/backend/api/usuarios/create';
            
        //inicializamos el objeto CUrl
        $ch = curl_init($url);
            
        //el json simulamos una petición de un login
        $emails = ['email' => $email];

        $jsonData = array(
            'nombre' => $nombre, 
            'origen' => 5,
            'consentimiento' => 1,
            'emails' => [$emails]
        );
    
        //creamos el json a partir de nuestro arreglo
        $jsonDataEncoded = 'datos='.json_encode($jsonData);

        //Indicamos que nuestra petición sera Post
        curl_setopt($ch, CURLOPT_POST, 1);
    
        //para que la peticion no imprima el resultado como un echo comun, y podamos manipularlo
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        //Adjuntamos el json a nuestra petición
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    
        //Agregamos los encabezados del contenido
        $token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjgsImVtYWlsIjoidmljdG9yQHZpc2lvbndpbi5jb20iLCJnbWFpbCI6InZpY3RvcmNhc2FqdWFuYW1hc0BnbWFpbC5jb20iLCJuYW1lIjoiVmljdG9yIiwic3VybmFtZSI6IkNhc2FqdWFuYSIsImV4dGVuc2lvbiI6InZpbmFyb3MxMDEiLCJpbWFnZSI6InZpY3Rvci5qcGVnIiwiaWF0IjoxNTk2NjQ2OTEzfQ.-llkMawbrsR8Oc4LpMxwlvtcg9V7ErVB7dDmrGBsOrQ';
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded',
                                                   'Authorization:'.$token));
    
        //utilicen estas dos lineas si su petición es tipo https y estan en servidor de desarrollo
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
        //Ejecutamos la petición
        $result = curl_exec($ch);
        curl_close ($ch);

    } else {
        
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'No ha sido posible enviar el formulario, asegúrate de marcar "No soy un robot", gracias.<br><br>';
        echo '</div>';
      
    }


}
?>
