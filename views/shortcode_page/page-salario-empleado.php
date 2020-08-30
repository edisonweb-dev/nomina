<?php 





function page_salario_empleado( $atts ){
   
    if( current_user_can('admin') || current_user_can('administrator') ){  

                $atts = shortcode_atts( array(

                        'prueba' => "exito"

                ), $atts);

                extract($atts);

                if(isset($_GET['editar-salario'])):

                include "salario/html-salario-editar-empleado.php";

                else:

                include "salario/html-salario-empleados.php";

                endif;
                
                        ?>
                        <style>
                                .activo-salaraios{
                border-top:2px solid #a31416 !important;
                border-bottom:0!important;
                }
                
                .active-salarios{
                color: #fff !important;
                background: #a31416;
                }
        </style>
        <?php

      }else{
        return '<div>Regístrate para ver el contenido...</div>';
      }

}



add_shortcode( 'list_salario' , 'page_salario_empleado' );