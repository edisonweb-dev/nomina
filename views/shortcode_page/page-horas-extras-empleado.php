<?php 


function page_horas_extras_empleado( $atts ){

    if( current_user_can('admin') || current_user_can('administrator') ){  

            $atts = shortcode_atts( array(

                    'prueba' => "exito"

            ), $atts);

            extract($atts);

            if(isset($_GET['editar-hora'])):

            include "horas-extras/html-extras-editar-empleado.php";

            else:

            include "horas-extras/html-extras-empleados.php";

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



add_shortcode( 'list_horas_extras' , 'page_horas_extras_empleado' );





