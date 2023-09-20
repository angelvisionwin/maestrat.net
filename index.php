<?php 

    $pagetitle = "Programas de facturación y contabilidad - Visionwin";
    $pagedescription = "Programas de contabilidad, facturación y TPV gratis. Software de gestión, facturación y contabilidad en español con todo lo necesario para gestionar empresas y pymes.";
    $pagekeywords = "software facturacion y contabilidad, programas de facturacion y contabilidad, programas de contabilidad y facturacion";
    $extracss = "banners";

    require_once( 'php/cabecera.php' );

?>    

    <!-- Imagen principal con jumbotron -->

    <div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="4000">
        <ol class="carousel-indicators">
            <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselIndicators" data-slide-to="1"></li>
            <li data-target="#carouselIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img class="d-block w-100" src="img/b1_2023.webp" alt="Programas de facturación y contabilidad">
                <div class="carousel-caption-top">
                    Programas <span class="negrita">de</span><br />
                    <span class="negrita">Contabilidad,<br />
                        facturación y TPV</span><br />
                    <span class="texto-subtitulo">Gratuitos y de calidad<br />
                        profesional
                    </span>

                    <p>
                        <a class="btn btn-primary carousel-boton" href="/descargas" role="button">¡Descárgalos
                            ahora!<i class="ml-4 fas fas fa-arrow-circle-down" style="text-shadow: 0"></i></a>
                        <a class="btn btn-outline-primary carousel-boton" href="/trabaja-en-la-nube"
                            role="button">¡Pruébalos en
                            la nube<i class="ml-4 fas fas fa-cloud pull-right"></i></a>
                    </p>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="img/b2_2023.webp" alt="Programas de facturación y contabilidad">
                <div class="carousel-caption-top">
                    <span class="negrita subrayado">NUEVA VERSIÓN 2023 rev. 5.0</span><br />
                    <span class="texto-subtitulo">
                        Adaptada a la <span class="negrita">normativa<br />
                            de la Ley 11/2021</span> de<br />
                        medidas de prevención y<br />
                        lucha contra el fraude fiscal<br /><br />
                    </span>
                    <p>
                        <a class="btn btn-primary carousel-boton" href="/descargas" role="button">¡Descárgala
                            gratis!<i class="ml-4 fas fas fa-arrow-circle-down" style="text-shadow: 0"></i></a>
                    </p>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="img/b3_2023.webp" alt="Programas de facturación y contabilidad">
            </div>



        </div>
    </div>


    <!-- Contenido ==================================================================== -->
    <div class="container-fluid bg-light">
        <div class="container">
            <div class="row d-flex justify-content-center">

                <h1 class="titulo-index">Software gratuito de gestión, facturación y contabilidad</h1>
                <p class="mb-4 subtitulo-index">Crea tus facturas, tus tickets, lleva tu contabilidad y calcula tus impuestos</p>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark">
        <div class="container">
            <div class="card-deck mb-4 mt-4">
                <div class="card panel">
                    <img class="card-img-top" src="/img/visionwin-contabilidad.webp"
                        alt="Programas de facturación y contabilidad">
                    <div class="card-body">
                        <h2 class="card-title">Visionwin Contabilidad</h2>
                        <p class="card-text">Instala ya nuestro software de contabilidad adaptado a la PYME. Con todo lo
                            necesario para que el trabajo contable sea ágil, cómodo y fiable. Millones de asientos
                            procesados aseguran una fiabilidad demostrada.</p>
                    </div>
                    <div class="card-footer">
                        <a href="/contabilidad"><button class="btn btn-block btn-info">Más información</button></a>
                    </div>
                </div>
                <div class="card panel">
                    <img class="card-img-top" src="/img/visionwin-gestion.webp"
                        alt="Programas de facturación y contabilidad">
                    <div class="card-body">
                        <h2 class="card-title">Visionwin Gestión</h2>
                        <p class="card-text">Prueba el software que engloba todas las necesidades de Gestión de la PYME.
                            Rápida instalación y fácil manejo mediante una interfaz muy intuitiva y gráfica. Sus
                            prestaciones son innumerables.</p>
                    </div>
                    <div class="card-footer">
                        <a href="/gestion"><button class="btn btn-block btn-info">Más información</button></a>
                    </div>
                </div>
                <div class="card panel">
                    <img class="card-img-top" src="/img/visionwin-tpv.webp"
                        alt="Programas de facturación y contabilidad">
                    <div class="card-body">
                        <h2 class="card-title">Visionwin TPV</h2>
                        <p class="card-text">Disfruta de un cómodo software de Terminal Punto de Venta. Evolución hacia
                            el entorno táctil, totalmente configurable y adaptado a los distintos sectores del comercio
                            como hosteleria, tiendas, talleres, etc... </p>
                    </div>
                    <div class="card-footer">
                        <a href="/tpv"><button class="btn btn-block btn-info">Más información</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

    require_once( 'php/pie.php' );

?> 

