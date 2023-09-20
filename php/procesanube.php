<?php

if (isset($_POST['g-recaptcha-response'])) 
{

    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $programa = filter_input(INPUT_POST, 'selectprograma', FILTER_SANITIZE_STRING);

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

        // Array donde se guardan la correlaciones entre programas y programaid
        $idprogramas = [
            'contabilidad' => '01',
            'gestion' => '02',
            'tpv' => '03',
            'ropacalzado' => '04',
            'quioscos' => '05',
            'librerias' => '06',
            'bar' => '07',
            'pub' => '08',
            'panaderia' => '09',
            'heladeria' => '10',
            'pizzeria' => '11',
            'fastfood' => '12',
            'restaurantes' => '13',
            'taller' => '14',
            'tallervehiculos' => '15',
            'representantes' => '16',
            'carpinteria' => '17',
            'servicios' => '18',
            'registrohorario' => '19'];

        // Almaceno en la base de datos
        include_once 'class.Database.inc.php';

        $con = new Database;       
        
        $query="INSERT INTO `wvisionwin`.`nube` (`nombre`, `programa`,`email`, `programaid` ) VALUES ('";
        
        $query.=$nombre."','";
        $query.=$programa."','";
        $query.=$email."','";
        $query.=$idprogramas[$programa]."')";
        
        $con->ejecutar_idu ($query);

        echo '<div class="alert alert-light alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'Gracias <strong>'.$nombre.'</strong>, hemos enviado un correo a la dirección indicada.<br>';
        echo '<br>';
        echo '</div>';

        /* Envío del correo electrónico a visionwin con el aviso
        $para  = 'info@visionwin.com';

        // titulo
        $titulo = 'Software Visionwin - Nueva Solicitud de Visionwin en la nube ';

        // mensaje
        $mensaje = '
                    <!DOCTYPE html>
                    <html lang="es">
                        <head>
                            <meta charset="utf-8">
                            <title>Software Visionwin - Información de Visionwin en la nube</title>
                        </head>
                        <body>
                        Nombre : ' . $nombre . '<br/>
                        Email : ' . $email . '<br/>
                        Programa : ' . $programa . '<br/>
                        </body>
                    </html>';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'To: Visionwin <info@visionwin.com>' . "\r\n";
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n";

        // Enviarlo
        mail($para, $titulo, $mensaje, $cabeceras);*/

        // ---------------  Envío el correo electrónico al cliente -------------------------------

        $usuarios = "";
        $clave = "";

        $usuarios = [
            'contabilidad' => 'vconta:196574',
            'gestion' => 'vgestion:874589',
            'tpv' => 'vtpv:512847',
            'ropacalzado' => 'vropa:457896',
            'quioscos' => 'vquiosco:819532',
            'librerias' => 'vlibreria:256981',
            'bar' => 'vbar:976431',
            'pub' => 'vpub:953741',
            'panaderia' => 'vpan:912854',
            'heladeria' => 'vhelado:852147',
            'pizzeria' => 'vpizza:951236',
            'fastfood' => 'vfood:852144',
            'restaurantes' => 'vrestaurante:125890',
            'taller' => 'vtaller:859632',
            'tallervehiculos' => 'vvehiculo:521478',
            'representantes' => 'vrepre:508962',
            'carpinteria' => 'vcristal:904967',
            'servicios' => 'vservicio:105896',
            'registrohorario' => 'vhora:120059'
        ];

        $dato   = $usuarios[$programa];
        $separa = strpos($dato, ":");
        $usuario = substr($dato, 0, $separa);
        $clave = substr($dato, $separa + 1, 15);


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
                        <h2>Información sobre Visionwin en la nube</h2>
                        <p>Hola.</p>
                
                        <p>Gracias por interesarte en nuestro software Visionwin en la Nube.</p>
                        <p>Para poder acceder a la demostración, debes realizar los siguientes pasos:</p>
                
                        <p style="padding-left: 25px;">1) Escribe en tu navegador web la siguiente dirección:</p>
                        <p style="padding-left: 50px;"><a href="http://54.36.121.217:8900/">http://54.36.121.217:8900/</a></p>
                        <p style="padding-left: 25px;">2) En el nombre de usuario y contraseña escribe:</p>
                        <p style="padding-left: 50px;">usuario: <b>' . $usuario . '</b><br/>
                        clave: <b>' . $clave . '</b></p>
                
                        <p>Con estos dos simples pasos ya tendrás acceso a Visionwin en la nube.<br/>
                        <b>Mientras estés en modo desmostración debes tener en cuenta que cada día a la 1 de la madrugada el servidor de demostración reinicia los datos, también cada vez que cierres el programa se hace un borrado de la información.</b>
                        </p>
                
                        <p>En este artículo de nuestro blog encontrarás ayuda sobre el funcionamiento y también muchas dudas
                            resueltas: <a href="https://www.visionwin.com/documentacion/general/index.html?visionwin-en-la-nube.html">Visionwin en la nube</a></p>
                
                        <p>No obstante cualquier consulta que tengas no dudes en contestar este correo, abrir un chat directo en
                            www.visionwin.com o llamar al 964445551 y estaremos encantados de atenderte.</p>
                
                        <p>Un Saludo.</p>
                
                        <p>
                            <br />
                            <br />
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
                                        <p style="color: #777777; font-size: 9pt;"><a style="color: #777777; text-decoration: none;"
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
                                rel="noopener">www.visionwin.com</a>&nbsp;son objeto de tratamiento por parte de Visionwin Software, S.L&nbsp; (en adelante, Visionwin). 
                                Visionwin se exonera de toda responsabilidad por el incumplimiento
                            de
                            las
                            obligaciones derivadas del RGPD o de la normativa correspondiente en materia de protecci&oacute;n de
                            datos
                            por parte del usuario y/o cliente en lo que a su actividad le corresponda y que se encuentre
                            relacionado
                            con
                            la ejecuci&oacute;n del contrato o relaciones comerciales que le unan a Visionwin. Estos
                            datos
                            son tratados &uacute;nicamente con la finalidad de realizar las gestiones que en el mismo se
                            especifiquen y
                            en virtud de la relaci&oacute;n que nos une. Si usted desea ejercitar sus derechos de acceso,
                            rectificaci&oacute;n, supresi&oacute;n, limitaci&oacute;n o portabilidad, puede enviarnos un email
                            a&nbsp;<a style="color: #999999;" href="mailto:info@visionwin.com" target="_blank"
                                rel="noopener">info@visionwin.com</a>. M&aacute;s informaci&oacute;n sobre protecci&oacute;n de
                            datos en
                            nuestra p&aacute;gina web&nbsp;<a style="color: #999999;"
                                href="http://www.visionwin.com/politica-de-privacidad" target="_blank"
                                rel="noopener">http://www.visionwin.com/politica-de-privacidad</a>&nbsp;o contactando
                            directamente
                            con nosotros.</p>
                    </div>
                    <div class="separa"></div>
                </div>
            </body>
                
            </html>';

        // titulo
        $titulo = 'Software Visionwin - Información de Visionwin en la nube ';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'From: Software Visionwin <info@visionwin.com>' . "\r\n"; 

        // Enviarlo
        mail($email, $titulo, $mensaje, $cabeceras);

        //Refresco el panel del crm
        $url = 'https://crm.visionwin.com/backend/api/panel/info';
                
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close ($ch);

    } else {
        
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<br>';
        echo 'No ha sido posible enviar el formulario, asegúrate de marcar "No soy un robot", gracias.<br><br>';
        echo '</div>';
      
    }


}
?>

