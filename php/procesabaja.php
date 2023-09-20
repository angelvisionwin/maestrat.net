<?php   

    $nombre =filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $motivo = filter_input(INPUT_POST, 'motivo', FILTER_SANITIZE_STRING);
    $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);
    
    // Almaceno en la base de datos
    include_once 'class.Database.inc.php';

    $con = new Database;       
    
    $query="INSERT INTO `wvisionwin`.`form_bajas` (`motivo`, `comentario`,`nombre`, `email` ) VALUES ('";
 
    $query.=$motivo."','";
    $query.=$comentario."','";
    $query.=$nombre."','";
    $query.=$email."')";
    
    $con->ejecutar_idu ($query);

    //Refresco el panel del crm
    $url = 'https://crm.visionwin.com/backend/api/panel/info';
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close ($ch);

?>
