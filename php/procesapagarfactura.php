
<?php   

if ( true )  
{

    include_once 'class.Database.inc.php';
    include_once 'apiRedsys.php';


    $data = json_decode(file_get_contents('php://input'), true);

    $con = new Database;
    $row = "SELECT codigoclientevisionwin,nombre,cif FROM usuarios where codigoclientevisionwin=" . $data["codigo"] . " AND cif='". $data["nif"] . "'";
    $row = $con->get_Row ( $row );

    $pagoFactura = new stdClass();

    $cHtml = "";
    $pagoFactura->cliente = 0;
    $pagoFactura->cif = '';
    $pagoFactura->total = 0;
    $pagoFactura->facturas = '';

    if (!Empty ( $row ))
    {
      $pagoFactura->cliente = $row["codigoclientevisionwin"];
      $pagoFactura->cif = $row["cif"];
   
      $cHtml .= "Código : ".$row["codigoclientevisionwin"];
      $cHtml .= '<br>';
      $cHtml .= "Nombre : " . utf8_encode( $row["nombre"] );
      $cHtml .= '<br>';
      $cHtml .= "NIF : ".$row["cif"];
      $cHtml .= '<br>'; 
      $cHtml .= '<br>';

      $row = "SELECT serie,numero,libramiento AS fecha,vencimiento,importependiente AS importe FROM usuarios_recibospendientes WHERE codigoclientevisionwin=". $data["codigo"];
      $row = $con->get_Cursor ( $row );

      // Calculo el total
      $total = 0;
        
      while ($dato = $row->fetch_assoc()) {
        $total += $dato['importe'];
      }

      If ($total != 0)
      {

        $cHtml .= '<table class="table table-sm">
        <thead class="thead-light">
          <tr>
            <th scope="col">Número</th>
            <th scope="col">Fecha</th>
            <th scope="col">Vencimiento</th>
            <th scope="col">Importe</th>
          </tr>
        </thead>
        <tbody>';

        $row = "SELECT serie,numero,libramiento AS fecha,vencimiento,importependiente AS importe FROM usuarios_recibospendientes WHERE codigoclientevisionwin=". $data["codigo"];
        $row = $con->get_Cursor ( $row );

        while ($dato = $row->fetch_assoc()) { 
          $cHtml .= '<tr>';
          $cHtml .= '<td class="text-right">';
          $cHtml .= $dato['serie'].'-'.$dato['numero'];
          $cHtml .= '</td>';
          $cHtml .= '<td>';
          $cHtml .= date('d-m-Y', strtotime($dato['fecha']));
          $cHtml .= '</td>';
          $cHtml .= '<td>';
          $cHtml .= date('d-m-Y', strtotime($dato['vencimiento']));
          $cHtml .= '</td>';
          $cHtml .= '<td class="text-right">';
          $cHtml .= $dato['importe'].'€';
          $cHtml .= '</td>';
          $cHtml .= '</tr>';

          $pagoFactura->total = $pagoFactura->total + $dato['importe'];
          $pagoFactura->facturas = $dato['serie'].$dato['numero'].' ';
        }
        $cHtml .= '</tbody>';
        $cHtml .= '</table>';
        $cHtml .= '<div class="h4">';
        $cHtml .= 'Total : <b>'.$pagoFactura->total.'€</b>';
        $cHtml .= '</div>';

      }
    }

  $pagoFactura->html = $cHtml;

  $pagoFactura = json_encode($pagoFactura);
  echo $pagoFactura;

}

?>

