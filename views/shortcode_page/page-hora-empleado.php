<?php 


function page_hora_empleado( $atts ){

  if( current_user_can('admin') || current_user_can('administrator') ){   

        $atts = shortcode_atts( array(

                'prueba' => "exito"

        ), $atts);

        extract($atts);

        if(isset($_GET['editar-gestion-hora'])):

        include "horas/html-horas-editar-empleado.php";

        else:

        include "horas/html-horas-empleados.php";

        endif;
        
          ?>
      <style>
        .activo-gestion-horas{
        border-top:2px solid #28a745 !important;
          border-bottom:0!important;
    }
    
    .active-gestion-horas{
    color: #fff !important;
    background: #a31416 !important;
    }
      </style>
      <?php
  }else{
    return '<div>Regístrate para ver el contenido...</div>';
  }    

}


add_shortcode( 'list_hora' , 'page_hora_empleado' );
