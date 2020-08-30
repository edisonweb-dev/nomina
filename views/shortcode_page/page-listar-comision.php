<?php 




function page_listar_comision( $atts ){

    if( current_user_can('admin')  || current_user_can('administrator') ){  

        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);

        if(isset($_GET['editar-comision'])):

            include "comision/html-comision-editar-empleado.php";

        elseif(isset($_GET['registrar-comision'])):

            include "comision/html-comision-registrar-empleado.php";

        else:

            include "comision/html-comision.php";

        endif;
        
            ?>
        <style>
            .activo-comision{
        border-top:2px solid #a31416 !important;
        border-bottom:0!important;
    }
    .active-pagos{
        color: #fff !important;
        background: #a31416;
    }
        </style>
        <?php
    }else{
        return '<div>Regístrate para ver el contenido...</div>';
    }
}



add_shortcode( 'list_comision' , 'page_listar_comision' );