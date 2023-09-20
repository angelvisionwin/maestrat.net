<?php   

    $titulo =filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $detalle = filter_input(INPUT_POST, 'detalle', FILTER_SANITIZE_STRING);
    $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $contabilidad=$_POST["contabilidad"];
    $gestion=$_POST["gestion"];

    if ($contabilidad=='on') { 
        $contabilidad=1;
    } else {
        $contabilidad=0;
    }

    if ($gestion=='on') { 
        $gestion=1;
    } else {
        $gestion=0;
    }

    // Almaceno en la base de datos
    
    include_once 'class.Database.inc.php';

    $con = new Database;       
    
    $query="INSERT INTO `wvisionwin`.`form_sugerencias` (`observa`, `titulo`, `categoria`,`descripcion`, `email`, `contabilidad`, `gestion` ) VALUES ('";
 
    $query.=$observa."','";
    $query.=$titulo."','";
    $query.=$categoria."','";
    $query.=$detalle."','";
    $query.=$email."','";
    $query.=$contabilidad."','";
    $query.=$gestion."')"; 

    $con->ejecutar_idu ($query);

    // Inserto también en la relación de votos para evitar luego votaciones repetidas
    
    // Obtiene el número del registro añadido
    $row = $con->get_Row("SELECT @@identity AS ID");
    $ID = $row['ID'];

    $query="INSERT INTO `wvisionwin`.`form_sugerencias_votos` (`email`, `id_sugerencia`,`votos` ) VALUES ('";
 
    $query.=$email."','";
    $query.=$ID."','1')";

    $con->ejecutar_idu ($query);

     // Mando la petición al CRM para que cree el usuario
     $url = 'https://crm.visionwin.com/backend/api/usuarios/create';
 
     //inicializamos el objeto CUrl
     $ch = curl_init($url);
  
     //el json simulamos una petición de un login
     $emails = ['email' => $email];
 
     $jsonData = array(
         'nombre' => $email, 
         'origen' => 7,
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
