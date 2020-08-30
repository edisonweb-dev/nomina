<?php

if ( ! defined( 'ABSPATH' ) ) exit; 


function new_roles() {
    
        add_role( 'secretary', 'Secretary', array( 'read' => true, 'level_0' => true ) );

        add_role( 'admin', 'Administrador General', array( 'read' => true, 'level_0' => true ) );
       
}
add_action( 'init', 'new_roles' );