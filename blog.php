<?php 
    // Conexión a BBDD
    include_once 'php/class.Database.inc.php';
    $con = new Database;    
    if ( $con !='' )  // Conexión correcta
    {
		////////////////////////////////////////
		// Redirecciones para URLs amigables
		//if($_SERVER['REQUEST_URI'] == "/blog.php"){
		//	header("HTTP/1.1 301 Moved Permanently");
		//	header("Location: https://www.visionwin.com/blog/");
		//}
		if (strpos($_SERVER['REQUEST_URI'],'id=') !== false) {
			$sql="SELECT * FROM wvisionwin.blog WHERE ID=".$_GET["id"]."  LIMIT 1";
            $datos = $con->get_Row( $sql );

            header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://www.visionwin.com/blog/".$_GET["id"]."-".urls_amigables(utf8_encode($datos['titulo'])));
		}
		if (isset($_GET["id"]) && strpos($_SERVER['REQUEST_URI'],'/blog/') === false) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://www.visionwin.com/blog".$_SERVER['REQUEST_URI']);
		}
		////////////////////////////////////////

        // Artículos que se mostrarán en la entrada inicial del blog
        define('ARTICULOS_POR_PAGINA',999);

        // Título por defecto
        $pagetitle = "Blog - Visionwin";
		$pagedescription = "Noticias de actualidad sobre contabilidad, facturación y TPV. Noticias sobre nuestros programas gratuitos y actualizaciones.";
		$pagekeywords = "blog visionwin, noticias visionwin";
		$pagecanonical = "https://www.visionwin.com/blog/";

        // Compruebo si se pasa ID para establecer el título de la página
        $id = 0;
        
        if (isset($_GET["id"])) { 
             $id = $_GET["id"];
             
             $sql="SELECT * FROM wvisionwin.blog WHERE ID=".$id."  LIMIT 1";
             $datos = $con->get_Row( $sql );
             
             $pagetitle = utf8_encode($datos['titulo'])." | Visionwin";
			 $pagedescription = utf8_encode($datos['descripcion']);
             $pagekeywords = utf8_encode($datos['keywords']);
             $pagesubject = utf8_encode($datos['subject']);
			 $pagecanonical = "https://www.visionwin.com".$_SERVER['REQUEST_URI'];
             //$id = 0;
        }
    
        require_once('php/cabecera.php');

        // Facebook JS SDK
        echo '<div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v9.0" nonce="EbeMH86o"></script>';
                
        echo '<div class="container-fluid">
                <div class="container">
                  <div class="row">
                    <div class="col-md">
            ';


        // Título y formulario de búsqueda
		
		if($id == 0) $h1 = "Blog Visionwin"; else $h1 = utf8_encode($datos['titulo']);

        if($id == 0){
        echo '
			<div class="row">
                <div class="col-sm-8">
                    <h2 class="subrayado-azul">Artículos publicados</h2>
                </div>
				<div class="col-sm-4 text-right">
					<form class="form-inline" name="formulario" method="post" action="blog.php">
						<div class="form-group">
							<label for="buscar" class="mr-sm-2"></label>
							<input type="text" class="form-control mr-sm-2" id="buscar" name="buscar" size=20>
						</div>
						<button type="submit" class="btn btn-primary">Buscar</button>
					</form>
				</div>
            </div>
            <br>
            ';
        }


	    // Compruebo si hay búsqueda pasada para mostrar sólo esos resultados en resumen
	    if (isset($_POST["buscar"])){
			$buscar=$_POST["buscar"];
			echo 'Mostrando resultados con las palabras : '.$buscar;
            echo '<br><br>';

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
            $sql="SELECT * FROM wvisionwin.blog WHERE wvisionwin.blog.titulo REGEXP '".$cadena."' OR wvisionwin.blog.contenido REGEXP '".$cadena."' ORDER BY actualizado DESC";
            $row = $con->get_Cursor ( $sql );

			while ($datos = $row->fetch_assoc() )
            {
				echo '<b>'.utf8_encode($datos['titulo']);
                echo '</b><br>';
				echo '<span class="small">Actualizado : '.date("d.m.Y",strtotime($datos['actualizado']));
				echo '</span><br><br>';
				echo '<p>';
                echo utf8_encode($datos['vistaprevia']);
                echo '</p>';
                echo '<a href="/blog/'.$datos['ID'].'-'.urls_amigables(utf8_encode($datos['titulo'])).'" class="btn btn-outline-info btn-sm">Leer más ... </a>';			
				echo '<hr>';
			}
			echo '<br><a href="/blog/" class="btn btn-info">Volver al inicio.</a>';
		
	    } else

		{
  	
          // No hay búsqueda pasada, compruebo si se le pasa un ID para mostrar sólo ese (sólo cambia el filtro)
          $id =0;
          if (isset($_GET["id"])) {
              $id = $_GET["id"];
          }
          
          if ($id == 0) {
            $sql = "SELECT COUNT(*) as total_products FROM wvisionwin.blog";    
          } else {
              $sql = "SELECT COUNT(*) as total_products FROM wvisionwin.blog WHERE ID=".$id;            
          }
                  
          $num_total_rows = $con->get_valor_query( $sql, 'total_products' );
          
          if ($num_total_rows > 0) {
              $page = false;
              
              //examino la pagina a mostrar y el inicio del registro a mostrar
              if (isset($_GET["page"])) {
                  $page = $_GET["page"];
              }
  
              if (!$page) {
                  $start = 0;
                  $page = 1;
              } else {
                  $start = ($page - 1) * ARTICULOS_POR_PAGINA;
              }
              
              //calculo el total de paginas
              $total_pages = ceil($num_total_rows / ARTICULOS_POR_PAGINA);
              
              /*
              echo 'Numero de articulos: '.$num_total_rows;
              echo ' - En cada pagina se muestra '.ARTICULOS_POR_PAGINA.' articulos';
              echo ' - Mostrando la pagina '.$page.' de ' .$total_pages.' paginas.';
              echo '<br>';
              echo '<br>';
              */
              
              if ($id==0){
                $sql="SELECT * FROM wvisionwin.blog ORDER BY actualizado DESC LIMIT ".$start.", ".ARTICULOS_POR_PAGINA;    
              } else {
                $sql="SELECT * FROM wvisionwin.blog WHERE ID=".$id." ORDER BY actualizado DESC LIMIT ".$start.", ".ARTICULOS_POR_PAGINA;    
              }
              
 
              if ($id==0){ 
			      // Mostrando todos los artículos
                  $counter = 0;
                  $row = $con->get_Cursor ( $sql );
                  
                  while ($datos = $row->fetch_assoc() )
  	               {

                        if ($counter==0){
                            echo '<div class="card-deck">';
                        }

                        $counter++;

                        echo '<div class="card panel-no-padding">';
                        echo '<img class="card-img-top" src="'.$datos['imagen'].'" alt="'.utf8_encode($datos['titulo']).'" style="max-width:150px;margin-left:25px;margin-top:25px;">';
                        echo '<div class="card-body">';
                        echo '<h2 class="card-title" style="font-size:18px;font-weight:bold;margin:0;"><a href="/blog/'.$datos['ID'].'-'.urls_amigables(utf8_encode($datos['titulo'])).'">' . utf8_encode($datos['titulo']) . '</a></h2>';
					    echo '<span class="small">Actualizado : '.date("d.m.Y",strtotime($datos['actualizado']));
					    echo '</span><br><br>';
                        echo '<p class="card-text">';
                        echo utf8_encode($datos['vistaprevia']);
                        echo '</p>';
                        echo '<a href="/blog/'.$datos['ID'].'-'.urls_amigables(utf8_encode($datos['titulo'])).'" class="btn btn-outline-info btn-sm">Leer más ... </a>';			
                        echo '</div>';
                        echo '</div>';
                        echo '<p></p>';

                        if ($counter==2){
                            $counter=0;
                            echo '</div>';
                            echo '<br/>';
                        }
  	               }

                  if ($counter!=0){
                    echo '</div>';
                  }
  
                  echo '<nav>';
                  echo '<ul class="pagination">';
                  
                  if ($total_pages > 1) {
                      if ($page != 1) {
                          echo '<li class="page-item"><a class="page-link" href="blog.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
                      }
                      
                      for ($i=1;$i<=$total_pages;$i++) {
                          if ($page == $i) {
                              echo '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
                          } else {
                              echo '<li class="page-item"><a class="page-link" href="blog.php?page='.$i.'">'.$i.'</a></li>';
                          }
                      }
                      
                      if ($page != $total_pages) {
                          echo '<li class="page-item"><a class="page-link" href="blog.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
                      }
                  }
                  echo '</ul>';
                  echo '</nav>';
              } else {
				  // Mostrando un ID en concreto

                  $datos = $con->get_Row( $sql );
                  
                  echo '<div class="container bg-light border show mb-4">';
                  echo '<div class="articulo-blog">';
                  echo '<h2 style="font-size:1.75rem;">'.utf8_encode($datos['titulo']).'</h2>';
				  echo '<span class="small">Actualizado : '.date("d.m.Y",strtotime($datos['actualizado']));
				  echo '</span><br><br>';
                  echo '<p>';
                  echo utf8_encode($datos['contenido']);
                  echo '</p>';
                  echo '</div>';
                  echo '</div>';
                  echo '<a href="/blog/" class="btn btn-info">Volver al inicio</a>';
              }
              
          }
		}
    }

    echo '</div></div></div></div>';
    include ('php/pie.php');

?>

<?php
function urls_amigables($url) {

// Tranformamos todo a minusculas

$url = strtolower($url);

//Rememplazamos caracteres especiales latinos

$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

$repl = array('a', 'e', 'i', 'o', 'u', 'n');

$url = str_replace ($find, $repl, $url);

// Añaadimos los guiones

$find = array(' ', '&', '\r\n', '\n', '+'); 
$url = str_replace ($find, '-', $url);

// Eliminamos y Reemplazamos demás caracteres especiales

$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

$repl = array('', '-', '');

$url = preg_replace ($find, $repl, $url);

return $url;

}
?>