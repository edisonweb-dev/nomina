<?php 


if ( ! defined( 'ABSPATH' ) ) exit; 

require_once(ABSPATH . 'wp-includes/pluggable.php');
require_once(ABSPATH . 'wp-includes/capabilities.php');
require_once(ABSPATH . 'wp-includes/user.php');

global $wpdb;

global $guardado_empleado;


if(isset($_POST['guardar_nuevo_usuarios'])){


  $hash = wp_hash_password( $_POST["usuario_clave"] );   

  $data = [

      "user_login"  => $_POST["usuario_nombreUsuario"],
      "user_pass"   => $hash,
      "user_nicename" => $_POST["usuario_nombreUsuario"],
      "user_email"  => $_POST["usuario_correo"]
  ];

  
  $guardar = $wpdb->insert(
    TABLA_USUARIOS,
    $data
  );

  //********* obtener id empleado crear su rol **************/  
  $id_empleado = $wpdb->insert_id;   

  $registrar_usuarios = new WP_User($id_empleado);
  $registrar_usuarios->add_role($_POST["usuario_rol"]);
  //********* Fin obtener id empleado crear su rol **************/  

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

      $guardado_empleado = 2;

  }


}else if(isset($_POST['editar_nuevo_usuarios'])){

  if(!empty($_POST["usuario_clave"])){

    $hash = wp_hash_password( $_POST["usuario_clave"] );   

    $data = [

        "user_login"  => $_POST["usuario_nombreUsuario"],
        "user_pass"   => $hash,
        "user_nicename" => $_POST["usuario_nombreUsuario"],
        "user_email"  => $_POST["usuario_correo"]
    ];

  }else{

    $data = [
      "user_login"  => $_POST["usuario_nombreUsuario"],
      "user_nicename" => $_POST["usuario_nombreUsuario"],
      "user_email"  => $_POST["usuario_correo"]
    ];

  }

  $guardar = $wpdb->update(
    TABLA_USUARIOS, 
    $data,
    array( 'ID' => $_POST["id_usuario_form"] )
  );

  //********* obtener id empleado crear su rol **************/  
  $registrar_usuarios = new WP_User($_POST["id_usuario_form"]);
  $registrar_usuarios->set_role($_POST["usuario_rol"]);
  //********* Fin obtener id empleado crear su rol **************/ 


  $guardado_empleado = 0;

  if($guardar){

  $guardado_empleado = 1;

  }else{

  $guardado_empleado = 2;

  }

  



}else if(isset($_POST['eliminar_nuevo_usuarios'])){


  $guardar = $wpdb->delete( TABLA_USUARIOS, 
      array( 'ID' => $_POST['id_usuario_form']) );

  $guardado_empleado = 0;

  if($guardar){

    $guardado_empleado = 1;

  }else{

    $guardado_empleado = 2;

  }

}



?>