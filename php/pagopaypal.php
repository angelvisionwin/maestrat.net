<?php

if (isset($_POST['token'])) 
{
    
    include_once 'class.Database.inc.php';
    
    $pedido = filter_input(INPUT_POST, 'pedido', FILTER_SANITIZE_NUMBER_INT);
    
    $con = new Database; 
    $row=$con->get_Row ("SELECT numero,total FROM pedidosvisionwin where numero='".$pedido."'");
     
    // Si se encuentra el pedido proceso la llamada a Paypal
    if ($row['numero']!=0){ 
        
        // inyecto el formulario 
        echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="info@sigev.com">
                <input type="hidden" name="item_name" value="Soporte Visionwin">
                <input type="hidden" name="order_id" value="Pedido :"'.$row['numero'].'">
                <input type="hidden" name="currency_code" value="EUR">
                <input type="hidden" name="amount" value="'.$row['total'].'">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="lc" value="ES">
                <input type="hidden" name="return" value="http://www.visionwin.com/pedidook.html">
                <input type="hidden" name="cancel_return" value="http://www.visionwin.com/pedidoko.html">
                <button class="btn btn-primary " type="submit" id="botonenviaformulariopaypal">Pagar ahora por Paypal</button>
            </form>';
	
    }
}
?>
