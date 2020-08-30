<?php 





function page_registrar_empleado( $atts ){

    if( current_user_can('admin') || current_user_can('administrator') ){  

        $atts = shortcode_atts( array(

                'prueba' => "exito"

        ), $atts);



        extract($atts);



        include "content/html-registrar-empleado.php";
    }else{
        return '<div>Regístrate para ver el contenido...</div>';
    }     

                    
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


}



add_shortcode( 'form_register_empleado' , 'page_registrar_empleado' );