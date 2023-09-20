<?php
 
    if (!isset($_GET['file']) || empty($_GET['file'])) {
        die("Parámetros incorrectos en la petición del fichero.");
    }

    if (!isset($_GET['programaid']) || empty($_GET['programaid'])) {
        die("Parámetros incorrectos en la petición del fichero.");
    }

    if (!isset($_GET['userid']) || empty($_GET['userid'])) {
        die("Parámetros incorrectos en la petición del fichero.");
    }


    $programa='';
    $programaid=$_GET['programaid'];
    $userid=$_GET['userid'];

 
    // Determino el programa por el ID ya que por $programa en ocasiones da problemas por los acentas
    switch ($programaid)
    {
        case '01':
            $programa='Visionwin Contabilidad';
            $descarga='contasetup.exe';
            break;

        case '02':
            $programa='Visionwin Gestion';
            $descarga='gestionsetup.exe';
            break;

        case '03':
            $programa='Visionwin TPV';
            $descarga='gestionsetuptpv.exe';
            break;

        case '04':
            $programa='Visionwin Ropa';
            $descarga='gestionsetuptpvropa.exe';
            break;

        case '05':
            $programa='Visionwin Quiosco';
            $descarga='gestionsetupquiosco.exe';
            break;
            
        case '06':
            $programa='Visionwin Libreria';
            $descarga='gestionsetuplibreria.exe';
            break;
            
        case '07':
            $programa='Visionwin Bar Restaurante';
            $descarga='gestionsetupbar.exe';
            break;
            
        case '08':
            $programa='Visionwin Pub';
            $descarga='gestionsetuppub.exe';
            break;
            
        case '09':
            $programa='Visionwin Panaderia';
            $descarga='gestionsetuppanaderia.exe';
            break;
            
        case '10':
            $programa='Visionwin Heladeria';
            $descarga='gestionsetupheladeria.exe';
            break;
            
        case '11':
            $programa='Visionwin Pizzeria';
            $descarga='gestionsetuppizzeria.exe';
            break;
            
        case '12':
            $programa='Visionwin Fast Food';
            $descarga='gestionsetupfastfood.exe';
            break;
            
        case '13':
            $programa='Visionwin Restaurante';
            $descarga='gestionsetuprestaurante.exe';
            break;
            
        case '14':
            $programa='Visionwin Taller';
            $descarga='gestionsetuptaller.exe';
            break;
            
        case '15':
            $programa='Visionwin Vehiculos';
            $descarga='gestionsetuptallervehiculos.exe';
            break;
            
        case '16':
            $programa='Visionwin Representantes';
            $descarga='gestionsetuprepresentante.exe';
            break;
            
        case '17':
            $programa='Visionwin Cristaleria';
            $descarga='gestionsetupmarco.exe';
            break;
            
        case '18':
            $programa='Visionwin Mantenimientos';
            $descarga='gestionsetupmantenimiento.exe'; 
            break;
            
        case '19':
            $programa='Visionwin Registro horario';
            $descarga='gestionsetupregistrohorario.exe';
            break;

        case '20':
            $programa='Visionwin Despachos';
            $descarga='gestionsetupdespacho.exe';
            break;

        case '21':
            $programa='Visionwin Estetica';
            $descarga='gestionsetupestetica.exe';
            break;
            
    }

    // Registro el correo y la descarga en la BBDD
    include_once 'php/class.Database.inc.php';
           
    $con = new Database;       

    // Localizo el email
    $query="SELECT email FROM wvisionwin.usuarios_emails AS usuarios
            WHERE usuarios.usuario_id = " . $userid. " LIMIT 1";

    $datos = $con->get_Row( $query );
    $email = $datos["email"];

    if ( $email != "" )
    {
        // Convierte a CP1252
        $programa=iconv("UTF-8", "CP1252", $programa);
       
        $query="INSERT INTO `wvisionwin`.`descargas` 
                          SET `email`='".$email."',
                          `programa`='".$programa."',
                          `programaid`='".$programaid."',
                          `fecha`='".date("Ymd")."',
                          `acepto`=1";
     
        $con->ejecutar_idu ($query);

    }
   
    // Procedo con la descarga
    $root = "descargas/";

    $path = $root.$descarga;
    $type = '';
 
    if (is_file($path)) {
        $size = filesize($path);
        if (function_exists('mime_content_type')) {
            $type = mime_content_type($path);
        } else if (function_exists('finfo_file')) {
                                                    $info = finfo_open(FILEINFO_MIME);
                                                    $type = finfo_file($info, $path);
                                                    finfo_close($info);
                                                }
        if ($type == '') {
            $type = "application/force-download";
        }
 
        // Define los headers
        header("Content-Type: $type");
        header("Content-Disposition: attachment; filename=$descarga"); 
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $size);
 
        // Descargar el archivo
        readfile($path);

    } else { 
                die("El archivo solicitado no existe.");
            }
 
?>



<?php
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>
