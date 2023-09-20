<?php
    if (!isset($_GET['email']) || empty($_GET['email'])) {
        die("Parámetros incorrectos en la petición.");
    }

    $email= $_GET['email'];

    // Mando la petición al CRM para que marque el usuario
    $url = 'https://crm.visionwin.com/backend/api/usuarios/anadeemailsuscripcionoferta';
 
    //inicializamos el objeto CUrl
    $ch = curl_init($url);
    
    $jsonData = array(
        'email' => $email
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

    echo '<div style="font-family: Vegur, Verdana, sans-serif;height:100%;background-color: #55ACEE; color: #ffffff; display:flex; justify-content: center; align-items:center">';
    echo '<h2><center>Hemos registrado tu correo para la OFERTA ESPECIAL<br> En unos días nos pondremos en contacto contigo para informarte</center></h2>';
    echo '</div>';
   
 
?>