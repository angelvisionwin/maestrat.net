function pagarFactura() {

  var cHtml = '';

  // Ajusto los textos del modal de pago.
  cHtml = '<h5>Importe a pagar : ';
  cHtml += oDatosFactura.total + '€';
  cHtml += '</h5>';

  $("#modalPagarFacturaTexto").html (cHtml);

  $("#modalPendientes").modal('hide');
  $("#modalPagarFactura").modal('show');
}

function pagarFacturaTarjeta() {
  'use strict';

  var url,
      cData;

  url = "php/pagarfacturatarjeta.php";
  cData = {
      "cliente": oDatosFactura.cliente,
      "cif": oDatosFactura.cif,
      "importe": oDatosFactura.total,
      "facturas": oDatosFactura.facturas
  };

  $.ajax(
    {
        url: url,
        type: "POST",
        data: JSON.stringify(cData),
        contentType: "application/json", 
        success: function (cHtml) {
          $("#modalPagarFacturaTextoFormulario").html (cHtml);
          $("#botonPagaFacturaTarjeta").click();
        }
    });

}

function pagarFacturaPaypal() {
  'use strict';

  var url,
      cData;

  url = "php/pagarfacturapaypal.php";
  cData = {
      "cliente": oDatosFactura.cliente,
      "cif": oDatosFactura.cif,
      "importe": oDatosFactura.total,
      "facturas": oDatosFactura.facturas
  };

  $.ajax(
    {
        url: url,
        type: "POST",
        data: JSON.stringify(cData),
        contentType: "application/json", 
        success: function (cHtml) {
          $("#modalPagarFacturaTextoFormulario").html (cHtml);
          $("#botonPagaFacturaPaypal").click();
        }
    });

}

function pagarFacturaRecibo() {
  'use strict';

  $("#modalPagarFactura").modal('hide');
  $("#modalDatosBancarios").modal('show');

}

function facturaPonControlIBAN() {

  var IBAN = document.getElementById("IBAN");
  IBAN.addEventListener("keyup", function (event) {
      if (validaIBAN(IBAN.value) == true) {
          IBAN.setCustomValidity("");
      } else {
          IBAN.setCustomValidity("Por favor, introduzca un IBAN válido sin espacios");
      }
  });
}

function pagarFacturaEnviaIBAN(){ 

}
