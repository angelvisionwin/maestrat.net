<?php 

    require_once( 'no-cache.php' );

    $pagetitle = "Descargas - Visionwin";
    $pagedescription = "Descarga el software gratuito Visionwin: Visionwin Contabilidad, Visionwin Gestión o Visionwin TPV.";
    $pagekeywords = "descarga software contabilidad, descarga software gestion, descarga software tpv";
    $formulario = "formulariodescarga";
    $recaptcha = true;

    require_once( 'cabecera.php' ); 

?>    

    <!-- Contenido ==================================================================== -->
    
    <!-- Barra de título después del menú-->
    <div class="container-fluid fondo-cabecera">
        <h1 class="texto-cabecera">Descarga ahora el software gratuito Visionwin</h1>
    </div>


    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md">
                <h2>Zona de descargas</h2>
            </div>
        </div>

        <div class="card-deck mb-4">
            <div class="card panel-no-padding">
                <img class="card-img-top" src="img/visionwin-contabilidad.webp" alt="Visionwin Contabiliad">
                <div class="card-body">
                    <h3 class="card-title">Visionwin Contabilidad</h3>
                    <!--    <p class="card-text">Programa de contabilidad orientado a las PYMES, de uso muy intuitivo y totalmente configurado para empezar a trabajar en cinco minutos.</p>-->
                    <p class="text-muted">Versión 2023 rev 5.0</p>
                </div>
                <div class="card-footer">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary"
                        onclick="actualizatextocompleta('Contabilidad');">Versión Completa</a>
                    <a href="#" data-toggle="modal" data-target="#modalActualizacionContabilidad"
                        class="btn btn-warning">Actualización</a>
                </div>
            </div>
            <div class="card panel-no-padding">
                <img class="card-img-top" src="img/visionwin-gestion.webp" alt="Visionwin Gestión">
                <div class="card-body">
                    <h3 class="card-title">Visionwin Gestión</h3>
                    <!--  <p class="card-text">Programa que engloba todas las necesidades de gestión de la PYME. Rápida instalación y fácil manejo mediante una interfaz muy íntuitiva y gráfica.</p> -->
                    <p class="text-muted">Versión 2023 rev 5.0</p>
                </div>
                <div class="card-footer">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary"
                        onclick="actualizatextocompleta('Gestión');">Versión Completa</a>
                    <a href="#" data-toggle="modal" data-target="#modalActualizacionGestion"
                        class="btn btn-warning">Actualización</a>
                </div>
            </div>
            <div class="card panel-no-padding">
                <img class="card-img-top" src="img/visionwin-tpv.webp" alt="Visionwin TPV">
                <div class="card-body">
                    <h3 class="card-title">Visionwin TPV</h3>
                    <!-- <p class="card-text">Terminal punto de venta para cualquier tipo de comercio. Perfectamente adaptado a terminales táctiles. Facilidad de uso, fiabilidad y rapidez son sus características principales.</p>-->
                    <p class="text-muted">Versión 2023 rev 5.0</p>
                </div>
                <div class="card-footer">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary"
                        onclick="actualizatextocompleta('TPV');">Versión Completa</a>
                    <a href="#" data-toggle="modal" data-target="#modalActualizacionGestion"
                        class="btn btn-warning">Actualización</a>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-md">
                <h2>Versiones de Visionwin preconfiguradas</h2>
            </div>
        </div>

        <div class="panel-resaltado mb-4 mt-2">
            <div class="row mb-2">

                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Despachos');">Despachos</a>
                </div>
                <div class="col-md-9">
                    Programa de facturación de despachos profesionales, abogados, arquitectos, etc.
                    <hr>
                </div>

                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Estética');">Estetica</a>
                </div>
                <div class="col-md-9">
                    El TPV ideal si tu negocio forma parte del mundo de la estética como peluquerías, centros de estética, spa, Salón de Uñas
                    <hr>
                </div>


                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Ropa y Calzado');">Ropa y Calzado</a>
                </div>
                <div class="col-md-9">
                    TPV completo para Tienda de Ropa, Calzado y complementos con gestión de atributos Tallas y colores
                    <hr>
                </div>

            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Quioscos');">Quioscos</a>
                </div>
                <div class="col-md-9">
                    TPV configurado para Quiosco de prensa, tiendas de chucherías, Regalos, Bazar …
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Librerías');">Librerías</a>
                </div>
                <div class="col-md-9">
                    Programa para gestión de Librerías con integración SINLI (Sistema de Información Normalizada para el
                    Libro) y opción de TPV
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Bar, Cafetería');">Bar, Cafetería</a>
                </div>
                <div class="col-md-9">
                    TPV para Bares, Cafeterías, Cervecerías y negocios de hostelería incluyendo control de Mesas e
                    impresoras de cocina
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Pub, Discoteca');">Pub, Discoteca</a>
                </div>
                <div class="col-md-9">
                    TPV para salas de fiesta, Pub's y Discotecas
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Panadería');">Panadería</a>
                </div>
                <div class="col-md-9">
                    Configuración específica para TPV's de Panaderías con gestión de mesas
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Heladería');">Heladería</a>
                </div>
                <div class="col-md-9">
                    TPV configurado para negocios de Heladería
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Pizzería');">Pizzería</a>
                </div>
                <div class="col-md-9">
                    Gestión para TPV's en pizzerías con configuración de atributos, ingredientes e impresoras de cocina
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('FastFood, Comida Rápida');">FastFood, Comida Rápida</a>
                </div>
                <div class="col-md-9">
                    TPV para negocios de restauración tipo Fast Food, con impresoras de cocina
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Restaurantes');">Restaurantes</a>
                </div>
                <div class="col-md-9">
                    TPV para Restaurantes con control de Menús diarios, gestión de mesas e impresoras de cocina
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Taller');">Taller</a>
                </div>
                <div class="col-md-9">
                    Programa para talleres mecánicos de electrodomésticos, ordenadores, telefonía y cualquier tipo de
                    reparación con control de mecánicos
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Taller de vehículos');">Taller de vehículos</a>
                </div>
                <div class="col-md-9">
                    Programa para talleres mecánicos de Coches, Camiones, Tractores, motocicletas, ... con control de
                    mecánicos y vehículos
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Representantes');">Representantes</a>
                </div>
                <div class="col-md-9">
                    Gestión de Representantes, Comisionistas, Comerciales... con cálculo de comisiones y liquidaciones
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Carpintería');">Carpintería</a>
                </div>
                <div class="col-md-9">
                    Configuración para Talleres de enmarcación, carpinteria, cristalería, puertas... con artículos
                    lineales, metros cuadrados, unitarios y goma
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Servicios');">Servicios</a>
                </div>
                <div class="col-md-9">
                    Programa para la facturación periódica de servicios como gestorías, asesorías, servicios de
                    mantenimiento, alquiler de maquinaria, limpieza, comunidades, ...
                    <hr>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#modalCompleta" class="btn btn-primary btn-block"
                        onclick="actualizatextocompleta('Registro horario');">Registro horario</a>
                </div>
                <div class="col-md-9">
                    Sencillo programa para controlar la jornada laboral de los empleados y cumplir con la normativa
                    laboral mediante un control de presencia.
                    <hr>
                </div>
            </div>
        </div>

        <div class="panel-resaltado">
            <p>Por favor, ten en cuenta que las versiones de actualización requieren un <a href="/contratar-soporte.html"
                    data-toggle="tooltip"
                    title="Cuando adquieres cualquier modalidad de soporte obtendras un código de cliente que te permitirá actualizar tu software"
                    class="text-danger">código de instalación</a> que se obtiene adquiriendo alguna de las modalidades
                de soporte disponible. Pásate por el apartado de <a href="/contratar-soporte.html"
                    class="font-weight-bold">Contratar Soporte</a> si aún
                no eres cliente.</p>
        </div>

    </div>

    <!-- Modal - Solicitud de correo para enviar la descarga -->
    <div class="modal fade" id="modalCompleta">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Cabecera -->
                <div class="modal-header">
                    <h4 class="modal-title text-info">
                        <div id="divCompleta"></div>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body panel-resaltado">
                    <h5>Descargar versión Completa</h5>
                    <p>Por favor introduce tu correo electrónico y Acepta nuestra política de privacidad para que
                        podamos enviarte el enlace de descarga.</p>
                    <!-- Formulario -->
                    <form class="needs-validation" novalidate name="formulariodescarga" id="formulariodescarga">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email">Email </label>
                                <input type="email" class="form-control" id="email" name="email" placeholder=""
                                    required>
                                <div class="invalid-feedback">
                                    Por favor introduce un correo válido para poder contactarte.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <br />
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="acepto" name="acepto" required>
                                    <label class="form-check-label" for="acepto">He leído y acepto la política de
                                        privacidad de Visionwin</label>
                                    <a href="#politica" class="small" data-toggle="collapse">(ver política de
                                        privacidad)</a>
                                    <div class="invalid-feedback">
                                        Debes aceptar para poder enviar el formulario.
                                    </div>

                                    <div id="politica" class="collapse text.muted" style="font-size:0.8rem;">
                                        <br> Debes aceptar el consentimiento para que podamos enviarte comunicados
                                        relacionados con el Software Visionwin. Estos comunicados pueden incluir
                                        promociones, noticias de nuevas versiones y mejoras en las aplicaciones.
                                        <br> Puedes revisar <a href="/politica-de-privacidad.html"
                                            class="text-info">nuestra política de privacidad</a> para más información.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- captcha -->
                        <div class="row mt-4">
                            <div class="col-md">

                                <div id="html_recaptcha"></div>

                            </div>
                        </div>


                        <input type="hidden" id="programa" name="programa" value="">

                        <hr class="mb-4">
                        <button class="btn btn-primary " type="submit">Solicitar la descarga</button>
                    </form>

                </div>

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Volver a Descargas</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal - Información de que se ha enviado correctamente el correo de la descarga -->
    <div class="modal fade" id="modalCompletaExito">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Cabecera -->
                <div class="modal-header">
                    <h4 class="modal-title text-info">Resultado</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body panel-resaltado">
                    <div id="modalDescargaText">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>




    <!-- Modal - Aviso descarga actualizacion con enlace descarga Contabilidad-->
    <div class="modal fade" id="modalActualizacionContabilidad">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Cabecera -->
                <div class="modal-header">
                    <h4 class="modal-title">Actualización Visionwin Contabilidad</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body panel-resaltado">
                    <p>Recuerda que para instalar una actualización debes ser cliente registrado.</p>
                    <p class="mb-4">Para completar el proceso de instalación se te solicitará tu código de cliente y tu
                        NIF, si no dispones de él será imposible continuar utilizando el programa.</p>
                    <a class="btn btn-primary" href="/descargas/updateconta.exe" role="button">Descargar
                        actualización</a>
                </div>

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Volver a Descargas</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal - Aviso descarga actualizacion con enlace descarga Gestión-->
    <div class="modal fade" id="modalActualizacionGestion">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Cabecera -->
                <div class="modal-header">
                    <h4 class="modal-title">Actualización Visionwin Gestión y TPV</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body panel-resaltado">
                    <p>Recuerda que para instalar una actualización debes ser cliente registrado.</p>
                    <p class="mb-4">Para completar el proceso de instalación se te solicitará tu código de cliente y tu
                        NIF, si no dispones de él será imposible continuar utilizando el programa.</p>
                    <a class="btn btn-primary" href="/descargas/updategestion.exe" role="button">Descargar
                        actualización</a>
                </div>

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Volver a Descargas</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function actualizatextocompleta(texto) {
            document.getElementById("divCompleta").innerHTML = "Visionwin " + texto;
            document.getElementById("programa").value = "Visionwin " + texto;
        }
    </script>

        
<?php

    require_once( 'pie.php' );

?> 

