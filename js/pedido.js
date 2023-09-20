// Funciones de apoyo para contratar-soporte
'use strict';

var oTotales = {
    usuariosnube: {
        gestion: 1,
        contabilidad: 1
    },
    soporte: {
        "gestionlocal": 0,
        "contabilidadlocal": 0,
        "gestionnube": 0,
        "contabilidadnube": 0,
        "copias": 0,
    },
    pedido: {
        formapago: "tarjeta", // La forma de pago por defecto
        periodicidad: 1, // 1 - Anual, 10 - Mensual (en el anual se ahorran dos meses)
        bruto: 0,
        descuento: 0,
        recargo: 0,
        base: 0,
        ivapor: 21,
        ivaimp: 0,
        exento: "no",
        total: 0,
        cuponnombre: "",
        cupondescuento: 0,
        ivafijo: 21
    }
}

var asoportes = [
    "Servicio de actualizaciones",
    "Soporte básico",
    "Soporte profesional"
]

var anombres = [
    "Actualizaciones del programa",
    "Consultas por correo y chat",
    "Soporte telefónico",
    "Conexión remota con los técnicos",
    "Acceso al portal de usuarios",
    "Acceso a la base de conocimientos",
    "Acceso al sistema de tickets personalizado"
];

// Inicializa los totales y acumulados del pedido, se usa cuando se alternan
// los botones de "LOCAL" y "NUBE"

function inicializa_totales() { 

    oTotales.usuariosnube.gestion = 1;
    oTotales.usuariosnube.contabilidad = 1;
    oTotales.soporte["gestionlocal"] = 0;
    oTotales.soporte["contabilidadlocal"] = 0;
    oTotales.soporte["gestionnube"] = 0;
    oTotales.soporte["contabilidadnube"] = 0;
    oTotales.soporte["copias"] = 0;
    oTotales.pedido.periodicidad = 1;
    oTotales.pedido.cuponnombre = "";
    oTotales.pedido.cupondescuento = 0;
    oTotales.pedido.ivafijo = 21;

    $("#rangogestionnube").val(1);
    $("#rangogestionnube").change(); // Fuerza el refresco
    $("#rangocontabilidadnube").val(1);
    $("#rangocontabilidadnube").change(); // Fuerza el refesco

    // Por si hay algún cupón, dejo el texto en blanco
    $("#codigocupon").val("");

    // Por si está marcada la copia
    $("#formcopias").prop("checked", false);
    //$("#formcopias").change();  // Fuerza el refesco

    // Incializa todos los selects, totales, etc
    $.each(oTotales.soporte, function (cprograma, item) {
        $('select[id="' + "select" + cprograma + '"]').val(0);
        muestra_opciones_producto(cprograma);
    });


}

// Proceso cada vez que se elige una opción en el desplegable de cada progarma
function muestra_opciones_producto(cprograma) {

    var item = $('select[id="' + "select" + cprograma + '"]').val();
    var ncuota = 0;
    var activos;

    // Actualiza las funciones activas o no de cada soporte
    activos = opciones_actualiza_sino(item, cprograma);

    // Carga el html adecuado según las funciones activas
    opciones_carga_html(activos, cprograma);

    // Muestra u oculta cada panel según el programa seleccionado
    opciones_colapsa(cprograma, item);

    // Actualizo la tarifa y los soportes contratados
    ncuota = calcula_cuota(cprograma, item);
    pinta_cuota(cprograma, ncuota);

    // Muestra u oculta el recuadro de la cuota
    colapsa_cuota(cprograma, ncuota, item);

    // Controlo si debo mostrar los selectores de usuarios
    usuarios_selectores(cprograma, item);

    // Actualizo el resumen del pedido
    actualiza_resumen_pedido(ncuota);

    // Calcula los totales del pedido
    calcula_totales_pedido();

    // Carga los valores en los INPUT de los totales
    pinta_totales_pedido();

}

