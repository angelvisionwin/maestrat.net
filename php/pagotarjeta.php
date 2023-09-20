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

if (isset($_POST['token'])) 
{
    
    include_once 'class.Database.inc.php';
    include_once 'apiRedsys.php';
    
    $pedido = filter_input(INPUT_POST, 'pedido', FILTER_SANITIZE_NUMBER_INT);
    
    $con = new Database; 
    $row=$con->get_Row ("SELECT numero,total FROM pedidosvisionwin where numero='".$pedido."'");

     
    // Si se encuentra el pedido proceso la llamada a la pasarela de pago
    if ($row['numero']!=0){
        // Se crea Objeto
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

        $amount = $row["total"]*100; // Importe (x100) 
        $name='Software Visionwin';
    
        $terminal='1';
        $currency='978'; // Euros
        $transactionType='0';
        $urlMerchant='https://www.visionwin.com';
        $urlMerchantOK='https://www.visionwin.com/pedidook.html';  
        $urlMerchantKO='https://www.visionwin.com/pedidoko.html';
        $producto='Soporte Visionwin';
        $order='Pedido:'.$pedido;
  
        $miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
        $miObj->setParameter("DS_MERCHANT_ORDER",strval($order));
        $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$code);
        $miObj->setParameter("DS_MERCHANT_CURRENCY",$currency);
        $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$transactionType);
        $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$urlMerchant);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURLOK",$urlMerchantOK);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURLKO",$urlMerchantKO);

        /* Estos son opcionales pero mejor rellenarlos porque da más infomación  en la pantalla de pago */
        $miObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION",$producto);
        $miObj->setParameter("DS_MERCHANT_MERCHANTNAME",$name);
  
        //Datos de configuración
        $version="HMAC_SHA256_V1";
    
	
        // Se generan los parámetros de la petición
        $request = "";
        $params = $miObj->createMerchantParameters();
        $signature = $miObj->createMerchantSignature($kc);
        
        echo '<form name=compra action='.$url_tpv.' method=post>';
        echo "<input type='hidden' name='Ds_SignatureVersion' value='$version'>";
        echo "<input type='hidden' name='Ds_MerchantParameters' value='$params'>";
        echo "<input type='hidden' name='Ds_Signature' value='$signature'>";
        echo '<button class="btn btn-primary " type="submit" id="botonenviaformulariotarjeta">Pagar ahora por Tarjeta</button>';
        echo '</form>';
    }
}
