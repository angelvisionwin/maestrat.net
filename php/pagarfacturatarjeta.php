<?php

/*
  DATOS GENÉRICOS DE PRUEBA
  -------------------------
 Número de comercio (Ds_Merchant_MerchantCode): 999008881
 Terminal (Ds_Merchant_Terminal): 01
 Clave secreta: sq7HjrUOBfKmC576ILgskD5srU870gJ7
 Tarjeta aceptada:
 Numeración: 4548 8120 4940 0004
 Caducidad: 12/20
 Código CVV2: 123
 Para compras seguras, en la que se requiere la autenticación del titular, el
 código de autenticación personal (CIP) es 123456.

*/


{ 
    

    include_once 'apiRedsys.php';
    
    // Recibimos y decodificamos la cadena json
    $data = json_decode(file_get_contents('php://input'), true);
    $cliente = $data["cliente"];
    $cif = $data["cif"];
    $importe = $data["importe"];
    $facturas = $data["facturas"];
    $cHtml = '';

    if ($importe !=0 ) {

      $miObj = new RedsysAPI;
      $entornoprueba="NO";

      if ($entornoprueba=="SI"){
          $url_tpv='https://sis-t.redsys.es:25443/sis/realizarPago';    
          $code='999008881';
          $kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
      } else {
          $url_tpv='https://sis.redsys.es/sis/realizarPago';
          $code='329234397';
          $kc = 'uMr8kyk84aqa0B6DauZuDT4O+XbF/osP'; //Clave para SHA256   // Esta clave debe ser almacenada de la forma más segura posible
      }
         
      $amount = intval($importe*100); // Importe (x100)
      $name='Software Visionwin';


      $terminal='1';
      $currency='978'; // Euros
      $transactionType='0';
      $urlMerchant='https://www.visionwin.com';
      $urlMerchantOK='https://www.visionwin.com/pedidoko.html';  
      $urlMerchantKO='https://www.visionwin.com/pedidook.html';
      $producto='Pago factura Visionwin';
      //$order=intval($facturas)+1 ;
      $order=substr($facturas,3,4);
      $order.=substr( str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 6 );


      $miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
      $miObj->setParameter("DS_MERCHANT_ORDER",$order); 
      $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$code);
      $miObj->setParameter("DS_MERCHANT_CURRENCY",$currency);
      $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$transactionType);
      $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
      $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$urlMerchant);
      $miObj->setParameter("DS_MERCHANT_MERCHANTURLOK",$urlMerchantOK);
      $miObj->setParameter("DS_MERCHANT_MERCHANTURLKO",$urlMerchantKO);

      // Estos son opcionales pero mejor rellenarlos porque da más infomación  en la pantalla de pago 
      $miObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION",$producto);
      $miObj->setParameter("DS_MERCHANT_MERCHANTNAME",$name);

      //Datos de configuración
      $version="HMAC_SHA256_V1";
    
      // Se generan los parámetros de la petición
      $request = "";
      $params = $miObj->createMerchantParameters();
      $signature = $miObj->createMerchantSignature($kc);
      
      $cHtml = '<form name=compra action='.$url_tpv.' method=post>';
      $cHtml .= "<input type='hidden' name='Ds_SignatureVersion' value='$version'>";
      $cHtml .= "<input type='hidden' name='Ds_MerchantParameters' value='$params'>";
      $cHtml .= "<input type='hidden' name='Ds_Signature' value='$signature'>";
      $cHtml .= '<button class="btn btn-success ml-4" type="submit" id="botonPagaFacturaTarjeta"></button>';
      $cHtml .= '</form>';

    }

   // Envío del correo electrónico
    $para  = 'info@visionwin.com';

    // título
    $título = 'Software Visionwin - Pago de factura';

    // mensaje
   
    $mensaje = '
                <!DOCTYPE html>
                <html lang="es">
                    <head>
                        <meta charset="utf-8">
                        <title>Software Visionwin - Pago de factura por tarjeta</title>
                    </head>
                    <body>
                    Se ha realizado un pago o intento de pago por tarjeta.
                    Cliente : ' . $cliente .'<br/>
                    NIF : ' . $cif .'<br/>
                    Importe : ' . $importe . '<br/>
                    Facturas : ' . $facturas . '<br/>
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



    echo $cHtml;


}    