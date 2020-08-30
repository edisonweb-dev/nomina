<?php

/*

Plugin Name: GESTION DE EMPLEADOS

Plugin URI: https://solucioneswebig.com/

Description: Sistema de gestion para la nomina de los empleados

Version: 1.0

Author: SolucionesWeBig - Alexander Gutierrez

Author URI: https://solucioneswebig.com/

License: GPLv2

*/



if ( ! defined( 'ABSPATH' ) ) exit; 

 

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {

	require_once dirname( __FILE__ ) . '/cmb2/init.php';

} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {

	require_once dirname( __FILE__ ) . '/CMB2/init.php';

}








global $wpdb;

$prefix_plugin_gn = "gestion_nomina_";



define('PREFIX', 'gn_');

define( 'GN_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

define( 'GN_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

define('PLUGIN_BASE_DIR', dirname(__FILE__));

//EMPIEZO A DEFINIR LAS TABLAS DE LA BD

define('TABLA_EMPLEADOS' , $wpdb->prefix . $prefix_plugin_gn . 'perfil_empleado');

define('TABLA_DOCUMENTOS' , $wpdb->prefix . $prefix_plugin_gn . 'documentos_empleado');

define('TABLA_SALARIO' , $wpdb->prefix . $prefix_plugin_gn . 'salario_fecha');

define('TABLA_ESTADO' , $wpdb->prefix . $prefix_plugin_gn . 'estado');

define('TABLA_HORA_EXTRA' , $wpdb->prefix . $prefix_plugin_gn . 'hora_extra');

define('TABLA_GESTION_HORA' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_hora');

define('TABLA_DESCANSO' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_descanso');

define('TABLA_JORNADA_DIARIA' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_jornada_diaria');

define('TABLA_BONO_NAVIDAD' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_bono_navidad');

define('TABLA_COMISION' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_comision');

define('TABLA_PAGO' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_pago');

define('TABLA_PAGO_REGISTRADO' , $wpdb->prefix . $prefix_plugin_gn . 'gestion_pago_registrado');

define('TABLA_USUARIOS' , $wpdb->prefix . 'users');

define('TABLA_USUARIOS_META' , $wpdb->prefix . 'usermeta');

//FINALIZO LA DEFINICION DE LAS TABLAS DE LA BD



function design_styles(){

	wp_enqueue_style( 'mtb-style-general', GN_PLUGIN_DIR_URL . 'assets/css/style.css', false );

	wp_enqueue_style( 'datatable-public-css','//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', false );

	wp_enqueue_style( 'datatable-public-responsive-css','https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css', false );

	wp_enqueue_style( 'datatable-buttons','https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css', false );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'datatable-public-js','//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array('jquery'), '1.10.19', true );

	wp_enqueue_script( 'datatable-public-responsive-js','https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'datatable-buttons','https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'datatable-buttons-flash','https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'datatable-jszip','https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'datatable-pdfmake','https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'datatable-html5-buttons','https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'datatable-print-buttons','https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js', array('jquery'), null, true );

	wp_enqueue_script( 'sweet-alert','https://cdn.jsdelivr.net/npm/sweetalert2@8', array('jquery'), null, true );

	wp_enqueue_script( 'mtb-scripts-general', GN_PLUGIN_DIR_URL . 'assets/js/scripts.js' , array( 'jquery' ), null , true );
	
	
	wp_enqueue_script( 'script-busqueda', GN_PLUGIN_DIR_URL . 'assets/js/busqueda.js' , array( 'jquery' ), '1.0.0' , true );

	wp_localize_script('script-busqueda','busqueda_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);

}

add_action('wp_enqueue_scripts', 'design_styles');



//Devolver datos a archivo js
add_action('wp_ajax_nopriv_ajax_busqueda','busqueda_ajax');
add_action('wp_ajax_ajax_busqueda','busqueda_ajax');

function busqueda_ajax(){
  include "ajax/busqueda.ajax.php";
}








/*Incluimos la carpeta de models*/

include GN_PLUGIN_DIR_PATH . "models/index.php";

/*Incluimos la carpeta de models*/

include GN_PLUGIN_DIR_PATH . "controllers/index.php";

/*Incluimos la carpeta de admin*/

include GN_PLUGIN_DIR_PATH . "admin/index.php";

/*Incluimos la carpeta de public*/

include GN_PLUGIN_DIR_PATH . "public/index.php";

/*Incluimos la carpeta de views*/

include GN_PLUGIN_DIR_PATH . "views/index.php";


include( 'assets/fpdf/atomicsmash-pdf-helper-functions.php');


include GN_PLUGIN_DIR_PATH . "reportes/index.php";





// evento cron virtual 
//activación del plugin
register_activation_hook( __FILE__, 'dcms_plugin_activation' );
function dcms_plugin_activation(){
    if( ! wp_next_scheduled( 'dcms_my_cron_hook' )){
        wp_schedule_event( current_time( 'timestamp' ),'5seconds', 'dcms_my_cron_hook' );
    }
}

//desactivación del plugin
register_deactivation_hook( __FILE__, 'dcms_plugin_desativation' );
function dcms_plugin_desativation(){
    wp_clear_scheduled_hook( 'dcms_my_cron_hook' );
}

//Acción personalizada
add_action( 'dcms_my_cron_hook', 'dcms_my_process');
function dcms_my_process(){
	// error_log('Mi evento se ejecuto:'.Date("h:i:sa"));
	include GN_PLUGIN_DIR_PATH . "crom/correoSemanal.php";
}


//Registro de intervalos
add_filter('cron_schedules', 'dcms_my_custom_schedule');
function dcms_my_custom_schedule($schedules){
    
    $schedules['5seconds'] = array(
						'interval' => 604800,
						'display' =>_('1 ves a la semana')
				);
				
				return $schedules;
				
}


