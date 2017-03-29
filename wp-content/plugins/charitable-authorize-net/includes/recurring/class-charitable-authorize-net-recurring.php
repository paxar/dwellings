<?php
/**
 * Add recurring donations support.
 *
 * @version     1.1.0
 * @package     Charitable Authorize.Net/Classes/Charitable_Authorize_Net_Recurring
 * @author      Eric Daams
 * @copyright   Copyright (c) 2016, Eric Daams
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

if ( ! class_exists( 'Charitable_Authorize_Net_Recurring' ) ) :

	/**
	 * Authorize.Net Payment Gateway support
	 *
	 * @since       1.1.0
	 */
	class Charitable_Authorize_Net_Recurring {

		/**
		 * The single instance of this class.
		 *
		 * @var     Charitable_Authorize_Net_Recurring|null
		 * @access  private
		 * @static
		 */
		private static $instance = null;

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @return  Charitable_Authorize_Net_Recurring
		 * @access  public
		 * @since   1.1.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new Charitable_Authorize_Net_Recurring();
			}

			return self::$instance;
		}

		/**
		 * Add a settings field for the md5 hash.
		 *
		 * @param   array $settings The array of settings on the Authorize.Net settings page.
		 * @return  array
		 * @access  public
		 * @since   1.1.0
		 */
		public function add_md5_hash_settings_field( $settings ) {

			$settings['md5_hash'] = array(
				'type'      => 'text',
				'title'     => __( 'MD5 Hash', 'charitable-recurring' ),
				'priority'  => 12,
				'class'     => 'wide',
				'help'      => __( '<strong>Recommended for recurring donations.</strong> You can set your MD5 Hash in your Authorize.Net account by going to Account > MD5-Hash. The hash can be any value you choose, as long as it\'s the same in your Authorize.Net as it is here.', 'charitable-recurring' ),
			);

			return $settings;
		}

		/**
		 * Add subscription data for the donation to the transaction object.
		 *
		 * @param   mixed                         $ret       The default response to send to the client.
		 * @param   array                         $args      Array of arguments related to the donation.
		 * @param   Charitable_Donation_Processor $processor The donation processor.
		 * @return  AnetAPI\CreateTransactionRequest
		 * @access  public
		 * @since   1.1.0
		 */
		public function setup_transaction_request( $ret, $args, Charitable_Donation_Processor $processor ) {

			/* Bail straight away if no donation plan is set. */
			if ( ! $processor->get_donation_data_value( 'donation_plan', false ) ) {
				return $ret;
			}

			$recurring_id = $processor->get_donation_data_value( 'donation_plan' );
			$schedule     = $this->setup_payment_schedule( $processor );
			$customer     = $this->setup_customer( $args['donor'] );
			$billing      = $this->setup_billing( $args['donor'] );

			/* Create the subscription. */
			$subscription = new AnetAPI\ARBSubscriptionType();
			$subscription->setName( sprintf( __( 'Subscription #%d', 'charitable-authorize-net' ), $recurring_id ) );
			$subscription->setPaymentSchedule( $schedule );
			$subscription->setAmount( $args['donation']->get_total_donation_amount( true ) );
			$subscription->setPayment( $args['payment'] );
			$subscription->setBillTo( $billing );
			$subscription->setCustomer( $customer );

			if ( false !== $args['shipping'] ) {
				$subscription->setShipTo( $args['shipping'] );
			}

			/* Create the subscription request. */
			$request = new AnetAPI\ARBCreateSubscriptionRequest();
			$request->setmerchantAuthentication( $args['authentication'] );
			$request->setRefId( $args['reference_id'] );
			$request->setSubscription( $subscription );

			return $request;

		}

		/**
		 * Setup the transaction controller object.
		 *
		 * @param   object $ret     The default controller object.
		 * @param   object $request The request object.
		 * @return  object
		 * @access  public
		 * @since   1.1.0
		 */
		public function setup_transaction_controller( $ret, $request ) {

			if ( is_a( $request, 'net\authorize\api\contract\v1\ARBCreateSubscriptionRequest' ) ) {
				$ret = new AnetController\ARBCreateSubscriptionController( $request );
			}

			return $ret;

		}

		/**
		 * Respond to a transaction.
		 *
		 * @param 	boolean 					  $success   The default response to send to the client.
		 * @param 	mixed      					  $response  Response received from Authorize.Net.
		 * @param 	Charitable_Donation 		  $donation  Donation object created.
		 * @param 	Charitable_Donation_Processor $processor The donation processor.
		 * @return  boolean
		 * @access  public
		 * @since   1.1.0
		 */
		public function handle_transaction_response( $success, $response, Charitable_Donation $donation, Charitable_Donation_Processor $processor ) {

			$recurring_id = $processor->get_donation_data_value( 'donation_plan', false );

			/* Bail straight away if no donation plan is set. */
			if ( ! $recurring_id ) {
				return $success;
			}

			/* Mark the donation as Paid. */
			$donation->update_donation_log( sprintf(
				__( 'The Authorize.Net transaction is complete. Subscription ID: %s.', 'charitable-authorize-net' ),
				$response->getSubscriptionId()
			) );

			$donation->update_status( 'charitable-completed' );

			/* Save the subscription ID. */
			$subscription = charitable_get_donation( $recurring_id );

			$subscription->set_gateway_subscription_id( $response->getSubscriptionId() );

			$subscription->update_donation_log( sprintf( __( 'Authorize.Net subscription ID: %s.', 'charitable-authorize-net' ), $response->getSubscriptionId() ) );

			$subscription->update_status( 'charitable-active' );

			return true;

		}

		/**
		 * Return the schedule to be used for the recurring donation.
		 *
		 * @param   Charitable_Donation_Processor $processor The donation processor.
		 * @return  AnetAPI\PaymentScheduleType
		 * @access  private
		 * @since   1.1.0
		 */
		private function setup_payment_schedule( $processor ) {

			$interval = $processor->get_donation_data_value( 'donation_interval', 1 );
			$period   = $processor->get_donation_data_value( 'donation_period', false );

			switch ( strtolower( $period ) ) {
				case 'day':
					$period = 'days';
					break;
				case 'week':
					$period   = 'days';
					$interval = $interval * 7;
					break;
				case 'year':
					$period   = 'months';
					$interval = $interval * 12;
					break;
				case 'month':
					$period = 'months';
					break;
			}

			$interval_type = new AnetAPI\PaymentScheduleType\IntervalAType();
			$interval_type->setLength( $interval );
			$interval_type->setUnit( $period );

			$payment_schedule = new AnetAPI\PaymentScheduleType();
			$payment_schedule->setInterval( $interval_type );
			$payment_schedule->setStartDate( new DateTime() );
			$payment_schedule->setTotalOccurrences( 9999 );

			return $payment_schedule;

		}

		/**
		 * Return the customer object.
		 *
		 * @param   Charitable_Donor $donor The donor object.
		 * @return  AnetAPI\CustomerType
		 * @access  private
		 * @since   1.1.0
		 */
		private function setup_customer( $donor ) {

			$customer = new AnetAPI\CustomerType();
			$customer->setId( $donor->donor_id );
			$customer->setEmail( $donor->get_email() );

			return $customer;

		}

		/**
		 * Set up the billing details.
		 *
		 * @param   Charitable_Donor $donor The donor object.
		 * @return  AnetAPI\CustomerAddressType
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_billing( Charitable_Donor $donor ) {

			$first_name = $donor->get_donor_meta( 'first_name' );
			$last_name  = $donor->get_donor_meta( 'last_name' );
			$address    = $donor->get_donor_meta( 'address' );
			$city       = $donor->get_donor_meta( 'city' );
			$state      = $donor->get_donor_meta( 'state' );
			$postcode   = $donor->get_donor_meta( 'postcode' );
			$country    = $donor->get_donor_meta( 'country' );

			$billing = new AnetAPI\NameAndAddressType();
			$billing->setFirstName( $first_name );
			$billing->setLastName( $last_name );
			$billing->setAddress( $address );
			$billing->setCity( $city );
			$billing->setState( $state );
			$billing->setZip( $postcode );
			$billing->setCountry( $country );

			return $billing;

		}

		/**
		 * Process a Silent Post from Authorize.Net.
		 *
		 * This is used to record ongoing donations as part of subscriptions.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.1.0
		 */
		public function process_silent_post() {

			$gateway = new Charitable_Gateway_Authorize_Net;

			if ( ! $this->is_silent_post_valid( $_POST ) ) {
				die( __( 'Recurring Donation IPN: Security check failed', 'charitable-recurring' ) );
				return;
			}

			$subscription_id = intval( $_POST['x_subscription_id'] );

			if ( ! $subscription_id ) {
				die( __( 'Recurring Donation IPN: Missing subscription ID', 'charitable-recurring' ) );
				return;
			}

			$response_code = intval( $_POST['x_response_code'] );
			$reason_code   = intval( $_POST['x_response_reason_code'] );

			$subscription  = charitable_recurring_get_subscription_by_gateway_id( $subscription_id, $gateway->get_gateway_id() );

			if ( empty( $subscription ) ) {
				die( __( 'Recurring Donation IPN: Missing subscription', 'charitable-recurring' ) );
			}

			/* New donation approved. */
			if ( 1 == $response_code ) {

				$subscription->create_renewal_donation( array( 'status' => 'charitable-completed' ) );

				die( __( 'Recurring Donation IPN: Donation completed', 'charitable-recurring' ) );

				/* New donation declined. */
			} elseif ( 2 == $response_code ||  3 == $response_code || 8 == $reason_code ) {

				$reason  = array_key_exists( 'x_response_reason_text', $_POST ) ? $_POST['x_response_reason_text'] : '-';

				$message = sprintf(
					__( 'Payment failed. Reason provided by gateway: %s', 'charitable-recurring' ),
					$reason
				);

				$recurring->set_to_failed( __( 'Recurring payment was declined.', 'charitable-recurring' ) );

				die( __( 'Recurring Donation IPN: Donation failed', 'charitable-recurring' ) );

			}

		}

		/**
		 * Determines if the silent post is valid by verifying the MD5 Hash
		 *
		 * @param   array $request Posted values from Authorize.Net.
		 * @return  bool
		 * @access  public
		 * @since   1.1.0
		 */
		public function is_silent_post_valid( $request ) {

			if ( ! array_key_exists( 'x_MD5_Hash', $request ) ) {
				return false;
			}

			$str = charitable_get_option( array( 'gateways_authorize_net', 'md5_hash' ) ) . $request['x_trans_id'] . $request['x_amount'];

			return hash_equals( md5( $str ), $request['x_MD5_Hash'] );
		}
	}

endif; // End class_exists check.
