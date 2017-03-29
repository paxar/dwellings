<?php
/**
 * Charitable Authorize.Net admin hooks.
 *
 * @package     Charitable Authorize.Net/Functions/Admin
 * @version     1.0.2
 * @author      Eric Daams
 * @copyright   Copyright (c) 2016, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Add a direct link to the Extensions settings page from the plugin row.
 *
 * @see     Charitable_Authorize_Net_Admin::add_plugin_action_links()
 */
add_filter( 'plugin_action_links_' . plugin_basename( Charitable_Authorize_Net::get_instance()->get_path() ), array( Charitable_Authorize_Net_Admin::get_instance(), 'add_plugin_action_links' ) );

/**
 * Get the required fields from Authorize.Net.
 *
 * @see     Charitable_Authorize_Net_Admin::get_authorize_net_required_fields()
 */
add_action( 'charitable_sync_authorize_net_fields', array( Charitable_Authorize_Net_Admin::get_instance(), 'get_authorize_net_required_fields' ) );

/**
 * Sync the required fields through an AJAX request.
 *
 * @see     Charitable_Authorize_Net_Admin::ajax_get_authorize_net_required_fields()
 */
add_action( 'wp_ajax_charitable_sync_authorize_net_fields', array( Charitable_Authorize_Net_Admin::get_instance(), 'ajax_get_authorize_net_required_fields' ) );

/**
 * Don't lose the synced fields when updating other settings.
 *
 * @see     Charitable_Authorize_Net_Admin::save_authorize_net_settings()
 */
add_filter( 'charitable_save_settings', array( Charitable_Authorize_Net_Admin::get_instance(), 'save_authorize_net_settings' ), 10, 3 );
