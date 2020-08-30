<?php 


function page_descanso_empleado( $atts ){

    if( current_user_can('admin') || current_user_can('administrator') ){   

        $atts = shortcode_atts( array(

                'prueba' => "exito"

        ), $atts);

        extract($atts);

        if(isset($_GET['editar-gestion-descanso'])):

        include "descanso/html-descanso-editar-empleado.php";

        else:

        include "descanso/html-descanso-empleados.php";

        endif;

    }else{
        return '<div>Regístrate para ver el contenido...</div>';
    }

}



add_shortcode( 'list_descanso' , 'page_descanso_empleado' );