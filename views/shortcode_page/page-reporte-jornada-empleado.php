<?php 


function page_reporte_jornada_empleado( $atts ){

   if( current_user_can('admin') || current_user_can('secretary') || current_user_can('administrator') ){  

         $atts = shortcode_atts( array(

                  'prueba' => "exito"

         ), $atts);

         extract($atts);

         if(isset($_POST['reporte_jornada'])){

         include "reporte-jornada/reporte-jornada.php";

         }else if(isset($_GET['registrar-nueva-jornada'])){

         // include "reporte-jornada/html-reporte-jornada-registrar-empleado.php";	

         }else{

         include "reporte-jornada/html-reporte-jornada-empleados.php";

         }
         
            ?>
         <style>
            .activo-reportes{
         border-top:2px solid #a31416 !important;
            border-bottom:0!important;
      }
      
      
      .active-reportes{
                color: #fff !important;
                background: #a31416;
      }
 
	</style>
	<?php

   }else{
      return '<div>Regístrate para ver el contenido...</div>';
   }
    

}


add_shortcode( 'list_reporte_jornada' , 'page_reporte_jornada_empleado' );
