<?php
/**
 * Plugin Name: Api Consumer
 * Description: Plugin to send elementor form to API
 * Plugin URI:  https://github.com/lucassdantas/wp-api-consumer.git
 * Version:     1.0.0
 * Author:      R&D Marketing Digital
 * Author URI:  https://rdmarketing.com.br/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if(!function_exists('add_action')){
    die;
}
add_action( 'elementor_pro/forms/new_record', function( $record, $ajax_handler ) {
    // Certifique-se de que é o nosso formulário
    $form_name = $record->get_form_settings( 'form_name' );
    if ( 'criar_conta' !== $form_name ) {
        return;
    }
    
    // Normalize os campos
    $raw_fields = $record->get( 'fields' );
    $fields = [];
    foreach ( $raw_fields as $id => $field ) {
        $fields[ $id ] = $field['value'];
    }
    if($fields['photoBase64'] != ''){
        require_once plugin_dir_path(__FILE__) . 'src/url_to_base64.php';
        $fields['photoBase64'] = url_to_base64($fields['photoBase64']);
    }
    // Prepare os dados para a solicitação
    $request_data = array(
        'userName' => $fields['userName'],
        'email' => $fields['emailField'],
        'confirmEmail' => $fields['confirmEmail'],
        'password' => $fields['password'],
        'confirmPassword' => $fields['confirmPassword'],
        'photoBase64' => $fields['photoBase64'],
        'cellPhone' => $fields['cellPhone']
    );

    // Realize a solicitação POST
    $response = wp_remote_post(
        'https://prisma.dev.br/api/signup',
        array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(
                'Content-Type' => 'application/json'
            ),
            'body'        => wp_json_encode( $request_data ),
        )
    );

    // Verifique se houve um erro na solicitação
    if( is_wp_error( $response ) ) {
        $ajax_handler->data['output'] = $response->get_error_message();
    } else {
        // A resposta está no corpo (body) da resposta
        $ajax_handler->data['output'] = wp_remote_retrieve_body( $response );
    }
}, 10, 2);
