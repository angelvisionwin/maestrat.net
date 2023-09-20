<?php 

    if(!isset($pagecanonical)) $pagecanonical = "https://www.visionwin.com".$_SERVER['REQUEST_URI']; 
    if(!isset($pagetitle)) $pagetitle = "Visionwin Software de gestión y contabilidad gratuito";
    if(!isset($pagedescription)) $pagedescription = "Software de gestión y contabilidad gratuito para autónomos y pymes. Descarga gratis el programa de contabilidad y facturación.";
    if(!isset($pagekeywords)) $pagekeywords = "software, gestión, contabilidad, gratuito, facturación, autónomos, pymes, programa, descargar, gratis, descargar, programa, conta";
    
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" itemscope itemtype="http://schema.org/WebPage" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title itemprop="name"><?=$pagetitle?></title>
    <meta name="description" itemprop="description" content="<?=$pagedescription?>" />
    <meta name="keywords" itemprop="keywords" content="<?=$pagekeywords?>" />
    <meta itemprop="image" content="https://www.visionwin.com/img/logo_svg.svg" />
    <meta itemprop="url" content="<?=$pagecanonical?>" />

    <meta http-equiv="Content-Language" content="es" />
    <meta http-equiv="title" content="<?=$pagetitle?>" />
    <meta http-equiv="description" content="<?=$pagedescription?>" />
    <meta http-equiv="keywords" content="<?=$pagekeywords?>" />

    <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
    <link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
    <meta name="DC.Language" content="es" />
    <meta name="DC.Title" content="<?=$pagetitle?>" />
    <meta name="DC.Description" content="<?=$pagedescription?>" />
    <meta name="DC.Subject" content="<?=$pagekeywords?>" />
    <meta name="DC.Identifier" content="<?=$pagecanonical?>" />

    <meta property="fb:page_id" content="852703424754599" />
    <meta property="og:locale" content="es" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Visionwin" />
    <meta property="og:title" content="<?=$pagetitle?>" />
    <meta property="og:description" content="<?=$pagedescription?>" />
    <meta property="og:url" content="<?=$pagecanonical?>" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?=$pagetitle?>" />
    <meta name="twitter:description" content="<?=$pagedescription?>" />
    <meta name="twitter:image" content="https://www.visionwin.com/img/logo_svg.svg" />
    <meta name="twitter:site" content="@visionwin" />

    <meta name="geo.region" content="ES-VC" />
    <meta name="geo.placename" content="Vinar&ograve;s" />
    <meta name="geo.position" content="40.469973;0.470326" />
    <meta name="ICBM" content="40.469973, 0.470326" />

    <meta name="robots" content="index,follow,noodp,noydir" />
    <link rel="canonical" href="<?=$pagecanonical?>" />

    <link rel="icon" href="favicon.ico">
    <meta name="theme-color" content="#1a9fda" />

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Iconos fontawesome =========================================================== -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/main.min.css">
    
<?php if( isset($extracss1) ) { ?>
    <link rel="stylesheet" href="css/<?=$extracss1?>.min.css">
<?php } ?>
<?php if( isset($extracss2) ) { ?>
    <link rel="stylesheet" href="css/<?=$extracss2?>.min.css">
<?php } ?>

    <!-- Política de cookies -->
    <link rel="stylesheet" href="https://pdcc.gdpr.es/pdcc.min.css">
    <script src="https://pdcc.gdpr.es/pdcc.min.js"></script>
    <script type="text/javascript">
        PDCookieConsent.config({
            "brand": {
                "dev": false,
                "name": "Visionwin Software",
                "url": "https://visionwin.com",
                "websiteOwner": "Visionwin Software, SL"
            },
            "cookiePolicyLink": "https://www.visionwin.com/politica-cookies",
            "hideModalIn": [
                "https://www.visionwin.com/politica-cookies"
            ],
            "showBadges": false,
            "styles": {
                "primaryButton": {
                    "bgColor": "#55ACEE",
                    "txtColor": "#ffffff"
                },
                "secondaryButton": {
                    "bgColor": "#EEEEEE",
                    "txtColor": "#333333"
                }
            }
        });
    </script>


  <!-- Google Tag Manager -->
  <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PT6N974');</script>
    <!-- End Google Tag Manager -->
</head>

<body id="pagina">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PT6N974" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!--    Barra superior  -->
    <div class="container-fluid"
        style="background-color:#1a9fda; color:white; padding-top: 1px; padding-bottom: 0px; padding-left: 50px; padding-right: 50px;">
        <div class="d-flex">
            <div class="p-1 mr-auto" id="slogan-top">Software de gestión y contabilidad gratuito</div>
            <div class="p-1 icon-bar">
                <a href="https://www.facebook.com/visionwin" class="facebook"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com/visionwin" class="twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com/visionwinsoftware" class="youtube"><i class="fab fa-youtube"></i></a>

            </div>
        </div>
    </div>

    <!-- Menú  ======================================================================== -->
    <nav class="navbar navbar-expand-md bg-light navbar-light sticky-top" style="padding-left: 50px; padding-top:5px;">
        <a class="navbar-brand" href="/"><img src="/img/logo_svg.svg"
                alt="Visionwin programas de facturación y contabilidad"></a>
        <!-- Botón para resoluciones pequeñas -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse navbar-custom" id="collapsibleNavbar">
            <ul class="navbar-nav navbar-custom">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="/descargas">Soluciones</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/contabilidad.php">Contabilidad</a></li> 

                        <li>
                            <hr>
                        </li>
                        <li><a class="dropdown-item" href="/gestion.php">Facturación</a></li>
                        <li><a class="dropdown-item" href="/taller.php">Taller</a></li>
                        
                        <li><a class="dropdown-item" href="/librerias.php">Librerías</a></li>
                        <li><a class="dropdown-item" href="/despachos.php">Despachos</a></li>

                        
                        <li>
                            <hr>
                        </li>
                        <li><a class="dropdown-item" href="/tpv.php">TPV</a></li>
                        
                        <li>
                            <hr>
                        </li>
                        <li><a class="dropdown-item" href="/trabaja-en-la-nube.php">Trabajar en la nube</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a class="dropdown-item" href="/copias-de-seguridad.php">Copias de seguridad</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/descargas">Descargas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contacto">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/registro">Usuario gratuito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/precios">Precios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contratar-soporte">Contratar soporte</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Documentación</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/documentacion/contabilidad">Contabilidad</a></li>
                        <li><a class="dropdown-item" href="/documentacion/facturacion">Facturación</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a class="dropdown-item" href="https://visionwin.freshdesk.com/support/solutions">Base de conocimientos</a></li>
                        
                        
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Botón para hacer el scroll arriba cuando sea necesario ======================= -->
    <a href="#" class="scrollup"></a>