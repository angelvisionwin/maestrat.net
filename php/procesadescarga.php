<?php   


if (isset($_POST['g-recaptcha-response'])) 
{

    include_once 'class.Database.inc.php';
   
    $email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $programa  = filter_input(INPUT_POST, 'programa', FILTER_SANITIZE_STRING);
    $programaHTML = $programa;
    $programaid = "00";

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
 
        // Establezco la URL de descarga
        // Cualquier cambio aquí reflejarlo en descargar.php
        switch ($programa)
        {
            case 'Visionwin Contabilidad':
                $descarga='contasetup.exe';
                $programaid="01";
                break;

            case 'Visionwin Gestión':
                $programaHTML='Visionwin Gesti&oacute;n';
                $descarga='gestionsetup.exe';
                $programaid="02";
                break;

            case 'Visionwin TPV':
                $descarga='gestionsetuptpv.exe';
                $programaid="03";
                break;

            case 'Visionwin Ropa y Calzado':
                $descarga='gestionsetuptpvropa.exe';
                $programaid="04";
                break;

            case 'Visionwin Quioscos':
                $descarga='gestionsetupquiosco.exe';
                $programaid="05";
                break;

            case 'Visionwin Librerías':
                $programaHTML='Visionwin Librer$iacute;a';
                $descarga='gestionsetuplibreria.exe';
                $programaid="06";
                break;

            case 'Visionwin Bar, Cafetería':
                $programaHTML='Visionwin Bar, Cafeter&iacute;a';
                $descarga='gestionsetupbar.exe';
                $programaid="07";
                break;

            case 'Visionwin Pub, Discoteca':
                $descarga='gestionsetuppub.exe';
                $programaid="08";
                break;

            case 'Visionwin Panadería':
                $programaHTML='Visionwin Panader&iacute;a';
                $descarga='gestionsetuppanaderia.exe';
                $programaid="09";
                break;

            case 'Visionwin Heladería':
                $programaHTML='Visionwin Helader&iacute;a';
                $descarga='gestionsetupheladeria.exe';
                $programaid="10";
                break;

            case 'Visionwin Pizzería':
                $programaHTML='Visionwin Pizzer&iacute;a';
                $descarga='gestionsetuppizzeria.exe';
                $programaid="11";
                break;

            case 'Visionwin FastFood, Comida Rápida':
                $programaHTML='Visionwin FastFood, Comida R&aacute;pida';
                $descarga='gestionsetupfastfood.exe';
                $programaid="12";
                break;

            case 'Visionwin Restaurantes':
                $descarga='gestionsetuprestaurante.exe';
                $programaid="13";
                break;

            case 'Visionwin Taller':
                $descarga='gestionsetuptaller.exe';
                $programaid="14";
                break;

            case 'Visionwin Taller de vehículos':
                $programaHTML='Visionwin Taller de veh&iacute;culos';
                $descarga='gestionsetuptallervehiculos.exe';
                $programaid="15";
                break;

            case 'Visionwin Representantes':
                $descarga='gestionsetuprepresentante.exe';
                $programaid="16";
                break;

            case 'Visionwin Carpintería':
                $programaHTML='Visionwin Carpinter&iacute;a';
                $descarga='gestionsetupmarco.exe';
                $programaid="17";
                break;

            case 'Visionwin Servicios':
                $descarga='gestionsetupmantenimiento.exe';
                $programaid="18";
                break;

            case 'Visionwin Registro horario':
                $descarga='gestionsetupregistrohorario.exe';
                $programaid="19";
                break;

            case 'Visionwin Despachos':
                $descarga='gestionsetupdespacho.exe';
                $programaid="20";
                break;

            case 'Visionwin Estética':
                $descarga='gestionsetupestetica.exe';
                $programaid="21";
                break;
    

        }

        // Convierte a CP1252
        $programa=iconv("UTF-8", "CP1252", $programa);
        
        // Envío del correo electrónico
        // Varios destinatarios
        $para  = $email;


        // título
        $título = 'Software Visionwin - Solicitud de descarga';

                // Mando la petición al CRM para que cree el usuario
        $url = 'https://crm.visionwin.com/backend/api/usuarios/create';
                    
        //inicializamos el objeto CUrl
        $ch = curl_init($url);
                    
        //el json simulamos una petición de un login
        $emails = ['email' => $email];
                    
        $jsonData = array(
             'nombre' => $email, 
             'origen' => 6,
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
        $result = json_decode( curl_exec($ch), true );
        $userid = $result["id"];
        curl_close ($ch);

        // mensaje
        $mensaje = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html lang="es">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Descarga gratuita de '.$programaHTML.'</title>
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
                <div style="width: 650px;  padding-top:5px;padding-left:10px;">
                    <div style="line-height: 18pt;">
                        <h2><span style="color: #1a9fda; font-weight: lighter;">Descarga de '.$programaHTML.'</span></h2>
                        <p style="padding-top: 5px;"><strong>Gracias</strong> por solicitar la descarga de '.$programaHTML.'.</p>
                        <p>Desde Visionwin esperamos que disfrutes utilizando el programa.<br />
                            Recuerda que vas a descargar la versi&oacute;n completa <strong>sin limitaciones de uso</strong><br/>
                        </p>
                    
                        <h2 style="padding-left: 25px;padding-bottom:20px;">
                            <br /> 
                            <span style="border: none; color: white; padding: 14px 28px; cursor: pointer; background-color: #1a9fda; font-weight: lighter;">
                                <a style="color: white; font-size:14pt;" href="https://www.visionwin.com/descargar.php?file='.$descarga.'&programaid='.$programaid.'&userid='.$userid.'">Descargar ahora</a>
                            </span>
                        </h2>
                        <p>Aprovechamos para dejarte algunos enlaces que pueden serte de utilidad :&nbsp;</p>
                        <ul style="text-align: left; padding-bottom:5px;">
                            <li><a href="https://www.youtube.com/visionwinsoftware">Videotutoriales y primeros pasos</a></li>
                            <li><a href="https://www.visionwin.com/blog.php">Novedades y noticias</a></li>
                            <li><a href="https://www.visionwin.com/registro.html">Una semana de soporte gratuito por chat o email registr&aacute;ndote como usuario</a></li>
                            <li><a href="https://www.visionwin.com/contratar-soporte.html">Acceso a soporte t&eacute;cnico y actualizaciones</a></li>
                        </ul>
                        <p>Por favor no utilices esta versi&oacute;n para actualizar una instalaci&oacute;n ya existente.</p>
                    </div>
                    
                    <hr style="border-top: 1px dashed lightgray;" >
                    <table style="width:650px;">
                        <tr>
                            <td style="width:65px; vertical-align: top;">
                                <img style="border-radius: 95%;" src="http://www.visionwin.com/correos/sonia_ok.jpg" alt="Sonia" width="75" height="75" />
                            </td>
                            <td style="width:375px; vertical-align: bottom;">
                                <span style="font-size: 11pt; color: #000000;padding-left:10px;">
                                    Sonia
                                </span>
                                <p style="color: #808080; font-size: 9pt; padding-left:10px;line-height: 14pt;">
                                        Tu asistente virtual<br>
                                        Tel. 964 455 551 - 
                                        <a style="color: #808080; font-size:9pt;" href="mailto:info@visionwin.com">info@visionwin.com</a>
                                </p>    
                                <p style="padding-left:10px;">
                                        <a href="https://www.facebook.com/visionwin"><img src="http://www.visionwin.com/correos/facebook_gris.png" alt="" width="28" height="28" /></a>
                                        <a href="https://twitter.com/visionwin"><img src="http://www.visionwin.com/correos/twitter_gris.png" alt="" width="28" height="28" /></a>
                                        <a href="https://www.youtube.com/visionwinsoftware"><img src="http://www.visionwin.com/correos/youtube_gris.png" alt="" width="28" height="28" /></a>
                    
                                </p>
                            </td>
                            <td style="width:200px; vertical-align:top;">
                                <a style="float:right;" href="https://www.visionwin.com"><img src="http://www.visionwin.com/correos/mailing/visionwin.png" alt="" width="128" height="34" /></a><br />
                                <p style="float:right; text-align:right; color: #999999; font-size: 9pt;">Edificio Vinalab, C/ Galicia, 12<br />12500-Vinar&ograve;s (Castell&oacute;n) Spain</p>
                            </td>
                        </tr>
                    </table>
                    <p style="font-size: 7pt; color: #999999; width: 100%;" align="justify">
                        De conformidad con el reglamento europeo en materia de protecci&oacute;n de datos 2016/679 del parlamento europeo y del consejo del 27 de abril del 2016
                         relativo a la protecci&oacute;n de datos de las personas f&iacute;sicas (RGPD), le informamos que los datos recibidos por cualquiera de los medios 
                         y/o canales de contacto previstos en el sitio web&nbsp;
                         <a style="color: #999999; font-size:7pt;" href="http://www.visionwin.com/" target="_blank" rel="noopener">www.visionwin.com</a>&nbsp;
                         son objeto de tratamiento por parte de Visionwin Software, S.L&nbsp; 
                         (en adelante, Visionwin). Visionwin se exonera de toda responsabilidad por el incumplimiento de las obligaciones derivadas 
                         del RGPD o de la normativa correspondiente en materia de protecci&oacute;n de datos por parte del usuario y/o cliente en lo que a su actividad 
                         le corresponda y que se encuentre relacionado con la ejecuci&oacute;n del contrato o relaciones comerciales que le unan a Visionwin. 
                         Estos datos son tratados &uacute;nicamente con la finalidad de realizar las gestiones que en el mismo se especifiquen y en virtud de la relaci&oacute;n 
                         que nos une. Si usted desea ejercitar sus derechos de acceso, rectificaci&oacute;n, supresi&oacute;n, limitaci&oacute;n o portabilidad, puede enviarnos 
                         un email a&nbsp;<a style="color: #999999; font-size:7pt;" href="mailto:info@visionwin.com" target="_blank" rel="noopener">info@visionwin.com</a>. 
                         M&aacute;s informaci&oacute;n sobre protecci&oacute;n de datos en nuestra p&aacute;gina web&nbsp;
                         <a style="color: #999999; font-size:7pt;" href="http://www.visionwin.com/politica-de-privacidad" target="_blank" rel="noopener">
                            http://www.visionwin.com/politica-de-privacidad
                        </a>&nbsp;o contactando directamente con nosotros.</p>
                    
                 </div>
            </body>        
        </html> ';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales
        //$cabeceras .= 'To: Visionwin <info@visionwin.com>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";

        // Enviarlo
        mail($para, $título, $mensaje, $cabeceras);

         
        echo '<p>Te hemos enviado el enlace de descarga solicitado a tu dirección de correo. </p>';
        echo '<p>Gracias por tu interés, esperamos que disfrutes utilizando el Software Visionwin</p>';
         
    } else {
        
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'No ha sido posible enviar el formulario, asegúrate de marcar "No soy un robot", gracias.<br><br>';
        echo '</div>';

    }

}

?>
