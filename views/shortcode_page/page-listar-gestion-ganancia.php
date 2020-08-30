<?php 




function page_listar_gestion_ganancia( $atts ){

    if( current_user_can('admin') || current_user_can('administrator') ){  
            $atts = shortcode_atts( array(
                    'prueba' => "exito"
            ), $atts);

            extract($atts);

            if(isset($_GET['semanal'])):

                include "ganancia/html-ganancia-semanal.php";

            elseif(isset($_GET['mensual'])):

                include "ganancia/html-ganancia-mensual.php";

            elseif(isset($_GET['anual'])):    

                include "ganancia/html-ganancia-anual.php";

            elseif(isset($_GET['masiva_semanal'])):       

                include "ganancia/html-ganancia-masiva-semanal.php";

            elseif(isset($_GET['masiva_mensual'])):           

                include "ganancia/html-ganancia-masiva-mensual.php";

            elseif(isset($_GET['masiva_anual'])):           

                include "ganancia/html-ganancia-masiva-anual.php";

            else:

                include "ganancia/html-ganancia.php";

            endif;
            
                ?>
            <style>
                .activo-reportes{
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



add_shortcode( 'list_gestion_ganancia' , 'page_listar_gestion_ganancia' );