<?php

{ 
    include_once 'class.Database.inc.php';

    // Para generar PDF
    //require('fpdm.php'); 
    
    // Recibimos y decodificamos la cadena json
    $data = json_decode(file_get_contents('php://input'), true);
    $cliente = $data["cliente"];
    $cif = $data["cif"];
    $importe = $data["importe"];
    $facturas = $data["facturas"];
    $iban = $data["iban"];
    $cHtml = '';

    echo $iban;
}    
