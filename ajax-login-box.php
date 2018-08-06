<?php
/**
 * Plugin Name: Ajax Login Box
 * Plugin URI: https://github.com/marioernestoms/ajax-login-box
 * Description: Display a box with the author's biography and also social icons in bottom of the post.
 * Version: 1.0.0
 * Author: marioernestoms
 * Author URI: http://marioernestoms.com/
 * Text Domain: ajax-login-box
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/marioernestoms/ajax-login-box
 *
 * @package ajax-login-box
 */

/**
 * ------------------------------
 * Function to start ajax login.
 * ------------------------------
 */
function ajax_login_init() {

	wp_register_script( 'ajax-login-script', get_stylesheet_directory_uri() . '/assets/js/ajax-login-script.js', array( 'jquery' ) );
	wp_enqueue_script( 'ajax-login-script' );

	wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
		'ajaxurl' 		 => admin_url( 'admin-ajax.php' ),
		'redirecturl' 	 => home_url() . '/coletas',
		'loadingmessage' => __( 'Enviando as informações, aguarde ...' ),
	));

	// Enable the user with no privileges to run ajax_login() in AJAX.
	add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in.
if ( ! is_user_logged_in() ) {
	add_action( 'init', 'ajax_login_init' );
}

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