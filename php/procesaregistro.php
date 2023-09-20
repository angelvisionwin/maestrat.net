<?php   

if (isset($_POST['g-recaptcha-response'])) 
{

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


        
        
        include_once 'class.Database.inc.php';
        
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
        $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_STRING);
        $poblacion = filter_input(INPUT_POST, 'poblacion', FILTER_SANITIZE_STRING);
        $provincia = filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_STRING);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $programa = filter_input(INPUT_POST, 'programa', FILTER_SANITIZE_STRING);
        $consulta=filter_input(INPUT_POST, 'consulta', FILTER_SANITIZE_STRING);

        // Primero que todo se comprueba si el usuario ya ha disfrutado de una semana gratuita

        $respuesta = tienesemanagratuita( $email );

        if ( $respuesta )

        {

            echo '<div class="alert alert-light alert-dismissible fade show" role="alert">';
            echo '<br>';
            echo 'Lo lamento pero ya has utilizado tu semana gratuita.';
            echo '<br>';
            echo 'Si quieres más información puedes comunicarte con nosotros directamente por el chat de la web o enviando un correo a <a href ="mailto:soporte@visionwin.com">soporte@visionwin.com</a>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '</div>';
    
            return ( '' );
        }


        echo '<div class="alert alert-light alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'Gracias <strong>'.$nombre.'</strong>, tu formulario de registro ha sido enviado. Tienes una semana de consultas gratuitas por chat o email (soporte@visionwin.com) a partir de hoy.';
        echo '<br>';
        echo 'Tu consulta : <br>';
        echo '<strong>'.$consulta.'</strong>';
        echo '</div>';
    
        
        $con = new Database;       
        
        $query="INSERT INTO `wvisionwin`.`registros` (`nombre`, `direccion`, `cp`, `poblacion`, `provincia`, `telefono`, `email`, `programa`, `consulta`) VALUES ('";
        
        $query.=iconv("UTF-8", "CP1252", $nombre)."','";
        $query.=iconv("UTF-8", "CP1252", $direccion)."','";
        $query.=$cp."','";
        $query.=iconv("UTF-8", "CP1252", $poblacion)."','";
        $query.=iconv("UTF-8", "CP1252", $provincia)."','";
        $query.=$telefono."','";
        $query.=$email."','";
        $query.=$programa."','";
        $query.=iconv("UTF-8", "CP1252", $consulta)."')";
        
        $con->ejecutar_idu ($query);
        
        // Obtiene el ID del registro añadido
        $row = $con->get_Row("SELECT @@identity AS ID");
        $IDultimo = $row['ID'];

        // mensaje para el cliente
        $título = 'Software Visionwin - Formulario de Registro';
        $mensaje = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html lang="es">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Registro de usuario gratuito</title>
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
            <div style="width: 800px; padding-top: 5px; padding-left: 10px;">
            <div style="line-height: 18pt;">
            <p style="padding-top: 5px; text-align: justify;"><strong>Gracias</strong> por tu inter&eacute;s en el <strong>Software Visionwin</strong></p>
            <p style="text-align: justify;">A partir de ahora dispones de una semana de soporte gratuito.</p>
            <p style="text-align: justify;">Puedes realizar las consultas utilizando el formulario de soporte o mediante el chat en <a title="Visionwin.com" href="https://www.visionwin.com">visionwin.com</a><br />Nuestro deseo es que puedas comprobar todas las posibilidades que te ofrecen las aplicaciones Visionwin, por ello te invitamos a que nos consultes cualquier duda que pueda surgirte.</p>
            <p style="text-align: justify;">Para realizar consultas por chat o email identificate mediante tu correo :&nbsp;'.$email.'</p>
            <p style="text-align: justify;">Recuerda que si quieres soporte durante todo un a&ntilde;o, adem&aacute;s de acceso a las actualizaciones y revisiones, puedes aprovechar nuestras ajustadas tarifas de servicio.</p>
            <p style="text-align: justify;">Te dejo algunos enlaces de que te pueden ser &uacute;tiles&nbsp;</p>
            <ul style="text-align: left; padding-bottom: 5px;">
            <li style="text-align: justify;"><a href="https://www.visionwin.com/contacto.html">Formulario de contacto</a></li>
            <li style="text-align: justify;"><a href="https://www.visionwin.com">Chat desde la web</a></li>
            <li style="text-align: justify;"><a href="https://www.visionwin.com/precios.html">Tarifas de soporte t&eacute;cnico</a></li>
            </ul>
            <p>&nbsp;</p>
            </div>
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
            <p style="font-size: 7pt; color: #999999; width: 100%;" align="justify">De conformidad con el reglamento europeo en materia de protecci&oacute;n de datos 2016/679 del parlamento europeo y del consejo del 27 de abril del 2016 relativo a la protecci&oacute;n de datos de las personas f&iacute;sicas (RGPD), le informamos que los datos recibidos por cualquiera de los medios y/o canales de contacto previstos en el sitio web&nbsp; <a style="color: #999999; font-size: 7pt;" href="http://www.visionwin.com/" target="_blank" rel="noopener">www.visionwin.com</a>&nbsp; son objeto de tratamiento por parte de Visionwin Software, S.L&nbsp; (en adelante, Visionwin). Visionwin se exonera de toda responsabilidad por el incumplimiento de las obligaciones derivadas del RGPD o de la normativa correspondiente en materia de protecci&oacute;n de datos por parte del usuario y/o cliente en lo que a su actividad le corresponda y que se encuentre relacionado con la ejecuci&oacute;n del contrato o relaciones comerciales que le unan a Visionwin. Estos datos son tratados &uacute;nicamente con la finalidad de realizar las gestiones que en el mismo se especifiquen y en virtud de la relaci&oacute;n que nos une. Si usted desea ejercitar sus derechos de acceso, rectificaci&oacute;n, supresi&oacute;n, limitaci&oacute;n o portabilidad, puede enviarnos un email a&nbsp;<a style="color: #999999; font-size: 7pt;" href="mailto:info@visionwin.com" target="_blank" rel="noopener">info@visionwin.com</a>. M&aacute;s informaci&oacute;n sobre protecci&oacute;n de datos en nuestra p&aacute;gina web&nbsp; <a style="color: #999999; font-size: 7pt;" href="http://www.visionwin.com/politica-de-privacidad" target="_blank" rel="noopener"> http://www.visionwin.com/politica-de-privacidad </a>&nbsp;o contactando directamente con nosotros.</p>
            </div>
                    </body>        
        </html> ';

        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales

        $nombre = str_replace(",", "", $nombre);
        $nombre = str_replace(".", "", $nombre);

        //$cabeceras .= 'To: '.$nombre.' <'.$email.'>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";

        // Envio mensaje al admin
        mail($email, $título, $mensaje, $cabeceras);
            
        // Mando la petición al CRM para que cree el usuario
        $url = 'https://crm.visionwin.com/backend/api/usuarios/create';
            
        //inicializamos el objeto CUrl
        $ch = curl_init($url);
            
        //el json simulamos una petición de un login
        $emails = ['email' => $email];

        $gestion=0;
        $contabilidad=0;
        $tpv=0;

        $programaFreshDesk = '';

        // Respetar el NO poner acentos
        if ($programa=='Gestion'){
            $gestion=1;
            $programaFreshDesk = 'Visionwin Gestion';
        }

        if ($programa=='Contabilidad'){
            $contabilidad=1;
            $programaFreshDesk = 'Visionwin Contabilidad';
        }

        if ($programa=='TPV'){
            $tpv=1;
            $programaFreshDesk = 'Visionwin TPV';
        }

        if ($programa=='Ambos'){
            $gestion=1;
            $contabilidad=1;
            $programaFreshDesk = 'Visionwin Gestion y Contabilidad';
        }

        $jsonData = array(
            'nombre' => $nombre, 
            'origen' => 3,
            'gestion' => $gestion,
            'contabilidad' => $contabilidad,
            'tpv' => $tpv,
            'registros_id' => $IDultimo,
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

        //Refresco el panel del crm
        $url = 'https://crm.visionwin.com/backend/api/panel/info';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close ($ch);


        // Creo el tiquet en FreshDesk
        $postfields = array(  
            "name"=> $nombre,
            "email"=> $email,
            "subject"=> "Semana gratuita : " .$programa ,
            "status"=> 2,     // open
            "priority"=> 1,   // low
            "description"=> $consulta,
            "source"=>2,     // portal
            "tags"=>[ $programaFreshDesk ],
            "type"=> $programaFreshDesk
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://visionwin.freshdesk.com//api/v2/tickets',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode( $postfields ),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic NnNqSkpkeVBETllZOThpTHJNU1E6WA=='
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    
    } else {
        
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'No ha sido posible enviar el formulario, asegúrate de marcar "No soy un robot", gracias.<br><br>';
        echo '</div>';
  
}


}
?>

<?php
function tienesemanagratuita( $email )

{

            
        // Mando la petición al CRM para que cree el usuario
        $url = 'https://crm.visionwin.com/backend/api/usuarios/tienesemanagratuita';
            
        //inicializamos el objeto CUrl
        $ch = curl_init($url);
        
        //creamos el json a partir de nuestro arreglo
        $jsonData = ['email' => $email];
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

        $result = json_decode( $result );
        return ( $result->tienesemanagratuita  );
}
?>