// Actualiza los checks activos en función del item que se ha seleccionado
function opciones_actualiza_sino(item, cprograma) {
    // Actualizaciones
    // Chat y correo
    // Teléfono
    // Conexión remota
    // Acceso al portal de usuarios
    // Acceso a la base de conocimientos
    // Acceso al sistema de tickets personalizado

    var activos = ["no", "no", "no", "no", "no", "no", "no"];
    switch (item) {
        case "0": // nada
            break;

        case "1": // actualizaciones

            activos[0] = "si";
            break;

        case "2": // básico
            activos[0] = "si";
            activos[1] = "si";
            activos[4] = "si";
            activos[5] = "si";
            activos[6] = "si";

            break;


        case "3": // profesional
            activos[0] = "si";
            activos[1] = "si";
            activos[2] = "si";
            activos[3] = "si";
            activos[4] = "si";
            activos[5] = "si";
            activos[6] = "si";

            break;

        default:
    }

    return activos;
}

// Carga las opciones de cada producto y actualiza el HTML en función de las activas
function opciones_carga_html(activos, cprograma) {
    var ccadena = "";
    var ncontador = 0;

    ccadena = "<div class='col-md h5'>";
    ccadena += "El soporte que has seleccionado incluye :";
    ccadena += "</div>";
    ccadena += "<div class='row p-2'>";

    $.each(activos, function (ind, elem) {

        if (ncontador == 0 || ncontador == 4) {
            ccadena += "<div class='sino col-md-4 bg-white'>";
        }

        ccadena += "<p><i class='fa "

        if (elem === "no") {
            ccadena += "fa-times"
        } else {
            ccadena += "fa-check"
        }
        ccadena += " pr-2' style='width:24px;' title='No' alt='No'></i>";
        ccadena += "" + anombres[ind] + "</p>";
        ncontador++;

        if (ncontador == 4) {
            ccadena += "</div>";
        }
    });
    ccadena += "</div>";
    ccadena += "</div>";
    $("#opcionesregistro" + cprograma).html(ccadena);
}

// Muestro u oculto las opciones que cubren cada soporte
function opciones_colapsa(cprograma, item, lfuerzaocultar) {
    if (item > 0 && !lfuerzaocultar) {
        $("#opcionesregistro" + cprograma).collapse("show");
    } else {
        $("#opcionesregistro" + cprograma).collapse("hide");
    }
}

// Calcula la cuota en funcion de cprograma y el item seleccionado
function calcula_cuota(cprograma, item) {
    var ncuota = 0;

    ncuota = oPrecios[cprograma][item];

    if (ncuota != 0 && cprograma === "gestionnube") {
        ncuota += (oPrecios["usuarioextra"] * (oTotales.usuariosnube.gestion - 1))
    }

    if (ncuota != 0 && cprograma === "contabilidadnube") {
        ncuota += (oPrecios["usuarioextra"] * (oTotales.usuariosnube.contabilidad - 1))
    }

    if (isNaN(ncuota)) {

        ncuota = 0;
    }

    return ncuota;
}

// Carga en el html del recuadro de las cuotas el precio correspondiente
function pinta_cuota(cprograma, ncuota) {

    // Esto lo hago así porque en el apartado de la nube la tarifa se muestra de forma diferente
    if (cprograma === "gestionlocal" || cprograma === "contabilidadlocal") {
        $("#cuotaregistro" + cprograma).html("Cuota anual : " + ncuota + "€");
    } else {
        $("#precioanualregistro" + cprograma).html(ncuota);
        $("#preciomensualregistro" + cprograma).html(ncuota / 10);
    }
}

// Muestra u oculta el recuadro de las cuotas
function colapsa_cuota(cprograma, ncuota, item) {
    if (ncuota === 0) {
        $("#cuotaregistro" + cprograma).collapse("hide");
        oTotales.soporte[cprograma] = 0;
    } else {
        $("#cuotaregistro" + cprograma).collapse("show");
        oTotales.soporte[cprograma] = item;
    }
}

