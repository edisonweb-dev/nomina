<?php

function get_upload_file_link()
{   
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    require_once ABSPATH . "wp-admin" . '/includes/image.php';
    require_once ABSPATH . "wp-admin" . '/includes/file.php';
    require_once ABSPATH . "wp-admin" . '/includes/media.php';
    
    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                echo "upload error : " . $_FILES[$file]['error'];
                die;
            }

            $attachment_id = media_handle_upload($file, 0);

            
        }

        $attachment_url = wp_get_attachment_link( $attachment_id );
        return  $attachment_url;
    }
}

function get_upload_file_url()
{   
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    require_once ABSPATH . "wp-admin" . '/includes/image.php';
    require_once ABSPATH . "wp-admin" . '/includes/file.php';
    require_once ABSPATH . "wp-admin" . '/includes/media.php';
    
    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                echo "upload error : " . $_FILES[$file]['error'];
                die;
            }

            $attachment_id = media_handle_upload($file, 0);

            
        }

        $attachment_url = wp_get_attachment_url( $attachment_id );
        return  $attachment_url;
    }
}

function get_upload_file_url_id_file()
{   
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    require_once ABSPATH . "wp-admin" . '/includes/image.php';
    require_once ABSPATH . "wp-admin" . '/includes/file.php';
    require_once ABSPATH . "wp-admin" . '/includes/media.php';
    
    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                echo "upload error : " . $_FILES[$file]['error'];
                die;
            }

            $attachment_id = media_handle_upload($file, 0);

            
        }

        $attachment_url = wp_get_attachment_url( $attachment_id );
        return  $attachment_url." ".$attachment_id;
    }
}