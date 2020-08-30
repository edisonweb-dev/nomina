<?php 




function page_listar_gestion_retencion( $atts ){
    if( current_user_can('admin') || current_user_can('administrator') ){  
        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);

        if(isset($_GET['semanal'])):

            include "retencion/html-retencion-semanal.php";

        elseif(isset($_GET['mensual'])):

            include "retencion/html-retencion-mensual.php";

        elseif(isset($_GET['anual'])):    

            include "retencion/html-retencion-anual.php";

        else:

            include "retencion/html-retencion.php";

        endif;
        
            ?>
        <style>
            .activo-retencion{
                border-top:2px solid #a31416 !important;
                border-bottom:0!important;
            }
            .active-reportes{
                color: #fff !important;
                background: #a31416;
            }
                </style>
        <?php
    }else{
        return '<div>Regístrate para ver el contenido...</div>';
    }   
}



add_shortcode( 'list_gestion_retencion' , 'page_listar_gestion_retencion' );