<?php 




function page_listar_usuarios( $atts ){

    if( current_user_can('admin') || current_user_can('administrator')  ){  

        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);

        if(isset($_GET['editar-usuarios'])):

            include "usuarios/html-editar-usuarios.php";

        elseif(isset($_GET['registrar-usuarios'])):

            include "usuarios/html-registrar-usuarios.php";

        else:

            include "usuarios/html-lista-usuarios.php";

        endif;
        
            ?>
        <style>
            .activo-usuarios{
                    border-top:2px solid #a31416 !important;
                    border-bottom:0!important;
            }
            .active-usuarios{
            color: #fff !important;
            background: #a31416 !important;
            }
        </style>
        <?php
    }else{
        return '<div>No tienes permiso para ver esta pagina...</div>';
    } 
}



add_shortcode( 'list_usuarios_empleados' , 'page_listar_usuarios' );