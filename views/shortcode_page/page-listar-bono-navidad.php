<?php 




function page_listar_bono_navidad( $atts ){

    if( current_user_can('admin') || current_user_can('administrator') ){  

        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);

        if(isset($_GET['editar-bono-navidad'])):

            include "bono-navidad/html-bono-navidad-editar-empleado.php";

        elseif(isset($_GET['registrar-bono-navidad'])):

            include "bono-navidad/html-bono-navidad-registrar-empleado.php";

        else:

            include "bono-navidad/html-bono-navidad.php";

        endif;

        ?>
        <style>
            .activo-bono-navidad{
        border-top:2px solid #a31416 !important;
        border-bottom:0!important;
    }
    .active-pagos{
    color: #fff !important;
    background: #a31416 !important;
    }
        </style>
        <?php
    }else{
        return '<div>Regístrate para ver el contenido...</div>';
    }    

}



add_shortcode( 'list_bono_navidad' , 'page_listar_bono_navidad' );