<?php 




function page_listar_empleado( $atts ){
    
    if( current_user_can('admin') || current_user_can('secretary') || current_user_can('administrator') ){            

        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);
        if(isset($_GET['gestionar-empleado'])):
        include "content/html-editar-empleado.php";
        elseif(isset($_GET['registrar-nuevo-empleado'])):
        include "content/html-registrar-empleado.php";
        else:
        include "content/html-lista-empleados.php";
        endif;
        
                ?>
                <style>
                .activo-empleado{
                        border-top:2px solid #a31416 !important;
                        border-bottom:0!important;
                        }
                        .active-empleado{
                        color: #fff !important;
                        background: #a31416 !important;
                        }
                        </style>
                <?php

        }else{
            return '<div>Regístrate para ver el contenido...</div>';
        }          

}



add_shortcode( 'list_empleados' , 'page_listar_empleado' );