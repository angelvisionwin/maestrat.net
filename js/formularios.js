var oDatosFactura = {
    cliente: 0,
    cif: '',
    total: 0,
    facturas: ''
}

function desactivasubmit(formulario) {
    'use strict';

    var hazValidacion = "SI";

    // Recoge todos los formularios del documento que estén marcados como 'needs-validation'
    var forms = document.getElementsByClassName('needs-validation');

    // Recorre los formularios y evita que se envíen con submit
    var validation = Array.prototype.filter.call(forms, function (form) {

        form.addEventListener('submit', function (event) {

            // Evita que se acabe de procesar el envío de formulario y la recarga de la página
            event.preventDefault();
            event.stopPropagation();

            if (formulario == "formulariopedidonuevo") {

                if ($('select[id="selectgestionlocal"]').val() == 0 && $('select[id="selectcontabilidadlocal"]').val() == 0 &&
                    $('select[id="selectgestionnube"]').val() == 0 && $('select[id="selectcontabilidadnube"]').val() == 0 &&
                    !$("#formcopias").is(":checked")) {

                    $("#modalNoHayProducto").modal('show');
                    hazValidacion = "NO";
                } else {
                    hazValidacion = "SI";
                }
            }

            if (hazValidacion == "SI") {
                if (form.checkValidity() === true) {
                    procesaformulario(formulario);
                }

                form.classList.add('was-validated');
            }

        }, false);
    });

}

function procesaformulario(formulario) {
    'use strict';

    var url,
        cData,
        obj;

    switch (formulario) {
        case 'formulariocontacto':

            if (paisPermitido() === false) {
                $("#modalPaisNoPermitido").modal('show');
                return;
            }


            $("#enviarboton").prop("disabled", true);
            $("#enviarboton").html("Enviando formulario, por favor espera...");
            url = "php/procesacontacto.php";
            cData = $("#formulariocontacto").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $('#tituloformulario').hide();
                    $('#contenedorformulario').hide();
                    $('#exito1').html(cHtml);
                    $('#exito').show();
                    window.scrollTo(0, 350);

                }
            });
            break;

        case 'formularioregistro':

            if (paisPermitido() === false) {
                $("#modalPaisNoPermitido").modal('show');
                return;
            }


            url = "php/procesaregistro.php";
            cData = $("#formularioregistro").serialize();
            $("#enviarboton").prop("disabled", true);
            $("#enviarboton").html("Enviando formulario, por favor espera...");
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $('#textoregistro').hide();
                    $('#tituloformulario').hide();
                    $('#contenedorformulario').hide();
                    $('#exito1').html(cHtml);
                    $('#exito').show();
                    window.scrollTo(0, 350);

                }
            });
            break;

        case 'formularionube':
            url = "php/procesanube.php";
            cData = $("#formularionube").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $('#caracteristicas-nube').hide();
                    $('#tituloformulario').hide();
                    $('#contenedorformulario').hide();
                    $('#exito1').html(cHtml);
                    $('#exito').show();
                    window.scrollTo(0, 350);

                }
            });
            break;

        case 'formulariodistribucion':
            url = "php/procesadistribucion.php";
            cData = $("#formulariodistribucion").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $('#caracteristicas-distribucion').hide();
                    $('#tituloformulario').hide();
                    $('#contenedorformulario').hide();
                    $('#exito1').html(cHtml);
                    $('#exito').show();
                    window.scrollTo(0, 350);

                }
            });
            break;
        case 'formulariopedidonuevo':
            $("#modalResumenPedido").modal('show');
            break;

        case 'distribucion':
            break;

        case 'formulariodescarga':

            url = "php/procesadescarga.php";
            cData = $("#formulariodescarga").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $('#modalCompleta').modal('hide');
                    $('#modalDescargaText').html(cHtml);
                    $('#modalCompletaExito').modal('show');
                }
            });
            break;

        case 'formulariobaja':
            url = "php/procesabaja.php";
            cData = $("#formulariobaja").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $('#contenedorformulario').hide();
                    $('#exito1').html(cHtml);
                    $('#exito').show();
                }
            });
            break;

        case 'formulariosugerencias':
            url = "php/procesasugerencias.php";
            cData = $("#formulariosugerencias").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $("#modalformulario").modal('hide');
                    $("#modalexito").modal('show');
                }
            });
            break;

        case 'formulariovotos':
            url = "php/procesavotos.php";
            cData = $("#formulariovotos").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: cData,
                success: function (cHtml) {
                    $("#modalformulariovotos").modal('hide');
                    $("#modalexitovotostexto").html(cHtml);
                    $("#modalexitovotos").modal('show');
                }
            });
            break;

        case 'formulariopagofactura':
            url = "php/procesapagarfactura.php";
            obj = form2json("formulariopagofactura");
            $.ajax({
                url: url,
                type: "POST",
                data: JSON.stringify(obj),
                success: function (oData) {
                    var myObj = jQuery.parseJSON(oData);

                    oDatosFactura.cliente = myObj.cliente;
                    oDatosFactura.cif = myObj.cif;
                    oDatosFactura.total = myObj.total;
                    oDatosFactura.facturas = myObj.facturas;

                    $("#modalPendientesTexto").html(myObj.html);
                    if (myObj.cliente != 0) {
                        $("#modalPendientes").modal('show');
                    } else {
                        $("#modalClienteNoEncontrado").modal('show');
                    }
                }
            });
            break;

    }
}

// Esta función se encargar de transformar el formulario a un archivo json
function form2json(formID) {
    // Obtenemos el objeto DOM del formulario
    var form = document.getElementById(formID);

    // Obtenemos un objeto que contiene los campos del formulario, usando la función de Jquery "serializeArray"
    // y luego los transformo en un objeto en el que los atributos "name" de cada campo del formulario pasan a 
    // ser las claves del objeto; y los "value" los valores.
    var serializedForm = $(form).serializeArray().reduce(function (result, field) {
        if (result.hasOwnProperty(field.name)) {
            if (Array.isArray(result[field.name])) {
                result[field.name].push(field.value);
            } else {
                result[field.name] = [result[field.name], field.value];
            }
        } else {
            result[field.name] = field.value;
        }
        return result;
    }, {});

    // Devuelvo el resultado
    return serializedForm;
}


function sleep(ms) {
    return new Promise(res => setTimeout(res, ms));
}
