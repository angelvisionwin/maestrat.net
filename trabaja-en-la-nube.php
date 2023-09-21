<?php 

    require_once( 'no-cache.php' );

    $pagetitle = "Trabaja en la nube - Visionwin";
    $pagedescription = "Tenemos el servicio ideal para trabajar con el Software Visionwin desde cualquier lugar sin necesidad de instalar un servidor en tu oficina.";
    $pagekeywords = "software en la nube, servidor virtual";
    $formulario = "formularionube";
    $recaptcha = true;

    require_once( 'cabecera.php' ); 

?>    

    <!-- Contenido ==================================================================== -->

    <!-- Imagen principal con jumbotron -->
    <div class="jumbotron jumbonube">
        <div class="container">
            <h1 class="display-4 text-white font-weight-bold">Visionwin en la nube</h1>
            <p></p>
            <p class="lead text-white">Tenemos el servicio ideal para trabajar con el Software Visionwin desde cualquier
                lugar sin necesidad de instalar un servidor en tu oficina. Olvídate de complejas configuraciones,
                nosotros nos ocupamos de todo<br /><br />
            </p>
            <div class="text-right" style="position: relative;">
                <a href="/documentacion/general/index.html?visionwin-en-la-nube.html"><button type="button"
                        class="btn btn-light p-2">Más información</button></a>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md text-aling-justified">
                <p>
                    Desde Visionwin queremos ofrecer <strong>todas las posibilidades</strong> para que trabajes con
                    nuestro
                    software en
                    cualquier situación. Puedes tener instalado Visionwin en tu ordenador o utilizarlo <strong>desde la
                        nube</strong>,
                    aprovechando así todas las posibilidades que ofrece el uso compartido de la aplicación
                    : <br>
                <ul>
                    <li>Tener múltiples sucursales, tiendas, almacenes ...</li>
                    <li>Utilizarlo varios usuarios simultáneamente en la oficina o en cualquier lugar</li>
                    <li>Trabajar tranquilamente desde tu casa</li>
                    <li>Si llevas contabilidades, puedes conectar a tu programa desde un equipo de tu cliente, sin
                        necesidad de llevarlo instalado en un portátil</li>
                    <li>... y muchas más facilidades como por ejemplo compartir el programa sin disponer de un costoso
                        servidor central </li>
                </ul>

                </p>
                <p>La Nube también permite
                    a un solo usuario disponer de su programa desde cualquier ubicación, despreocupándose de las copias
                    de seguridad y ataques de programas maliciosos.
                </p>
                <p>
                    Además, si ya estás utilizando Visionwin en tu ordenador, el paso a la nube <strong>será muy
                        sencillo</strong>. El
                    programa que usarás será el mismo pero instalado en nuestros servidores seguros. Con la ventaja de
                    que podrás acceder desde cualquier equipo que disponga de internet y un navegador compatible ( Edge,
                    Chrome, Firefox, Opera, etc. )
                    <br><br>

                    Y por supuesto <strong>manteniendo todos los datos</strong> que tengas ya introducidos en tu
                    ordenador.

                </p>
            </div>
        </div>

        <div class="row mt-4" id="caracteristicas-nube">
            <div class="col-md panel-resaltado bg-light">
                <h4>Estas son las características del servicio :</h4>
                <br>

                <ul><i class="fa fa-check mr-2" title="Sí" alt="Sí"></i> Accede a tu programa Visionwin desde cualquier
                    ordenador utilizando el navegador.</ul>
                <ul><i class="fa fa-check mr-2" title="Sí" alt="Sí"></i> Utiliza los programas Visionwin desde
                    ordenadores con Windows, Mac, Ios, Android, Linux o cualquier otro sistema.
                </ul>
                <ul><i class="fa fa-check mr-2" title="Sí" alt="Sí"></i> Copias de seguridad diarias</ul>
                <ul><i class="fa fa-check mr-2" title="Sí" alt="Sí"></i> Sistemas de seguridad, Antivirus, Firewall,
                    Antimalware.
                </ul>
                </ul>
                <ul><i class="fa fa-check mr-2" title="Sí" alt="Sí"></i> Monitorización en tiempo real (en nuestro
                    horario laboral).</ul>
                </ul>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <ul>
                            <h4>Todo desde 24,90€ + IVA al mes</h4>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <a href="/precios.html"><button type="button" class="btn btn-primary p-2">Ver planes de
                                precios</button></a>
                    </div>
                </div>



            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md mt-4">

                <div id="tituloformulario">
                    <h3>Probar Visionwin en la Nube</h3>
                    <p>Mediante este formulario recibirás un correo electrónico con el usuario y contraseña para probar
                        Visionwin en la Nube<br>

                    <div class="row mt-2">
                        <div class="col-md">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i> Mientras estés en modo desmostración debes tener
                                en cuenta que cada día a la 1 de la madrugada el servidor de demostración reinicia los
                                datos, también cada vez que cierres el
                                programa se hace un borrado de la información.
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="container border p-4" id="contenedorformulario">

                    <form class="needs-validation" novalidate name="formularionube" id="formularionube">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    El nombre es obligatorio.
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

                        <div class="form-group mt-2">
                            <b>Selecciona el programa a probar ...</b>
                            <select class="custom-select" id="selectprograma" name="selectprograma" required size=20>
                                <option value="contabilidad">Contabilidad</option>
                                <option value="gestion">Gestión Completa, Compras, Ventas</option>
                                <option value="tpv">Terminal Punto de Venta - TPV</option>
                                <option value="ropacalzado">ROPA Y CALZADO - TPV completo para Tienda de Ropa, Calzado y
                                    complementos con gestión de atributos Tallas y colores
                                </option>
                                <option value="quioscos">QUIOSCOS - TPV configurado para Quiosco de prensa, tiendas de
                                    chucherías, Regalos, Bazar …
                                </option>
                                <option value="librerias">LIBRERÍAS - Programa para gestión de Librerías con integración
                                    SINLI y opción de TPV
                                </option>
                                <option value="bar">BAR, CAFETERÍA - TPV para Bares, Cafeterías, Cervecerías y negocios
                                    de hostelería incluyendo control de Mesas e impresoras de cocina
                                </option>
                                <option value="pub">PUB, DISCOTECA - TPV para salas de fiesta, Pub's y Discotecas
                                </option>
                                <option value="panaderia">PANADERIA - Configuración específica para TPV's de Panaderías
                                    con gestión de mesas
                                </option>
                                <option value="heladeria">HELADERÍA - TPV configurado para negocios de Heladería
                                </option>
                                <option value="pizzeria">PIZZERÍA - Gestión para TPV's en pizzerías con configuración de
                                    atributos, ingredientes e impresoras de cocina
                                </option>
                                <option value="fastfood">FASTFOOD, COMIDA RÁPIDA - TPV para negocios de restauración
                                    tipo Fast Food, con impresoras de cocina
                                </option>
                                <option value="restaurantes">RESTAURANTES - TPV para Restaurantes con control de Menús
                                    diarios, gestión de mesas e impresoras de cocina
                                </option>
                                <option value="taller">TALLER - Programa para talleres de electrodomésticos,
                                    ordenadores, telefonía y cualquier tipo de reparación con control de mecánicos
                                </option>
                                <option value="tallervehiculos">TALLER DE VEHÍCULOS - Programa para talleres mecánicos
                                    de Coches, Camiones, Tractores, motocicletas, ... con control de
                                    mecánicos y vehículos </option>
                                <option value="representantes">REPRESENTANTES - Gestión de Representantes,
                                    Comisionistas, Comerciales... con cálculo de comisiones y liquidaciones
                                </option>
                                <option value="carpinteria">CARPINTERÍA - Configuración para Talleres de enmarcación,
                                    carpinteria, cristalería, puertas... con artículos lineales,
                                    metros cuadrados, unitarios y goma
                                </option>
                                <option value="servicios">SERVICIOS - Programa para la facturación periódica de
                                    servicios como gestorías, asesorías, servicios de mantenimiento,
                                    alquiler de maquinaria, limpieza, comunidades, …
                                </option>
                                <option value="registrohorario">REGISTRO HORARIO - Sencillo programa para controlar la
                                    jornada laboral de los empleados y cumplir con la normativa
                                    laboral mediante un control de presencia.</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor selecciona algún programa
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

                        <div class="row mt-4">
                            <div class="col-md">

                                <div id="html_recaptcha"></div>

                            </div>
                        </div>

                        <hr class="mb-4">
                        <button class="btn btn-primary " type="submit" id="enviarboton">Enviar</button>
                    </form>

                </div>


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

