<?php 

    require_once( 'no-cache.php' );

    $pagetitle = "Contacto - Visionwin";
    $pagedescription = "PSi quieres realizar cualquier consulta puedes ponerte en contacto con nosotros y te responderemos lo antes posible.";
    $pagekeywords = "contacto visionwin, contacto sigev";

    require_once( 'cabecera.php' ); 

?>    


    <!-- Contenido ==================================================================== -->

    <!-- Imagen principal con jumbotron -->
    <div class="jumbotron jumbocontacto">
        <div class="container">
            <h1 class="display-4 text-white font-weight-bold">¿Alguna consulta?</h1>
            <p></p>
            <p class="lead text-white">Estaremos encantados de atender tus dudas, seguro que podemos ayudarte.</p>
        </div>
    </div>


    <div class="container">
        <div class="row" id="datos-contacto">
            <div class="col-md-3 u-ver-divider">
                <div class="text-center py-5">
                    <span class="fa fa-map-marker u-icon"></span>
                    <h2 class="h6 mb-0" style="font-weight:600;">Dirección</h2>
                    <p class="mb-0">C/ Galicia, 12 Edificio Vinalab <br> Vinaros - Castellón</p>
                </div>
            </div>
            <div class="col-md-3 u-ver-divider">
                <div class="text-center py-5">
                    <span class="fa fa-phone u-icon"></span>
                    <h2 class="h6 mb-0" style="font-weight:600;">Teléfono</h2>
                    <p class="mb-0">(+34) 964 455 551</p>
                </div>
            </div>

            <div class="col-md-3 u-ver-divider">
                <div class="text-center py-5">
                    <span class="fa fa-envelope u-icon"></span>
                    <h2 class="h6 mb-0" style="font-weight:600;">Email</h2>
                    <p class="mb-0">info@visionwin.com</p>
                </div>
            </div>

            <div class="col-md-3 u-ver-divider">
                <div class="text-center py-5">
                    <span class="fa fa-calendar u-icon"></span>
                    <h2 class="h6 mb-0" style="font-weight:600;">Horario</h2>
                    <p class="mb-0">Lunes a Jueves<br> 9:00 a 13:00 y 16:00 a 18:00<br> Viernes 9:00 a 13:00<br>
                    </p>
                    <a style="color:#377dff; text-decoration: none;" href="#" data-toggle="modal"
                        data-target="#modalFestivosLocales">Ver días festivos</a>

                </div>
            </div>
        </div>

        <!-- Modal - Festivos locales-->
        <div class="modal fade" id="modalFestivosLocales">
            <div class="modal-dialog modal-dialog-centered" style="min-width: 700px;">
                <div class="modal-content">

                    <!-- Cabecera -->
                    <div class="modal-header">
                        <h4 class="modal-title">Días festivos en Vinaròs - 2023</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <!-- Cuerpo -->
                    <div class="modal-body">
                        <ul>
                            <li>5 de Enero (Víspera de Reyes) <span style="color:#377dff">Horario reducido de 9:00 a
                                    13:00</span></li>
                            <li>6 de Enero (Epifanía del señor)</li>
                            <li>20 de Enero (San Sebastián, patrón de la ciudad)</li>
                            <li>7 de Abril (Viernes Santo)</li>
                            <li>10 de Abril (Lunes de Pascua)</li>
                            <li>1 de Mayo(Día del trabajador)</li>
                            <li>24 de Junio (San Juan)</li>
                            <li>29 de Junio (San Pedro)</li>
                            <li>15 de Agosto (Asunción de la Virgen)</li>
                            <li>9 de Octubre (Día de la Comunidad Valenciana)</li>
                            <li>12 de Octubre (Día de la hispanidad)</li>
                            <li>1 de Noviembre (Todos los Santos)</li>
                            <li>6 de Diciembre (Día de la constitución)</li>
                            <li>8 de Diciembre (La Inmaculada)</li>
                            <li>25 de Diciembre (Navidad)</li>
                        </ul>
                    </div>

                    <!-- Pie -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- Modal - País no permitido-->
        <div class="modal fade" id="modalPaisNoPermitido">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Cuerpo -->
                    <div class="modal-body">
                        <p>
                            Lo lamento, pero no podemos atender tu consulta desde tu país.<br>
                        </p>
                    </div>

                    <!-- Pie -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md" id="muestra">

                <div id="tituloformulario">
                    <h2>Formulario de contacto</h2>

                    <p class="mt-4">Si quieres realizar cualquier consulta puedes utilizar el siguiente formulario,
                        enviarnos un correo o llamarnos, sin compromiso.<br> <strong>Recuerda que sólo damos soporte en
                            España</strong><br><br></p>
                </div>
                <div class="container border p-4 bg-light" id="contenedorformulario">

                    <!-- Formulario -->
                    <form class="needs-validation" novalidate name="formulariocontacto" id="formulariocontacto">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    Se requiere un nombre válido.
                                </div>
                            </div>

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
                                <label for="consulta">Consulta</label>
                                <textarea class="form-control" rows="5" id="consulta" name="consulta" placeholder=""
                                    required></textarea>
                                <div class="invalid-feedback">
                                    Por favor introduce tu consulta.
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
                                    <a href="#politica" data-toggle="collapse"><b>(detalle)</b></a>
                                    <div class="invalid-feedback">
                                        Debes aceptar para poder enviar el formulario.
                                    </div>

                                    <div id="politica" class="collapse text.muted" style="font-size:0.8rem;">
                                        <br> Debes aceptar el consentimiento para que podamos enviarte comunicados
                                        relacionados con el Software Visionwin. Estos comunicados pueden incluir
                                        promociones, noticias de nuevas versiones y mejoras en las aplicaciones.
                                        <br> Puedes revisar <a href="/politica-de-privacidad.html"><b>nuestra política
                                                de
                                                privacidad</b></a> para más información.
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

                        <hr class="mb-4">
                        <button class="btn btn-primary " type="submit" id="enviarboton">Enviar</button>
                    </form>

                </div>

                <!-- Resultado del envío -->
                <div id="exito" style="display:none">
                    <div id="exito1"></div>
                    <p><a class="btn btn-primary" href="/" role="button">Ir al inicio</a></p>

                </div>

                <div id="fracaso" style="display:none">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡No ha sido posible enviar el formulario!</strong> Por favor, vuelve a intentarlo.
                    </div>
                </div>

            </div>

        </div>
    </div>

        
<?php

    require_once( 'pie.php' );

?> 

