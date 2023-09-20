<?php

{ 
    
    // Recibimos y decodificamos la cadena json
    $data = json_decode(file_get_contents('php://input'), true);
    $cliente = $data["cliente"];
    $cif = $data["cif"];
    $importe = $data["importe"];
    $facturas = $data["facturas"];
    $cHtml = '';

    if ($importe !=0 ) { 
       
       $cHtml = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="info@sigev.com">
        <input type="hidden" name="item_name" value="Pago Factura">
        <input type="hidden" name="order_id" value="Factura :"'.$facturas.'">
        <input type="hidden" name="currency_code" value="EUR">
        <input type="hidden" name="amount" value="'.$importe.'">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="lc" value="ES">
        <input type="hidden" name="return" value="https://www.visionwin.com/pagofacturaok.html">
        <input type="hidden" name="cancel_return" value="https://www.visionwin.com/pagofacturako.html">
        <button class="btn btn-success" type="submit" id="botonPagaFacturaPaypal"></button>
    </form>';

      
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
                         <title>Software Visionwin - Pago de factura por PayPal</title>
                     </head>
                     <body>
                     Se ha realizado un pago o intento de pago por PayPal.
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