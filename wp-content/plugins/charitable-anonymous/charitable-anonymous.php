<?php
/**
 * Plugin Name: 		Charitable - Anonymous Donations
 * Plugin URI: 			https://www.wpcharitable.com/extensions/charitable-anonymous-donations/
 * Description: 		Allow your supporters to donate anonymously.
 * Version: 			1.1.3
 * Author:              WP Charitable
 * Author URI:          https://www.wpcharitable.com
 * Requires at least: 	4.2
 * Tested up to: 		4.6
 *
 * Text Domain: 		charitable-anonymous
 * Domain Path: 		/languages/
 *
 * @package 			Charitable Anonymous
 * @category 			Core
 * @author 				Studio164a
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Load plugin class, but only if Charitable is found and activated.
 *
 * @return 	void
 * @since 	1.0.0
 */
function charitable_anonymous_load() {	
	require_once( 'includes/class-charitable-anonymous.php' );

	$has_dependencies = true;

	/* Check for Charitable */
	if ( ! class_exists( 'Charitable' ) ) {

		if ( ! class_exists( 'Charitable_Extension_Activation' ) ) {

			require_once 'includes/class-charitable-extension-activation.php';

		}

		$activation = new Charitable_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();

		$has_dependencies = false;
	} 
	else {

		new Charitable_Anonymous( __FILE__ );

	}	
}

add_action( 'plugins_loaded', 'charitable_anonymous_load', 1 );