// Controla si debo mostrar los selectores de usuarios
function usuarios_selectores(cprograma, item) {
    if (cprograma === "gestionnube" || cprograma == "contabilidadnube") {
        if (item > 0) {
            $("#selectorusuarios" + cprograma).collapse("show");
        } else {
            $("#selectorusuarios" + cprograma).collapse("hide");
        }
    }
}

// Revisa los rangos de usuarios en función de los selectores de cada programa
function pedido_mirarangos(cRango) {
    let nValor = $("#" + cRango).val();
    let oUsuarios;
    let cprograma
    let item;

    switch (cRango) {
        case 'rangogestionnube':
            oUsuarios = 'usuariosgestionnube';
            oTotales.usuariosnube.gestion = nValor;

            break;

        case 'rangocontabilidadnube':
            oUsuarios = 'usuarioscontabilidadnube';
            oTotales.usuariosnube.contabilidad = nValor;

            break;
    }
    // Actualizo el nº de usuarios
    $("#" + oUsuarios).text(nValor);

    // Actualizo la cuota
    cprograma = cRango.slice(5, 99);
    item = $('select[id="' + "select" + cprograma + '"]').val();
    pinta_cuota(cprograma, calcula_cuota(cprograma, item));

    // Actualizo el resumen del pedido
    actualiza_resumen_pedido();

    // Calcula los totales del pedido
    calcula_totales_pedido();

    // Carga los valores en los INPUT de los totales
    pinta_totales_pedido();

}


// Actualiza el resumen del pedido en función de oTotales
function actualiza_resumen_pedido() {
    var cdetalle = "";
    var cdetalleprecio = "";
    var ntemp = 0;

    if (oTotales.soporte["gestionlocal"] != 0) {
        cdetalle += "<p><b>1 x Visionwin Gestion (instalación local)</b><br>";
        cdetalle += " - " + asoportes[oTotales.soporte["gestionlocal"] - 1] + "<br>";
        cdetalle += "</p>";

        cdetalleprecio += "<p>" + oPrecios["gestionlocal"][oTotales.soporte["gestionlocal"]] + "€ al año<br/><br/></p>"
    }

    if (oTotales.soporte["contabilidadlocal"] != 0) {
        cdetalle += "<p><b>1 x Visionwin Contabilidad (instalación local)</b><br>";
        cdetalle += " - " + asoportes[oTotales.soporte["contabilidadlocal"] - 1] + "<br>";
        cdetalle += "</p>";

        cdetalleprecio += "<p>" + oPrecios["contabilidadlocal"][oTotales.soporte["contabilidadlocal"]] + "€ al año<br/><br/></p>"
    }

    if (oTotales.soporte["copias"] == 1) {

        cdetalle += "<p><b>1 x Copias en servidor seguro</b><br>";
        cdetalle += "</p>";

        cdetalleprecio += "<p>" + oPrecios["copias"]["1"] + "€ al año<br/><br/></p>"
    }

    if (oTotales.soporte["gestionnube"] != 0) {
        cdetalle += "<p><b>1 x Visionwin Gestion (en la nube)</b><br>";
        cdetalle += " - " + asoportes[oTotales.soporte["gestionnube"] - 1] + " : " + oTotales.usuariosnube.gestion + " Usuarios<br>";
        cdetalle += "</p>";

        ntemp = calcula_cuota("gestionnube", oTotales.soporte["gestionnube"]);
        if (oTotales.pedido.periodicidad === 1) {
            cdetalleprecio += "<p>" + ntemp + "€ al año<br/><small>¡Ahorra dos meses!</small><br/>";
        } else {
            cdetalleprecio += ntemp / 10 + "€ al mes<br/><br/></p>";
        }
    }

    if (oTotales.soporte["contabilidadnube"] != 0) {
        cdetalle += "<p><b>1 x Visionwin Contabilidad (en la nube)</b><br>";
        cdetalle += " - " + asoportes[oTotales.soporte["contabilidadnube"] - 1] + " : " + oTotales.usuariosnube.contabilidad + " Usuarios<br>";
        cdetalle += "</p>";

        ntemp = calcula_cuota("contabilidadnube", oTotales.soporte["contabilidadnube"]);
        if (oTotales.pedido.periodicidad === 1) {
            cdetalleprecio += "<p>" + ntemp + "€ al año<br/><small>¡Ahorra dos meses!</small><br/>";
        } else {
            cdetalleprecio += ntemp / 10 + "€ al mes<br/></p>";
        }
    }
    // Actualizo el resumen del pedido
    $("#resumenpedidotexto").html(cdetalle);
    $("#resumenpedidoprecio").html(cdetalleprecio);

    // Actualizo el resumen del pedido en el modal que se muestra al pulsar el botón de "revisar pedido"
    $("#resumenfinalpedidotexto").html(cdetalle);
    $("#resumenfinalpedidoprecio").html(cdetalleprecio);
}

