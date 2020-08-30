<?php 


function page_jornada_diaria_empleado( $atts ){

  if( current_user_can('admin') || current_user_can('administrator') || current_user_can('secretary')   ){  

        $atts = shortcode_atts( array(

                'prueba' => "exito"

        ), $atts);

        // var_dump($_GET);

        extract($atts);

        if(isset($_GET['editar-jornada-diaria'])){

          include "jornada-diaria/html-jornada-diaria-editar-empleado.php";

        }else if(isset($_GET['registrar-nueva-jornada'])){

          include "jornada-diaria/html-jornada-diaria-registrar-empleado.php";	

        }else if(isset($_GET['listado-jornada-diaria'])){
          
          include "jornada-diaria/html-jornada-diaria-empleados-listado.php";	

        }else{

          include "jornada-diaria/html-jornada-diaria-empleados.php";

        }
        
          ?>
      <style>
        .activo-jornada-diaria{
        border-top:2px solid #a31416 !important;
          border-bottom:0!important;
    }
    .active-jornada-diaria{
    color: #fff !important;
    background: #a31416 !important;
    }
 
 
	</style>
	<?php

  }else{
    return '<div>Regístrate para ver el contenido...</div>';
  }

}


add_shortcode( 'list_jornada_diaria' , 'page_jornada_diaria_empleado' );
