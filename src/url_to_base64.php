<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if(!function_exists('add_action')){
    die;
}

function url_to_base64($url) {
    $response = wp_remote_get($url);
    if (is_array($response) && !is_wp_error($response)) {
        $image_data = wp_remote_retrieve_body($response);
        if ($image_data) {
            $base64_image = base64_encode($image_data);
            return $base64_image;
        }
    }
    return false;
}
