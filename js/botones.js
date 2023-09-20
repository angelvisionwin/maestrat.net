// Funciones de ayuda para precios y contratar-soporte
// Muestra y oculta local y nube y cambia el estado de los botones

let btnactivo = "local"; // Lo usaré en contratarsoporte

function alternabotones(cQue,lpedido) {

    let btnlocal = $('#botonlocal'); 
    let btnnube = $('#botonnube');

    switch (cQue) {
        case "local":
            btnlocal.removeClass('btn-outline-primary');
            btnlocal.addClass('btn-primary');

            btnnube.removeClass('btn-primary');
            btnnube.addClass('btn-outline-primary');

            $("#enlocal").show();
            $("#enlanube").hide();

            btnactivo="local";

            break;
        case "nube":
            btnlocal.removeClass('btn-primary');
            btnlocal.addClass('btn-outline-primary');

            btnnube.removeClass('btn-outline-primary');
            btnnube.addClass('btn-primary');

            $("#enlocal").hide();
            $("#enlanube").show();

            btnactivo="nube";

            break;
        default:
    }

    // Si se trata de un pedido, al alternar de botones tengo que inicializar 
    // totales, collapses, etc.
    if (lpedido === true){
        // Escondo el botón de pago mensual si no es "EN LA NUBE"
        if (cQue==="local"){
            $("#pagarmensualmente").collapse("hide");
        } else{
            $("#pagarmensualmente").collapse("show");
        }
        inicializa_totales();
    }
}

