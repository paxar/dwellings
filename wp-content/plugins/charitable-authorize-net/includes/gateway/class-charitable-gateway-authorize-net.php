<?php
/**
 * Authorize.Net Gateway class
 *
 * @version     1.0.0
 * @package     Charitable Authorize.Net/Classes/Charitable_Gateway_Authorize_Net
 * @author      Eric Daams
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

if ( ! class_exists( 'Charitable_Gateway_Authorize_Net' ) ) :

	/**
	 * Authorize.Net Gateway
	 *
	 * @since       1.0.0
	 */
	class Charitable_Gateway_Authorize_Net extends Charitable_Gateway {

		/**
		 * The gateway ID.
		 *
		 * @var     string
		 */
		const ID = 'authorize_net';

		/**
		 * Instantiate the gateway class, defining its key values.
		 *
		 * @access  public
		 * @since   1.0.0
		 */
		public function __construct() {

			$this->name = apply_filters( 'charitable_gateway_authorize_net_name', __( 'Authorize.Net', 'charitable-authorize-net' ) );

			$this->defaults = array(
				'label' => __( 'Authorize.Net', 'charitable-authorize-net' ),
			);

			$this->supports = array(
				'1.3.0',
				'credit-card',
				'recurring',
			);

			/**
			 * Needed for backwards compatibility with Charitable < 1.3
			 */
			$this->credit_card_form = true;

		}

		/**
		 * Returns the current gateway's ID.
		 *
		 * @return  string
		 * @access  public
		 * @static
		 * @since   1.0.0
		 */
		public static function get_gateway_id() {
			return self::ID;
		}

		/**
		 * Register the Authorize.Net payment gateway class.
		 *
		 * @param   string[] $gateways The list of gateways.
		 * @return  string[]
		 * @access  public
		 * @static
		 * @since   1.0.0
		 */
		public static function register_gateway( $gateways ) {
			$gateways['authorize_net'] = 'Charitable_Gateway_Authorize_Net';
			return $gateways;
		}

		/**
		 * Register gateway settings.
		 *
		 * @param   array[] $settings The settings to show on the Authorize.Net settings page.
		 * @return  array[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function gateway_settings( $settings ) {

			$settings['api_login_id'] = array(
				'type'      => 'text',
				'title'     => __( 'API Login ID', 'charitable-authorize-net' ),
				'priority'  => 6,
				'class'     => 'wide',
				'help' 		=> __( 'You can find your API Login ID in your Authorize.Net account by going to Account > API Credentials & Keys.', 'charitable-authorize-net' ),
			);

			$settings['transaction_key'] = array(
				'type'      => 'text',
				'title'     => __( 'Transaction Key', 'charitable-authorize-net' ),
				'priority'  => 8,
				'class'     => 'wide',
				'help' 		=> __( 'If you do not remember your current Transaction Key, you can set a new one in your Authorize.Net account by going to Account > API Credentials & Keys.', 'charitable-authorize-net' ),
			);

			$settings['client_key'] = array(
				'type'		=> 'text',
				'title'		=> __( 'Public Client Key', 'charitable-authorize-net' ),
				'priority'	=> 10,
				'class' 	=> 'wide',
				'help'		=> __( 'You can set your Public Client Key by going to Account > Manage Public Client Key and clicking on Create New Public Client Key. It is recommended, as it helps provide an extra layer of security for your credit card transactions.', 'charitable-authorize-net' ),
			);

			$sync_data = $this->get_value( 'sync' );

			if ( is_array( $sync_data ) ) {
				$last_sync = sprintf( __( 'Last synced: %s ago', 'charitable-authorize-net' ), human_time_diff( $sync_data['last_synced'], time() ) );
			} else {
				$last_sync = __( 'Last synced: Never', 'charitable-authorize-net' );
			}

			$settings['sync_tool'] = array(
				'type'			=> 'content',
				'content'		=> sprintf( '<a href="%s" class="button charitable-anet-sync-button"><span class="dashicons dashicons-update"></span>%s</a><span class="charitable-anet-sync-time-ago">%s</span><div class="charitable-help">%s</div>',
					add_query_arg( array(
						'charitable_action' => 'sync_authorize_net_fields',
						'page' 				=> 'charitable-settings',
						'tab' 				=> 'gateways',
						'group' 			=> 'gateways_authorize_net',
					), admin_url( 'admin.php' ) ),
					__( 'Sync Required Fields', 'charitable-authorize-net' ),
					$last_sync,
					__( 'You can choose which form fields are required for payments in your Authorize.Net account under Account > Payment Form > Form Fields. Use this tool to sync your Charitable donation form with your Authorize.Net settings.', 'charitable-authorize-net' )
				),
				'title'			=> __( 'Sync Settings with Authorize.Net Account', 'charitable-authorize-net' ),
				'priority' 		=> 20,
			);

			return $settings;

		}

		/**
		 * Returns an array of credit card fields.
		 *
		 * If the gateway requires different fields, this can simply be redefined
		 * in the child class.
		 *
		 * @return  array[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_credit_card_fields() {

			return apply_filters( 'charitable_authorize_net_credit_card_fields', array(
				'cc_number' => array(
					'label'     => __( 'Card Number', 'charitable-authorize-net' ),
					'type'      => 'text',
					'required'  => true,
					'priority'  => 4,
					'data_type' => 'gateway',
				),
				'cc_cvc' => array(
					'label'     => __( 'CVV Number', 'charitable-authorize-net' ),
					'type'      => 'text',
					'required'  => true,
					'priority'  => 6,
					'data_type' => 'gateway',
				),
				'cc_expiration' => array(
					'label'     => __( 'Expiration', 'charitable-authorize-net' ),
					'type'      => 'cc-expiration',
					'required'  => true,
					'priority'  => 8,
					'data_type' => 'gateway',
				),
			), $this );

		}

		/**
		 * Return the keys to use.
		 *
		 * @return  string[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_keys() {

			return array(
				'api_login_id'    => trim( $this->get_value( 'api_login_id' ) ),
				'client_key' 	  => trim( $this->get_value( 'client_key' ) ),
				'transaction_key' => trim( $this->get_value( 'transaction_key' ) ),
			);

		}

		/**
		 * Set which fields are required in the donation form.
		 *
		 * @param 	array $fields The array of fields in the donation form.
		 * @return  array
		 * @access  public
		 * @since   1.1.0
		 * @static
		 */
		public static function set_required_donation_form_fields( $fields ) {

			$settings  = charitable_get_option( 'gateways_' . self::get_gateway_id(), array() );

			if ( ! array_key_exists( 'sync', $settings ) ) {
				return $fields;
			}

			if ( ! is_array( $settings['sync'] ) || ! array_key_exists( 'fields', $settings['sync'] ) ) {
				return $fields;
			}

			foreach ( $settings['sync']['fields'] as $key ) {
				$fields[ $key ]['required'] = true;
			}

			return $fields;

		}

		/**
		 * Load Accept.JS, as well as our handling scripts.
		 *
		 * @return  boolean
		 * @access  public
		 * @static
		 * @since   1.1.0
		 */
		public static function enqueue_scripts() {

			if ( ! Charitable_Gateways::get_instance()->is_active_gateway( self::get_gateway_id() ) ) {
				return false;
			}

			if ( version_compare( charitable()->get_version(), '1.4.0', '<' ) ) {
				return false;
			}

			if ( ! wp_script_is( 'charitable-authorize-net-handler', 'registered' ) ) {
				return false;
			}

			wp_enqueue_script( 'charitable-authorize-net-handler' );

			return true;
		}

		/**
		 * Load Accept.JS, as well as our handling scripts.
		 *
		 * @uses    Charitable_Gateway_Authorize_Net::enqueue_scripts()
		 *
		 * @param   Charitable_Donation_Form $form The current form object.
		 * @return  boolean
		 * @access  public
		 * @static
		 * @since   1.1.0
		 */
		public static function maybe_setup_scripts_in_donation_form( $form ) {

			if ( ! is_a( $form, 'Charitable_Donation_Form' ) ) {
				return false;
			}

			if ( 'make_donation' !== $form->get_form_action() ) {
				return false;
			}

			return self::enqueue_scripts();

		}

		/**
		 * Enqueue Accept.js after a campaign loop if modal donations are in use.
		 *
		 * @uses    Charitable_Gateway_Authorize_Net::enqueue_scripts()
		 *
		 * @return  boolean
		 * @access  public
		 * @static
		 * @since   1.1.0
		 */
		public static function maybe_setup_scripts_in_campaign_loop() {

			if ( 'modal' !== charitable_get_option( 'donation_form_display', 'separate_page' ) ) {
				return false;
			}

			return self::enqueue_scripts();

		}

		/**
		 * Add hidden token field to the donation form.
		 *
		 * @param   array $fields The donation form's hidden fields.
		 * @return  array $fields
		 * @access  public
		 * @static
		 * @since   1.1.0
		 */
		public static function add_hidden_token_field( $fields ) {

			if ( ! Charitable_Gateways::get_instance()->is_active_gateway( self::get_gateway_id() ) ) {
				return $fields;
			}

			if ( version_compare( charitable()->get_version(), '1.4.0', '<' ) ) {
				return $fields;
			}

			$fields['anet_token'] = '';
			$fields['anet_token_description'] = '';

			return $fields;

		}

		/**
		 * If a Accept.JS token was submitted, set it to the gateways array.
		 *
		 * @param   array $fields The filtered values from the donation form submission.
		 * @param   array $submitted The raw POST data.
		 * @return  array
		 * @access  public
		 * @static
		 * @since   1.1.0
		 */
		public static function set_submitted_anet_token( $fields, $submitted ) {

			if ( isset( $submitted['anet_token'] ) ) {
				$fields['gateways']['authorize_net']['token']             = $submitted['anet_token'];
				$fields['gateways']['authorize_net']['token_description'] = isset( $submitted['anet_token_description'] ) ? $submitted['anet_token_description'] : 'COMMON.ACCEPT.INAPP.PAYMENT';
			}

			return $fields;

		}

		/**
		 * Return the submitted value for a gateway field.
		 *
		 * @param   string  $key    The key of the field we want to get.
		 * @param   mixed[] $values A set of values.
		 * @return  string|false
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_gateway_value( $key, $values ) {
			return isset( $values['gateways']['authorize_net'][ $key ] ) ? $values['gateways']['authorize_net'][ $key ] : false;
		}

		/**
		 * Return the submitted value for a gateway field.
		 *
		 * @param   string 						  $key       The key of the field we want to get.
		 * @param   Charitable_Donation_Processor $processor The donation processor.
		 * @return  string|false
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_gateway_value_from_processor( $key, Charitable_Donation_Processor $processor ) {
			return $this->get_gateway_value( $key, $processor->get_donation_data() );
		}

		/**
		 * Validate the submitted credit card details.
		 *
		 * @param   boolean $valid   Whether the donation is valid.
		 * @param   string  $gateway The gateway ID.
		 * @param   mixed[] $values  Values submitted by the donor.
		 * @return  boolean
		 * @access  public
		 * @static
		 * @since   1.0.0
		 */
		public static function validate_donation( $valid, $gateway, $values ) {

			if ( 'authorize_net' != $gateway ) {
				return $valid;
			}

			if ( ! isset( $values['gateways']['authorize_net'] ) ) {
				return false;
			}

			$gateway = new Charitable_Gateway_Authorize_Net();

			$keys = $gateway->get_keys();

			/* Make sure that the keys are set. */
			if ( empty( $keys['api_login_id'] ) || empty( $keys['transaction_key'] ) ) {

				charitable_get_notices()->add_error( __( 'Missing keys for Authorize.Net payment gateway. Unable to proceed with payment.', 'charitable-authorize-net' ) );
				return false;

			}

			/* Ensure that the token or all the credit card details are set */
			if ( false === $gateway->get_gateway_value( 'token', $values ) && ! $gateway->has_all_credit_card_details( $values ) ) {

				charitable_get_notices()->add_error( __( 'Missing credit card details. Unable to proceed with payment.', 'charitable-authorize-net' ) );
				return false;

			}

			return $valid;

		}

		/**
		 * Process the donation with the gateway.
		 *
		 * @param   mixed 						  $return      Default return value.
		 * @param   int 						  $donation_id ID of the donation.
		 * @param   Charitable_Donation_Processor $processor   The donation processor object.
		 * @return  boolean
		 * @access  public
		 * @static
		 * @since   1.0.0
		 */
		public static function process_donation( $return, $donation_id, $processor ) {

			$donation         = charitable_get_donation( $donation_id );
			$donor            = $donation->get_donor();
			$gateway          = new Charitable_Gateway_Authorize_Net();
			$ref_id           = 'ref' . time();
			$authentication   = $gateway->setup_merchant_authentication();
			$payment          = $gateway->setup_payment( $processor );
			$customer         = $gateway->setup_customer( $donor );
			$billing          = $gateway->setup_billing( $donor );
			$shipping 		  = $gateway->maybe_setup_shipping( $donor );

			/* Set these up as an array. */
			$args             = array(
				'donation'		 => $donation,
				'donor'			 => $donor,
				'reference_id'   => $ref_id,
				'authentication' => $authentication,
				'payment'		 => $payment,
				'customer'       => $customer,
				'billing'		 => $billing,
				'shipping'		 => $shipping,
			);

			/* Allow extensions to create the transaction request. */
			$request = apply_filters( 'charitable_authorize_net_transaction_request', false, $args, $processor );

			if ( false === $request ) {

				$transaction_type = new AnetAPI\TransactionRequestType();
				$transaction_type->setTransactionType( 'authCaptureTransaction' );
				$transaction_type->setAmount( $donation->get_total_donation_amount( true ) );
				$transaction_type->setPayment( $payment );
				$transaction_type->setCustomer( $customer );
				$transaction_type->setBillTo( $billing );

				if ( false !== $shipping ) {
					$transaction_type->setShipTo( $shipping );
				}

				$request = new AnetAPI\CreateTransactionRequest();
				$request->setMerchantAuthentication( $authentication );
				$request->setRefId( $ref_id );
				$request->setTransactionRequest( $transaction_type );

			}

			/* Finally, execute the request. */
			$response = $gateway->execute_with_api_response( $request );

			/* Check for a valid response value. */
			if ( is_null( $response ) || 'OK' != strtoupper( $response->getMessages()->getResultCode() ) ) {

				$errors = $response->getMessages()->getMessage();

				charitable_get_notices()->add_error( sprintf(
					__( '<strong>ERROR:</strong> %s %s', 'charitable-authorize-net' ),
					$errors[0]->getCode(),
					$errors[0]->getText()
				) );

				return false;

			}

			/* Make sure the ref ID is the same. */
			if ( $ref_id != $response->getRefId() ) {

				charitable_get_notices()->add_error( __( 'We were unable to verify your payment. Please try again.', 'charitable-authorize-net' ) );
				return false;

			}

			/* Set the transaction response to false unless we hear otherwise. */
			$success = false;

			/* Deal with standard transaction responses (i.e. not recurring). */
			if ( 'net\authorize\api\contract\v1\CreateTransactionResponse' == get_class( $response ) ) {

				$transaction_response = $response->getTransactionResponse();

				if ( is_null( $transaction_response ) ) {
					charitable_get_notices()->add_error( __( 'There was an error charging your credit card. Please try again.', 'charitable-authorize-net' ) );
					return false;
				}

				switch ( $transaction_response->getResponseCode() ) {

					/* Approved */
					case '1' :

						$status  = 'charitable-completed';
						$message = sprintf(
							__( 'The Authorize.Net transaction is complete. Transaction ID: %s.', 'charitable-authorize-net' ),
							$transaction_response->getTransId()
						);
						$success = true;

						break;

					/* Declined */
					case '2' :

						$status  = 'charitable-failed';
						$message = sprintf(
							__( 'The Authorize.Net transaction was declined. Transaction ID: %s.', 'charitable-authorize-net' ),
							$transaction_response->getTransId()
						);

						charitable_get_notices()->add_error( __( 'Your credit card details were declined by our payment processor. Please double-check they are correct and try again.', 'charitable-authorize-net' ) );

						break;

					/* Error */
					case '3' :

						$status  = 'charitable-failed';
						$message = sprintf(
							__( 'The Authorize.Net transaction failed with an error. Transaction ID: %s.', 'charitable-authorize-net' ),
							$transaction_response->getTransId()
						);

						charitable_get_notices()->add_error( __( 'Your credit card payment failed. Please try again.', 'charitable-authorize-net' ) );

						break;

					/* Held for review */
					case '4' :

						$status  = 'charitable-pending';
						$message = sprintf(
							__( 'The Authorize.Net transaction is held for review. Transaction ID: %s.', 'charitable-authorize-net' ),
							$transaction_response->getTransId()
						);
						$success = true;

						break;

				}

				$donation->update_donation_log( $message );

				$donation->update_status( $status );

			}

			/* Allow extensions to act on a successful donations. */
			$success = apply_filters( 'charitable_authorize_net_transaction_response', $success, $response, $donation, $processor );

			return $success;

		}

		/**
		 * Create a transaction request with Authorize.Net that passes completely empty fields.
		 *
		 * @return  array|void An array of errors if the transaction response worked. Dies otherwise.
		 * @access  public
		 * @since   1.1.0
		 * @static
		 */
		public static function do_empty_transaction() {

			$gateway        = new Charitable_Gateway_Authorize_Net();
			$ref_id         = 'ref' . time();
			$authentication = $gateway->setup_merchant_authentication();

			$credit_card = new AnetAPI\CreditCardType();
			$credit_card->setCardNumber( '4242424242424242' );
			$credit_card->setExpirationDate( date( 'Y-m', strtotime( '+1 year' ) ) );
			$credit_card->setCardCode( '123' );

			$payment = new AnetAPI\PaymentType();
			$payment->setCreditCard( $credit_card );

			$customer = new AnetAPI\CustomerDataType();
			$customer->setId( '123' );
			$billing  = new AnetAPI\CustomerAddressType();
			$shipping = new AnetAPI\NameAndAddressType();

			$transaction_type = new AnetAPI\TransactionRequestType();
			$transaction_type->setTransactionType( 'authCaptureTransaction' );
			$transaction_type->setAmount( 50 );
			$transaction_type->setPayment( $payment );
			$transaction_type->setCustomer( $customer );
			$transaction_type->setBillTo( $billing );
			$transaction_type->setShipTo( $shipping );

			$request = new AnetAPI\CreateTransactionRequest();
			$request->setMerchantAuthentication( $authentication );
			$request->setRefId( $ref_id );
			$request->setTransactionRequest( $transaction_type );

			$response = $gateway->execute_with_api_response( $request );

			/* Check for a valid response value. */
			if ( is_null( $response ) || $ref_id != $response->getRefId() ) {
				wp_die( __( 'Unable to test Authorize.Net gateway response. NULL response or mismatched reference ID.', 'charitable-authorize-net' ) );
			}

			$transaction_response = $response->getTransactionResponse();

			if ( is_null( $transaction_response ) ) {
				wp_die( __( 'Unable to test Authorize.Net gateway response. NULL transaction response.', 'charitable-authorize-net' ) );
			}

			return $transaction_response->getErrors();

		}

		/**
		 * Set up the merchant authentication object.
		 *
		 * @return  AnetAPI\MerchantAuthenticationType
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_merchant_authentication() {
			$keys = $this->get_keys();

			$authentication = new AnetAPI\MerchantAuthenticationType();
			$authentication->setName( $keys['api_login_id'] );
			$authentication->setTransactionKey( $keys['transaction_key'] );

			return $authentication;
		}

		/**
		 * Set up payment object with credit card details or opaque data (tokenized card data).
		 *
		 * @param   Charitable_Donation_Processor $processor
		 * @return  AnetAPI\PaymentType
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_payment( Charitable_Donation_Processor $processor ) {

			$payment = new AnetAPI\PaymentType();
			$values  = $processor->get_donation_data();

			/**
			 * Use a tokenized credit card when available.
			 */
			if ( $this->get_gateway_value( 'token', $values ) ) {

				$opaque = new AnetAPI\OpaqueDataType();
				$opaque->setDataDescriptor( $this->get_gateway_value( 'token_description', $values ) );
				$opaque->setDataValue( $this->get_gateway_value( 'token', $values ) );

				$payment->setOpaqueData( $opaque );

			} else {

				if ( ! $this->has_all_credit_card_details( $values ) ) {
					charitable_get_notices()->add_error( __( 'Missing credit card details. Unable to proceed with payment.', 'charitable-authorize-net' ) );
					return false;
				}

				$cc_expiration = $this->get_gateway_value( 'cc_expiration', $values );
				$credit_card   = new AnetAPI\CreditCardType();
				$credit_card->setCardNumber( $this->get_gateway_value( 'cc_number', $values ) );
				$credit_card->setExpirationDate( $cc_expiration['year'] . '-' . $cc_expiration['month'] );
				$credit_card->setCardCode( $this->get_gateway_value( 'cc_cvc', $values ) );

				$payment->setCreditCard( $credit_card );

			}

			return $payment;
		}

		/**
		 * Set up the customer.
		 *
		 * @param   Charitable_Donor $donor
		 * @return  mixed
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_customer( Charitable_Donor $donor ) {

			$customer = new AnetAPI\CustomerDataType();
			$customer->setId( $donor->donor_id );
			$customer->setEmail( $donor->get_email() );

			return $customer;

		}

		/**
		 * Set up the billing details.
		 *
		 * @param   Charitable_Donor $donor
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
			$phone 		= $donor->get_donor_meta( 'phone' );
			$billing    = new AnetAPI\CustomerAddressType();
			$billing->setFirstName( $first_name );
			$billing->setLastName( $last_name );
			$billing->setAddress( $address );
			$billing->setCity( $city );
			$billing->setState( $state );
			$billing->setZip( $postcode );
			$billing->setCountry( $country );
			$billing->setPhoneNumber( $phone );

			return $billing;

		}

		/**
		 * Set up the shipping details.
		 *
		 * @param   Charitable_Donor $donor
		 * @return  AnetAPI\CustomerAddressType|false Returns false if shipping is not required.
		 * @access  private
		 * @since   1.0.0
		 */
		private function maybe_setup_shipping( Charitable_Donor $donor ) {

			$sync = $this->get_value( 'sync' );

			if ( ! is_array( $sync ) || ! array_key_exists( 'shipping', $sync ) ) {
				return false;
			}

			if ( ! $sync['shipping'] ) {
				return false;
			}

			$first_name = $donor->get_donor_meta( 'first_name' );
			$last_name  = $donor->get_donor_meta( 'last_name' );
			$address    = $donor->get_donor_meta( 'address' );
			$city       = $donor->get_donor_meta( 'city' );
			$state      = $donor->get_donor_meta( 'state' );
			$postcode   = $donor->get_donor_meta( 'postcode' );
			$country    = $donor->get_donor_meta( 'country' );
			$shipping   = new AnetAPI\NameAndAddressType();
			$shipping->setFirstName( $first_name );
			$shipping->setLastName( $last_name );
			$shipping->setAddress( $address );
			$shipping->setCity( $city );
			$shipping->setState( $state );
			$shipping->setZip( $postcode );
			$shipping->setCountry( $country );

			return $shipping;

		}

		/**
		 * Execute the transaction request and pass back the API response.
		 *
		 * @param   object $request
		 * @return  \net\authorize\api\contract\v1\AnetApiResponseType
		 * @access  private
		 * @since   1.0.0
		 */
		private function execute_with_api_response( $request ) {

			$controller = apply_filters( 'charitable_authorize_net_transaction_controller', false, $request );

			if ( false === $controller ) {
				$controller = new AnetController\CreateTransactionController( $request );
			}

			if ( charitable_get_option( 'test_mode' ) ) {
				$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX );
			} else {
				$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION );
			}

			return $response;
		}

		/**
		 * Redirect back to the donation form, sending the donation ID back.
		 *
		 * @param   int $donation_id
		 * @return  void
		 * @access  public
		 * @static
		 * @since   1.0.0
		 */
		public static function redirect_to_donation_form( $donation_id ) {

			charitable_get_session()->add_notices();
			$redirect_url = esc_url( add_query_arg( array( 'donation_id' => $donation_id ), wp_get_referer() ) );
			wp_safe_redirect( $redirect_url );
			die();

		}

		/**
		 * Returns true if all credit card details are provided.
		 *
		 * @param   array $values
		 * @return  boolean
		 * @access  private
		 * @since   1.0.0
		 */
		private function has_all_credit_card_details( $values ) {

			if ( ! isset( $values['gateways']['authorize_net'] ) ) {
				return false;
			}

			$anet_values = $values['gateways']['authorize_net'];

			if ( empty( $anet_values['cc_number'] ) ) {
				return false;
			}

			if ( empty( $anet_values['cc_expiration'] ) || ! isset( $anet_values['cc_expiration']['month'] ) || ! isset( $anet_values['cc_expiration']['year'] ) ) {
				return false;
			}

			if ( empty( $anet_values['cc_cvc'] ) ) {
				return false;
			}

			return true;

		}

		/**
		 * This is required for compatibility with Charitable before version 1.3.
		 *
		 * @deprecated
		 */
		public static function process_donation_legacy( $donation_id, $processor ) {

			$result = self::process_donation( true, $donation_id, $processor );

			/**
			 * A false result means we need to be redirected back to
			 * the donation form.
			 */
			if ( ! $result ) {
				self::redirect_to_donation_form( $donation_id );
			}

		}
	}

endif; // End class_exists check
