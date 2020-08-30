<?php



if ( ! defined( 'ABSPATH' ) ) exit; 



include GN_PLUGIN_DIR_PATH . 'controllers/gestion-empleados.php';


if(isset($_POST["actualizar_salario_temporal"])){

		include GN_PLUGIN_DIR_PATH . 'controllers/gestion-salarios.php';

}else if(isset($_POST["actualizar_hora_extra"])){

		include GN_PLUGIN_DIR_PATH . 'controllers/gestion-hora-extra.php';	

}else if(isset($_POST['actualizar_gestion_hora'])){
		
		include GN_PLUGIN_DIR_PATH . 'controllers/gestion-hora.php';

}else if(isset($_POST["jornada_diaria"])){

		include GN_PLUGIN_DIR_PATH . 'controllers/gestion-jornada-diaria.php';	

}else if(isset($_POST["bono_navidad"])){

	include GN_PLUGIN_DIR_PATH . 'controllers/gestion-bono-navidad.php';
		
}else if(isset($_POST["comision"])){

	include GN_PLUGIN_DIR_PATH . 'controllers/gestion-comision.php';

}else if(isset($_POST["pagos"])){

	include GN_PLUGIN_DIR_PATH . 'controllers/gestion-pagos.php';

}else if(isset($_POST["actualizar_usuarios"])){

	include GN_PLUGIN_DIR_PATH . 'controllers/gestion-usuarios.php';
	
}

	




