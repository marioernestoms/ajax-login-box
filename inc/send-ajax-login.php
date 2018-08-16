<?php
/**
 * ------------------------------
 * Function to send ajax login.
 * ------------------------------
 */
function ajax_login() {

	// First check the nonce, if it fails the function will break.
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	// Nonce is checked, get the POST data and sign user on.
	$info = array();
	$info['user_login'] = filter_input( INPUT_POST, 'username' );
	$info['user_password'] = filter_input( INPUT_POST, 'password' );
	$info['remember'] = true;

	$user_signon = wp_signon( $info, false );
	if ( is_wp_error( $user_signon ) ) {
		echo wp_json_encode( array(
			'loggedin'	=> false,
			'message'	=> __( 'Usuário ou senha inválido.' ),
		));
	} else {
		echo wp_json_encode( array(
			'loggedin'	=> true,
			'message'	=> __( 'Logado com sucesso, redirecionando ...' ),
			)
		);
	}

	die();
}