// Controla el check de "pago mensual" 
function revisapagomensual() {
    if ($("#pagomensual").is(":checked")) {
        oTotales.pedido.periodicidad = 10;

        // En el pago mensual no acepto cupón
        oTotales.pedido.cuponnombre = "";
        oTotales.pedido.cupondescuento = 0;

        // En el pago mensual sólo se acepta recibo bancario
        $("#tarjeta").attr("disabled", true);
        $("#paypal").attr("disabled", true);
        $("#transferencia").attr("disabled", true);

        $("#tarjeta").attr("checked", false);
        $("#paypal").attr("checked", false);
        $("#transferencia").attr("checked", false);

        $("#recibo").click();
    } else {
        oTotales.pedido.periodicidad = 1;

        // No hay pago mensual, vuelvo a activar todas las formas de pago
        $("#tarjeta").attr("disabled", false);
        $("#paypal").attr("disabled", false);
        $("#transferencia").attr("disabled", false);
    }

    actualiza_resumen_pedido();
    calcula_totales_pedido();
    pinta_totales_pedido();
}

// Controla el check de "iva exento" 
function revisaivaexento() {
    if ($("#formivaexento").is(":checked")) {
        oTotales.pedido.ivapor = 0;
        oTotales.pedido.exento = "si";

    } else {
        oTotales.pedido.ivapor = oTotales.pedido.ivafijo;
        oTotales.pedido.exento = "no";
    }

    calcula_totales_pedido();
    pinta_totales_pedido();
}

// Controla el check de "copias en la nube" 
function revisacopias() {

    if ($("#formcopias").is(":checked")) {

        oTotales.soporte.copias = 1;

    } else {

        oTotales.soporte.copias = 0;

    }

    actualiza_resumen_pedido();
    calcula_totales_pedido();
    pinta_totales_pedido();
}


// Calcula los totales del pedido
function calcula_totales_pedido() {

    oTotales.pedido.bruto = 0;

    $.each(oTotales.soporte, function (cprograma, item) { 

        oTotales.pedido.bruto += calcula_cuota(cprograma, item);
    });

    oTotales.pedido.bruto = round(oTotales.pedido.bruto / oTotales.pedido.periodicidad, 2);
    oTotales.pedido.descuento = oTotales.pedido.cupondescuento;


    oTotales.pedido.base = oTotales.pedido.bruto - oTotales.pedido.descuento;
    oTotales.pedido.ivaimp = round((oTotales.pedido.base * oTotales.pedido.ivapor) / 100, 2);
    oTotales.pedido.total = round(oTotales.pedido.base + oTotales.pedido.ivaimp, 2);

    if (oTotales.pedido.formapago === "paypal") {
        // La comisión se calcula como el % sobre venta
        oTotales.pedido.recargo = round((oTotales.pedido.total / (1 - 0.034)) + 0.35, 2) - oTotales.pedido.total;
        oTotales.pedido.total += oTotales.pedido.recargo;
    } else {
        oTotales.pedido.recargo = 0;
    }

}

