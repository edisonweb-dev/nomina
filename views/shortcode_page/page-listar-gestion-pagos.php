<?php 




function page_listar_gestion_pagos( $atts ){

    if( current_user_can('admin') || current_user_can('administrator') ){  
        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);

        if(isset($_GET['registrar-pagos'])):

            include "pagos/html-pagos-registrar-empleado.php";

        elseif(isset($_GET['editar-pagos'])):

            include "pagos/html-pagos-editar-empleado.php";

        elseif(isset($_GET['lista-pagos'])):

            include "pagos/html-pagos-lista.php";
            
        else:

            include "pagos/html-pagos.php";

        endif;
        
            ?>
        <style>
            .activo-pagos{
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



add_shortcode( 'list_gestion_pagos' , 'page_listar_gestion_pagos' );