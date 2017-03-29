<?php 
/**
 * Charitable Recurring Authorize.Net standard Hooks. 
 *
 * Action/filter hooks used for adding support for recurring donations to Authorize.Net gateway.
 * 
 * @package     Charitable Authorize.Net/Functions/Recurring Donations
 * @version     1.1.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2016, Eric Daams
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License  
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Add the MD5 Hash field as an extra setting.
 *
 * @see     Charitable_Authorize_Net_Recurring::Charitable_Authorize_Net_Recurring::()
 */
add_filter( 'charitable_settings_fields_gateways_gateway_authorize_net', array( Charitable_Authorize_Net_Recurring::get_instance(), 'add_md5_hash_settings_field' ), 20 );

/**
 * Set up the transaction request for recurring donations.
 *
 * @see     Charitable_Authorize_Net_Recurring::setup_transaction_request()
 */
add_filter( 'charitable_authorize_net_transaction_request', array( Charitable_Authorize_Net_Recurring::get_instance(), 'setup_transaction_request' ), 10, 3 );

/**
 * Set up the transaction controller for recurring donations.
 *
 * @see     Charitable_Authorize_Net_Recurring::setup_transaction_controller()
 */
add_filter( 'charitable_authorize_net_transaction_controller', array( Charitable_Authorize_Net_Recurring::get_instance(), 'setup_transaction_controller' ), 10, 2 );

/**
 * Respond to a successful transaction.
 *
 * @see     Charitable_Authorize_Net_Recurring::handle_transaction_response()
 */
add_action( 'charitable_authorize_net_transaction_response', array( Charitable_Authorize_Net_Recurring::get_instance(), 'handle_transaction_response' ), 10, 4 );

/**
 * Handle a Silent Post from Authorize.Net, which is used to notify the site when a recurring payment has been made.
 *
 * @see     Charitable_Authorize_Net_Recurring::process_silent_post()
 */
add_action( 'charitable_process_ipn_authorize_net', array( Charitable_Authorize_Net_Recurring::get_instance(), 'process_silent_post' ) );