// Actualiza los INPUT de los totales del pedido
function pinta_totales_pedido() {

    var ctextos = "",
        cimportes = "";

    $("#formbruto").val(number_format(oTotales.pedido.bruto, 2) + "€");
    $("#formdescuento").val(oTotales.pedido.descuento + "€");
    $("#formbase").val(number_format(oTotales.pedido.base, 2) + "€");
    $("#formivapor").val(oTotales.pedido.ivapor + "%");
    $("#formivaimp").val(number_format(oTotales.pedido.ivaimp, 2) + "€");
    $("#formrecargo").val(number_format(oTotales.pedido.recargo, 2) + "€");
    $("#formtotal").val(number_format(oTotales.pedido.total, 2) + "€");


    // Actualizo los textos del resumen modal del pedido

    ctextos += "Importe bruto : <br/>";
    cimportes += number_format(oTotales.pedido.bruto, 2) + "€<br/>";

    if (oTotales.pedido.descuento != 0) {
        ctextos += "Descuentos aplicados :<br/>";
        cimportes += oTotales.pedido.descuento + "€<br/>";
    }

    ctextos += "Base imponible :<br/>";
    cimportes += number_format(oTotales.pedido.base, 2) + "€<br/>";

    ctextos += "Iva (" + oTotales.pedido.ivapor + "%) :<br/>";
    cimportes += number_format(oTotales.pedido.ivaimp, 2) + "€<br/>";

    // Si hay recargo lo actualizo en el model de resumen
    if (oTotales.pedido.recargo != 0) {
        ctextos += "Subtotal antes de recargo : <br/>";
        cimportes += number_format(oTotales.pedido.base + oTotales.pedido.ivaimp, 2) + "€<br/>";
        ctextos += "Recargo Paypal :<br/>";
        cimportes += number_format(oTotales.pedido.recargo, 2) + "€<br/>";
    }

    ctextos += "<b>TOTAL PEDIDO : </b><br/>";
    cimportes += "<b>" + number_format(oTotales.pedido.total, 2) + "€</b><br/>";

    ctextos += "Forma de pago : ";
    cimportes += oTotales.pedido.formapago;

    $("#resumenfinaltotalestextos").html(ctextos);
    $("#resumenfinaltotalesimportes").html(cimportes);

}

// Comprueba y aplica el cupón necesario
function pedidoAplicaCupon() {

    var codigocupon = $("#codigocupon").val().toUpperCase();

    if (codigocupon != "OFERTA15") {
    
        $("#modalNoCuponBody").html('Cupón inválido');
        $("#modalNoCupon").modal('show');
        oTotales.pedido.cuponnombre = "";
        oTotales.pedido.cupondescuento = 0;

        return false;
    }

    if (oTotales.pedido.bruto === 0) {
        $("#modalNoCuponBody").html("No es posible aplicar un cupón de descuento a un pedido vacío");
        $("#modalNoCupon").modal('show');
        oTotales.pedido.cuponnombre = "";
        oTotales.pedido.cupondescuento = 0;

        return false;
    }

    if (oTotales.pedido.periodicidad != 1) {
        $("#modalNoCuponBody").html("En la modalidad de pago mensual no se puede aplicar este cupón de descuento");
        $("#modalNoCupon").modal('show');
        oTotales.pedido.cuponnombre = "";
        oTotales.pedido.cupondescuento = 0;

        return false;
    }

    if (oTotales.soporte["copias"] != 0 && oTotales.pedido.total < 100 ) {
        $("#modalNoCuponBody").html("No se pueden aplicar cupones a las copias de seguridad");
        $("#modalNoCupon").modal('show');
        oTotales.pedido.cuponnombre = "";
        oTotales.pedido.cupondescuento = 0;

        return false;
    }
 

    if (codigocupon.toUpperCase() === "OFERTA15") {
        oTotales.pedido.cuponnombre = "OFERTA15";
        oTotales.pedido.cupondescuento = 15;
    }


    // Recalculo los totales
    calcula_totales_pedido();

    // Repinto los totales
    pinta_totales_pedido();

}

