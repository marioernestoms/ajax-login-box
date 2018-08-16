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
 * CONSTANTS
 */

if ( ! defined( 'AJB_DIR' ) ) {
	define( 'AJB_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'AJB_URL' ) ) {
	define( 'AJB_URL', plugin_dir_url( __FILE__ ) );
}

/**
* FILE INCLUDES
*/

include_once( AJB_DIR . '/inc/send-ajax-login.php' );

function test_ajax_load_scripts() {
	// load our jquery file that sends the $.post request
	wp_enqueue_script( "ajax-test", plugin_dir_url( __FILE__ ) . '/ajax-login-script.js', array( 'jquery' ) );
 
	// make the ajaxurl var available to the above script
	wp_localize_script( 'ajax-test', 'the_ajax_script', array( 
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' 	 => home_url() . '/',
		'loadingmessage' => __( 'Enviando as informações, aguarde ...' ),
	));

	// Enable the user with no privileges to run ajax_login() in AJAX.
	add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );

}
add_action('wp_print_scripts', 'test_ajax_load_scripts');

add_action('init', 'ajax_auth_init');
function ajax_auth_init()
{
    if(!is_user_logged_in()) return;
    // rest of your code
}
