<?php   

if (isset($_POST['g-recaptcha-response'])) 
{
   
    $nombre =filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $consulta = filter_input(INPUT_POST, 'consulta', FILTER_SANITIZE_STRING);
    

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
        echo 'Gracias <strong>'.$nombre.'</strong>, nos pondremos en contacto contigo lo antes posible.<br>';
        echo '<br>';
        echo 'Tu consulta : <br>';
        echo '<strong>'.$consulta.'</strong>';
        echo '</div>';
      
              // Mando la petición al CRM para que cree el usuario
        $url = 'https://crm.visionwin.com/backend/api/usuarios/create';
     
        //inicializamos el objeto CUrl
        $ch = curl_init($url);
     
        //el json simulamos una petición de un login
        $emails = ['email' => $email];
    
        $jsonData = array(
            'nombre' => $nombre, 
            'origen' => 4,
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


        // Creo el tiquet en FreshDesk
        $postfields = array(  
            "email"=> $email,
            "subject"=> "Formulario de contacto",
            "status"=> 2,     // open
            "priority"=> 1,   // low
            "description"=> $consulta,
            "source"=>2     // portal
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
