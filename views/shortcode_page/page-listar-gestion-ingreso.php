<?php 




function page_listar_gestion_ingreso( $atts ){
    if( current_user_can('admin') || current_user_can('administrator') ){  
        $atts = shortcode_atts( array(
                'prueba' => "exito"
        ), $atts);

        extract($atts);

        if(isset($_GET['semanal'])):

            include "ingresos/html-ingresos-semanal.php";

        elseif(isset($_GET['mensual'])):

            include "ingresos/html-ingresos-mensual.php";

        elseif(isset($_GET['anual'])):    

            include "ingresos/html-ingresos-anual.php";

        elseif(isset($_GET['masiva_semanal'])):    

            include "ingresos/html-ingresos-semanal-masivo.php";  

        elseif(isset($_GET['masiva_mensual'])):    

            include "ingresos/html-ingresos-mensual-masivo.php";
            
        elseif(isset($_GET['masiva_anual'])):    

            include "ingresos/html-ingresos-anual-masivo.php";   

        else:

            include "ingresos/html-ingresos.php";

        endif;
        
            ?>
        <style>
            .activo-ingresos{
        border-top:2px solid #a31416 !important;
        border-bottom:0!important;
    }
    
    .active-ingresos{
        color: #fff !important;
        background: #a31416;
    }
        </style>
        <?php
    }else{
        return '<div>Regístrate para ver el contenido...</div>';
    }    

}



add_shortcode( 'list_gestion_ingresos' , 'page_listar_gestion_ingreso' );