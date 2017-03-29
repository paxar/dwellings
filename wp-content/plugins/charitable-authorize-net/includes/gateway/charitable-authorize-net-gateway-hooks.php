<?php
/**
 * Charitable Gateway Hooks
 *
 * @package     Charitable Authorize.Net/Functions/Gateway
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
/**
 * Register our new gateway.
 *
 * @see     Charitable_Gateway_Authorize_Net::register_gateway()
 */
add_filter( 'charitable_payment_gateways', array( 'Charitable_Gateway_Authorize_Net', 'register_gateway' ) );

/**
 * Set up Accept.JS in the donation form.
 *
 * @see     Charitable_Gateway_Authorize_Net::maybe_setup_scripts_in_donation_form()
 */
add_action( 'charitable_form_after_fields', array( 'Charitable_Gateway_Authorize_Net', 'maybe_setup_scripts_in_donation_form' ) );

/**
 * Maybe enqueue the Accept.JS script after a campaign loop, if modal donations are in use.
 *
 * @see     Charitable_Gateway_Authorize_Net::maybe_setup_scripts_in_campaign_loop()
 */
add_action( 'charitable_campaign_loop_after', array( 'Charitable_Gateway_Authorize_Net', 'maybe_setup_scripts_in_campaign_loop' ) );

/**
 * Include the Authorize.Net token field in the donation form.
 *
 * @see     Charitable_Gateway_Authorize_Net::add_hidden_token_field()
 */
add_filter( 'charitable_donation_form_hidden_fields', array( 'Charitable_Gateway_Authorize_Net', 'add_hidden_token_field' ) );

/**
 * Also make sure that the Authorize.Net token is picked up in the values array.
 *
 * @see     Charitable_Gateway_Authorize_Net::set_submitted_anet_token()
 */
add_filter( 'charitable_donation_form_submission_values', array( 'Charitable_Gateway_Authorize_Net', 'set_submitted_anet_token' ), 10, 2 );

/**
 * Validate the donation form submission before processing.
 *
 * @see     Charitable_Gateway_Authorize_Net::validate_donation()
 */
add_filter( 'charitable_validate_donation_form_submission_gateway', array( 'Charitable_Gateway_Authorize_Net', 'validate_donation' ), 10, 3 );

/**
 * Process the donation.
 *
 * @see     Charitable_Gateway_Authorize_Net::process_donation()
 */
if ( -1 == version_compare( charitable()->get_version(), '1.3.0' ) ) {
	/**
	 * This is for backwards-compatibility. Charitable before 1.3 used on ation hook, not a filter.
	 *
	 * @see     Charitable_Gateway_Authorize_Net::process_donation_legacy()
	 */
	add_action( 'charitable_process_donation_authorize_net', array( 'Charitable_Gateway_Authorize_Net', 'process_donation_legacy' ), 10, 2 );
} else {
	add_filter( 'charitable_process_donation_authorize_net', array( 'Charitable_Gateway_Authorize_Net', 'process_donation' ), 10, 3 );
}

/**
 * Set the required donation form fields to match the settings in Authorize.Net.
 *
 * @see     Charitable_Gateway_Authorize_Net::set_required_donation_form_fields()
 */
add_filter( 'charitable_donation_form_user_fields', array( 'Charitable_Gateway_Authorize_Net', 'set_required_donation_form_fields' ) );
