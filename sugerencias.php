<?php 

/*
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
*/
    // Para que no use la caché
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado

    $categorias = [
        1 => "Opciones nuevas",
        2 => "Modificaciones",
        3 => "Ajustes en el funcionamiento",
        4 => "Otros"
    ];

    $badges_categorias = [
        1 => "badge-primary",
        2 => "badge-secondary",
        3 => "badge-warning",
        4 => "badge-info"
    ];

    $estados = [
        0 => "Pendiente",
        1 => "Planificada",
        2 => "Iniciada",
        3 => "Finalizada",
        4 => "Rechazada"
    ];

    $badges_estados = [
        0 => "",
        1 => "badge-warning",
        2 => "badge-primary",
        3 => "badge-success",
        4 => "badge-danger"
    ];

    $sql1="";
    $sql2="";
    $cadena="";
    $ilumina_categoria=-1;
    $ilumina_estado=-1;

    // Conexión a BBDD
    include_once 'php/class.Database.inc.php';
    $con = new Database;       


    if ( $con != '' )
    {

        // Artículos que se mostrarán en la entrada inicial
        $articulos_pagina = 12;

        // Título por defecto
        $pagetitle = "Sugerencias Visionwin";
	    $pagedesc = "Sugerencias de mejoras proporciadas por los usuarios de Visionwin.";
	    $pagekeys = "sugerencias visionwin, mejoras visionwin";
	    $pagecanonical = "https://www.visionwin.com/sugerencias.php";

        require_once('php/cabecera.php');

        $orden="created_at";
        if (isset($_GET["orden"])){
            $orden=$_GET["orden"];
        }
        
        $sql1 = "SELECT COUNT(*) as total_sugerencias FROM wvisionwin.form_sugerencias";    
        $sql2 = "SELECT * FROM wvisionwin.form_sugerencias ORDER BY " . $orden . " DESC";
        
        if (isset($_POST["buscar"])){
            $articulos_pagina = 9999;
            $buscar=$_POST["buscar"];
            $texto='Mostrando resultados con el texto : '.$buscar;
    
            if (substr($buscar,0,1)=='"' && substr($buscar,-1)=='"'){
                $cadena=trim ($buscar,'"');
            }else 
                {
                    $buscar=explode (" ",$buscar);
                    $cadena="";
                    foreach ($buscar as $valor){
                        $cadena=$cadena.$valor."|";
                    }
                    $cadena=trim($cadena, '|');
                }
            
            if ($cadena==""){
                $sql1="SELECT COUNT(*) as total_sugerencias FROM wvisionwin.form_sugerencias ORDER BY created_at DESC";
                $sql2="SELECT * FROM wvisionwin.form_sugerencias ORDER BY created_at DESC";
                $texto="";
            } else
            {

                $cadena = utf8_decode($cadena);
                $sql1="SELECT COUNT(*) as total_sugerencias FROM wvisionwin.form_sugerencias WHERE wvisionwin.form_sugerencias.titulo REGEXP '".$cadena."' OR wvisionwin.form_sugerencias.descripcion REGEXP '".$cadena."' ORDER BY created_at DESC";
                $sql2="SELECT * FROM wvisionwin.form_sugerencias WHERE wvisionwin.form_sugerencias.titulo REGEXP '".$cadena."' OR wvisionwin.form_sugerencias.descripcion REGEXP '".$cadena."' ORDER BY created_at DESC";

            }
        } 
        
        if (isset($_GET["categoria"])){
            $articulos_pagina = 9999;
			$categoria=$_GET["categoria"];
            $ilumina_categoria=$categoria;
            $sql1 = "SELECT COUNT(*) as total_sugerencias FROM wvisionwin.form_sugerencias WHERE `categoria`=".$categoria;
            $sql2 = "SELECT * FROM wvisionwin.form_sugerencias WHERE `categoria`=".$categoria." ORDER BY created_at DESC"; 
        } 
        
        if (isset($_GET["estado"])){
            $articulos_pagina = 9999;
			$estado=$_GET["estado"];
            $ilumina_estado=$estado;
            $sql1 = "SELECT COUNT(*) as total_sugerencias FROM wvisionwin.form_sugerencias WHERE `estado`=".$estado;
            $sql2 = "SELECT * FROM wvisionwin.form_sugerencias WHERE `estado`=".$estado." ORDER BY created_at DESC";
	    } 

        if (isset($_GET["programa"])){
            $articulos_pagina = 9999;
			$programa=$_GET["programa"];
            $sql1 = "SELECT COUNT(*) as total_sugerencias FROM wvisionwin.form_sugerencias WHERE `".$programa."`=1";
            $sql2 = "SELECT * FROM wvisionwin.form_sugerencias WHERE `".$programa."`=1 ORDER BY created_at DESC";
	    } 

		{

          $num_total_rows = $con->get_valor_query( $sql1, 'total_sugerencias' );

          if (true) //($num_total_rows > 0) 
          {
              $page = false;
              
              //examino la pagina a mostrar y el inicio del registro a mostrar
              if (isset($_GET["page"])) {
                  $page = $_GET["page"];
              }
  
              if (!$page) {
                  $start = 0;
                  $page = 1;
              } else {
                  $start = ($page - 1) * $articulos_pagina;
              }
              
              //calculo el total de paginas
              $total_pages = ceil($num_total_rows / $articulos_pagina);
              
              $sql2=$sql2." LIMIT ".$start.", ".$articulos_pagina;    
              
              $row = $con->get_Cursor ( $sql2 );

              echo '<div class="container-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9">
                                   <h3>Relación de sugerencias facilitadas por los usuarios de Visionwin</h3>
                                   ¡Hagamos entre todos un programa más potente, amigable y eficaz!
                                   <br><br>
                                </div>
                                <div class="col-md-3">
                                    <form class="form-inline" name="formulario" method="post" action="sugerencias.php">
                                        <div class="form-group">
                                            <label for="buscar" class="mr-sm-2"></label>
                                            <input type="text" class="form-control mr-sm-2" id="buscar" name="buscar" size=12>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </form>
                                </div>
                            </div>';

              if ($texto!="")
              {
                 echo '<dt>'.$texto."</dt><br/>";
              }

              echo '<div class="row">';
              echo '<div class="col-md-9">';
  
  			  // Mostrando todos los artículos
              while ($datos = $row->fetch_assoc() )
  	           {
                  echo '<div class="row mb-4">';
                  echo '  <div class="col-md">';
                  echo '    <div class="card panel-no-padding" style="width:100%;">';
                  echo '        <div class="card-body">';
                  echo '            <h2 class="card-title" style="font-size:18px;font-weight:bold;margin:0;">'.utf8_encode($datos['titulo']).'</h2>';
		  	      echo '            <span class="small">Fecha : '.date("d.m.Y",strtotime($datos['created_at']));
		  	      echo '            </span><br><br>';
                  echo '            <p class="card-text">';
                  echo                  utf8_encode($datos['descripcion']);
                  echo              '</p>';
                  echo '        </div>';
                  echo '        <div class="card-footer">';
                  echo '          <h5>';
                  if ($datos['contabilidad']==1) {
                    echo '          <a href="/sugerencias.php?programa=contabilidad">';  
                    echo '            <span class="h3 mr-2 badge badge-success">Visionwin Contabilidad</span>';
                    echo '          </a>';
                  }
                  if ($datos['gestion']==1) {
                    echo '          <a href="/sugerencias.php?programa=gestion">';  
                    echo '            <span class="h3 mr-2 badge badge-info">Visionwin Gestión</span>';
                    echo '          </a>';
                  }
                  echo '          <a href="/sugerencias.php?categoria='.$datos['categoria'].'">';
                  echo '            <span class="h3 mr-2 badge '.$badges_categorias[$datos['categoria']].'">'.$categorias[$datos['categoria']].'</span>';
                  echo '          </a>';
                  echo '          <a href="/sugerencias.php?estado='.$datos['estado'].'">';
                  echo '            <span class="h3 mr-2 badge '.$badges_estados[$datos['estado']].'">'.$estados[$datos['estado']].'</span>';
                  echo '          </a>';
                  echo '          <span class="float-right mr-4">';
                  echo '          <a href="javascript:abremodalvotos('.$datos['id'].','.$datos['votos'].')">';
                  echo'           <script>
                                    function abremodalvotos($id,$votos){
                                        $("#idsugerencia").val($id);
                                        $("#idvotos").val($votos);
                                        $("#modalformulariovotos").modal("show");
                                    }
                                  </script>';
                  echo '            <span class="h3 badge badge-danger">Votar</span>';
                  echo '          </a>';
                  echo '            <span class="small ml-2">Votos : '.$datos['votos'].'</span>';
                  echo '          </span>';
                  echo '          </h5>';
                  if ($datos['id_mantis']!=''){
                      echo '<a href="/desarrollo/view.php?id='.$datos['id_mantis'].'">';
                      echo '<small>Seguimiento en carga de trabajo : '.$datos['id_mantis'].'</small>';
                      echo '</a>';
                  }
                  if ($datos['notas']!=''){
                      echo '<hr>';
                      echo '<small><b>Anotación al respecto:</b> '.utf8_encode($datos['notas']).'</small>';
                  }
                  echo '        </div>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '</div>';

                 }
              echo '</div>';
              echo '<div class="col-md ml-2">';
              echo '    <button type="button" class="btn btn-info mr-2 mb-2" data-toggle="modal" data-target="#modalformulario">Añadir sugerencia</button>';
              echo '    <hr>';

              echo '    <span class="h5">Programas</span><br/><br/>';
              echo '    <a href="/sugerencias.php?programa=contabilidad" class="text-muted">Visionwin Contabilidad</a><br/>';
              echo '    <a href="/sugerencias.php?programa=gestion"      class="text-muted">Visionwin Gestion</a><br/>';
              echo '    <a href="/sugerencias.php" class="text-muted">Ver todo ...</a></h5><br/>';
              echo '    <hr>';

              echo '    <span class="h5">Categorías</span><br/><br/>';
              for ( $i=1; $i<=4; $i++){
                echo '<a href="/sugerencias.php?categoria='.$i.'" class="';
                if ($ilumina_categoria==$i){
                    echo "text-warning".'">'.$categorias[$i].'</a><br/>';
                } else{
                    echo "text-muted".'">'.$categorias[$i].'</a><br/>';
                }
                
                
              }
              echo '<a href="/sugerencias.php" class="text-muted">Ver todo ...</a></h5><br/>';
              echo '    <hr>';

              echo '    <span class="h5">Estados</span><br/><br/>';
              for ( $i=0; $i<=4; $i++){
                echo '<a href="/sugerencias.php?estado='.$i.'" class="';
                if ($ilumina_estado==$i){
                    echo "text-warning".'">'.$estados[$i].'</a><br/>';
                }else{
                    echo "text-muted".'">'.$estados[$i].'</a><br/>';
                }
                
              }
              echo '<a href="/sugerencias.php" class="text-muted">Ver todo ...</a></h5><br/>';
              echo '    <hr>';

              echo '    <span class="h5">Otros</span><br/><br/>';
              echo '<a href="/sugerencias.php?orden=votos" class="text-muted">Más votadas</a>';
              echo '    <hr>';

              
              echo '</div>';
              echo '</div>';
              
              echo '<nav>';
              echo '<ul class="pagination pl-4">';
              
              if ($total_pages > 1) {
                  if ($page != 1) {
                      echo '<li class="page-item"><a class="page-link" href="/sugerencias.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
                  }
                  
                  for ($i=1;$i<=$total_pages;$i++) {
                      if ($page == $i) {
                          echo '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
                      } else {
                          echo '<li class="page-item"><a class="page-link" href="/sugerencias.php?page='.$i.'">'.$i.'</a></li>';
                      }
                  }
                  
                  if ($page != $total_pages) {
                      echo '<li class="page-item"><a class="page-link" href="/sugerencias.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
                  }
              }
              echo '</ul>';
              echo '</nav>';

          } 
		}
    }

    // Formulario de sugerencias modal
    $formulariosugerencias="formulariosugerencias";
    echo '
    <div class="modal fade" id="modalformulario">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Cabecera -->
                <div class="modal-header">
                    <h4 class="modal-title">Enviar nueva sugerencia</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body">
                <div class="row mt-3">
                <div class="col-md" id="contenedorformulario">
                    <!-- Formulario -->
                    <form class="needs-validation" novalidate name="formulariosugerencias" id="formulariosugerencias" onsubmit="return procesaformulario('."'".$formulariosugerencias."'".')">
    
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre">Breve descripción</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="" value=""
                                    required>
                                <div class="invalid-feedback">
                                    Se requiere una descripción corta
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <label for="programa">Categoría</label>
                                <select class="form-control" id="categoria" name="categoria">
                                    <option value="1">Opción nueva</option>
                                    <option value="2">Modificación sobre una opción existente</option>
                                    <option value="3">Ajustes de funcionamiento</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="consulta">Descripción con detalle de la sugerencia</label>
                                <textarea class="form-control" rows="2" id="detalle" name="detalle" placeholder=""
                                    required></textarea>
                                <div class="invalid-feedback">
                                    Por favor introduce la descripción detallada de la sugerencia
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="programas">Aplicable a los programas</label>
                                <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="gestion" name="gestion" required>
                                  <label class="form-check-label" for="gestion">Visionwin Gestión</label>
                                </div>
                                <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="contabilidad" name="contabilidad" required>
                                  <label class="form-check-label" for="contabilidad">Visionwin Contabilidad</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md">
                                <label for="email">Email </label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                <div class="invalid-feedback">
                                    Por favor introduce un correo válido
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md">
                                <br />
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="acepto" name="acepto" required>
                                    <label class="form-check-label" for="acepto">He leído y acepto la política de privacidad
                                        de Visionwin</label>
                                    <a href="#politica" data-toggle="collapse"><b>(detalle)</b></a>
                                    <div class="invalid-feedback">
                                        Debes aceptar para poder enviar el formulario.
                                    </div>
    
                                    <div id="politica" class="collapse text.muted" style="font-size:0.8rem;">
                                        <br> Debes aceptar el consentimiento para que podamos enviarte comunicados
                                        relacionados con el Software Visionwin. Estos comunicados pueden incluir
                                        promociones, noticias de nuevas versiones y mejoras en las aplicaciones.
                                        <br> Puedes revisar <a href="/politica-de-privacidad.html"><b>nuestra política de
                                                privacidad</b></a> para más información.
                                    </div>
                                </div>
    
                            </div>
                        </div>
    
                        <input type="hidden" id="token" name="token" value="9987jazzkdklr_" />
    
                        <hr class="mb-4">
                        <button class="btn btn-primary " type="submit">Enviar</button>
                    </form>
                </div>
            </div>
    
                </div>
            </div>
        </div>
    </div>';

    // Avisos formulario de sugerencias modal
    echo '
    <div class="modal fade" id="modalexito">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Cuerpo -->
                <div class="modal-body">
                    <div class="row mt-3">
                        <div class="col-md" id="textoexito">
                        Muchas gracias, se ha registrado la sugerencia.
                        </div>
                    </div>
                </div>
                <!-- Pie -->
                <div class="modal-footer">
                    <a href="/sugerencias.php"><button type="button" class="btn btn-primary">Volver</button></a>
                </div>

            </div>
        </div>
    </div>';

    // Formulario de votos modal
    $formulariovotos="formulariovotos";
    echo '
    <div class="modal fade" id="modalformulariovotos">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Cabecera -->
                <div class="modal-header">
                    <h4 class="modal-title">Enviar voto</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Cuerpo -->
                <div class="modal-body">
                <div class="row mt-3">
                <div class="col-md" id="contenedorformulariovotos">
                    <!-- Formulario -->
                    <form class="needs-validation" novalidate name="formulariovotos" id="formulariovotos" onsubmit="return procesaformulario('."'".$formulariovotos."'".')">
                        <div class="row">
                            <div class="col-md">
                                <label for="email">Email </label>
                                <input type="email" class="form-control" id="emailv" name="email">
                            </div>
                        </div>
    
                        <input type="hidden" id="idsugerencia" name="idsugerencia">
                        <input type="hidden" id="idvotos" name="idvotos">
                        <input type="hidden" id="token" name="token" value="9987jazzkdklr_" />
    
                        <hr class="mb-4">
                        <button class="btn btn-primary " type="submit">Enviar</button>
                    </form>
                </div>
            </div>
    
                </div>
            </div>
        </div>
    </div>';

    // Avisos formulario votos modal
    echo '
    <div class="modal fade" id="modalexitovotos">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Cuerpo -->
                <div class="modal-body">
                    <div class="row mt-3">
                        <div class="col-md" id="modalexitovotostexto">
                        Muchas gracias, se ha registrado el voto.
                        </div>
                    </div>
                </div>
                <!-- Pie -->
                <div class="modal-footer">
                    <a href="/sugerencias.php"><button type="button" class="btn btn-primary">Volver</button></a>
                </div>

            </div>
        </div>
    </div>';
    

    echo '</div></div>';
    $pieformulario="SI";
    // Requiero las funciones de los formularios pero voy a lanzar el procesado desde el form, no quiero que se ocupe
    // el modo automático
    $pieformularionombre="";
    require_once ('php/pie.php');

?>
