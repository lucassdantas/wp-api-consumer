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
	//make sure its our form
	$form_name = $record->get_form_settings( 'form_name' );
	if ( 'criar_conta' !== $form_name ) {
		return;
	}
	//normalize the fields
	$raw_fields = $record->get( 'fields' );
	$fields = [];
	foreach ( $raw_fields as $id => $field ) {
		$fields[ $id ] = $field['value'];
	}
	wp_remote_post(
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
			'body'        => array(
				'userName' => 'bob',
				'email' => '1234xyz',
				'confirmEmail' => '1234xyz',
				'password' => '1234xyz',
				'confirmPassword' => '1234xyz',
				'photoBase64' => '1234xyz',
				'cellPhone' => '1234xyz'
			),
		)
	);
	$ajax_handler->data['output'] = 'INFORM_02 Output is: ' . $fields['email'];
}, 10, 2);