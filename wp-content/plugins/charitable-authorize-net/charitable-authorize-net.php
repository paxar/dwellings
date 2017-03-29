<?php
/**
 * Plugin Name: 		Charitable - Authorize.Net
 * Plugin URI: 			https://www.wpcharitable.com/extensions/charitable-authorize-net/
 * Description: 		Accept donations with Authorize.Net.
 * Version: 			1.1.3
 * Author: 				WP Charitable
 * Author URI: 			https://www.wpcharitable.com
 * Requires at least: 	4.2
 * Tested up to: 		4.7.3
 *
 * Text Domain: 		charitable-authorize-net
 * Domain Path: 		/languages/
 *
 * @package 			Charitable Authorize.Net
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
function charitable_authorize_net_load() {
	require_once( 'includes/class-charitable-authorize-net.php' );

	$has_dependencies = true;

	/* Check for Charitable */
	if ( ! class_exists( 'Charitable' ) ) {

		if ( ! class_exists( 'Charitable_Extension_Activation' ) ) {

			require_once 'includes/admin/class-charitable-extension-activation.php';

		}

		$activation = new Charitable_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();

		$has_dependencies = false;

	} else {

		new Charitable_Authorize_Net( __FILE__ );

	}
}

add_action( 'plugins_loaded', 'charitable_authorize_net_load', 1 );