// Ajusta valores cada vez que se cambia la forma de pago
function clickformadepago(ccual) {

    pedidoOcultaIBAN();
    $('#pistatarjeta').hide();
    $('#pistapaypal').hide();
    $('#pistatransferencia').hide();
    $('#pistarecibo').hide();

    $('#pista' + ccual).show();

    if (ccual === 'recibo') {
        pedidoMuestraIBAN();
    }

    // Guardo la forma de pago seleccionada en oTotales
    oTotales.pedido.formapago = ccual;

    // Actualizo totales, ya que según la forma de pago pueden haber recargos
    calcula_totales_pedido();
    pinta_totales_pedido();
}


// Finaliza el pedido
function finalizarPedido() {

    var url,
        obj

    // Crea un json con todos los campos del formulario de pedido 
    obj = form2json("formulariopedidonuevo");

    // Añado los datos de oTotales
    obj["totales"] = oTotales;


    // Aquí iría bien un spinner animado mientras se almacena el pedido
    $("#modalResumenPedido").modal('hide');

    url = "php/procesapedido.php";

    $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(obj),
        contentType: "application/json",
        success: function (cHtml) {
            $("#pedidograbadotexto").html(cHtml);
        }
    });

    $("#contenedorformulario").hide();
    $("#pedidograbado").collapse("show");

    // Muestro información de la forma de pago según la seleccionada
    // Recorto mucho código con la concatenación de la cadena

    $("#pedidograbadopagopor" + oTotales.pedido.formapago).collapse("show");
    window.scrollTo(0, 0);

}

function nuevopedidoPagarPaypal() {
    'use strict';

    var cPedido,
        cData,
        url

    // Se obtiene el número de pedido del texto que se muestra tras grabarlo , si se modifica el texto
    // o las posiciones hay que revisarlo aquí

    cPedido = document.getElementById("pedidograbadotexto").innerHTML;
    cPedido = trim(cPedido.substr(30, 6));

    url = "php/pagopaypal.php";

    cData = {
        "pedido": cPedido,
        "token": "9987jazzkdklr_"
    };

    $.ajax({
        type: "POST",
        url: url,
        data: cData,
        success: function (cHtml) {
            document.getElementById("pedidograbadopagoporpaypal").innerHTML = cHtml;
            $("#modalProcesandoPago").modal('show');
            $("#botonenviaformulariopaypal").click();
        }
    });
}

function nuevopedidoPagarTarjeta() {
    'use strict';

    var cPedido,
        cData,
        url

    // Se obtiene el número de pedido del texto que se muestra tras grabarlo , si se modifica el texto
    // o las posiciones hay que revisarlo aquí

    cPedido = document.getElementById("pedidograbadotexto").innerHTML;
    cPedido = trim(cPedido.substr(30, 6));

    url = "php/pagotarjeta.php";

    cData = {
        "pedido": cPedido,
        "token": "9987jazzkdklr_"
    };

    $.ajax({
        type: "POST",
        url: url,
        data: cData,
        success: function (cHtml) {
            document.getElementById("pedidograbadopagoportarjeta").innerHTML = cHtml;
            $("#modalProcesandoPago").modal('show');
            $("#botonenviaformulariotarjeta").click();
        }
    });

}


// ------------ Funciones auxiliares para el formulario ----------------- //
function pedidoPonControlIBAN() {

    var IBAN = document.getElementById("IBAN");
    IBAN.addEventListener("keyup", function (event) {
        if (validaIBAN(IBAN.value) == true) {
            IBAN.setCustomValidity("");
        } else {
            IBAN.setCustomValidity("Por favor, introduzca un IBAN válido sin espacios");
        }
    });
}

function pedidoPonControlNIF() {

    var NIF = document.getElementById("NIF");
    NIF.addEventListener("keyup", function (event) {
        if (CIFCorrecto(NIF.value) == true || DNICorrecto(NIF.value) == true) {
            NIF.setCustomValidity("");
        } else {
            NIF.setCustomValidity("Por favor, introduzca un DNI o NIF válido");
        }
    });
}

function pedidoMuestraIBAN() {
    $("#textoiban").collapse("show");
    $('#IBAN').prop('required', true);
}

function pedidoOcultaIBAN() {
    $("#textoiban").collapse("hide");
    $('#IBAN').prop('required', false);
}
