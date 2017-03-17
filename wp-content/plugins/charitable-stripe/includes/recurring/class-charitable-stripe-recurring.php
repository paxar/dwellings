<?php
/**
 * Add recurring donations support.
 *
 * @version     1.2.0
 * @package     Charitable Stripe/Classes/Charitable_Stripe_Recurring
 * @author      Eric Daams
 * @copyright   Copyright (c) 2016, Eric Daams
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
if ( ! class_exists( 'Charitable_Stripe_Recurring' ) ) :

	/**
	 * Stripe Payment Gateway support
	 *
	 * @since       1.2.0
	 */
	class Charitable_Stripe_Recurring {

		/**
		 * The single instance of this class.
		 *
		 * @var     Charitable_Stripe_Recurring|null
		 * @access  private
		 * @static
		 */
		private static $instance = null;

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @return  Charitable_Stripe_Recurring
		 * @access  public
		 * @since   1.2.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new Charitable_Stripe_Recurring();
			}

			return self::$instance;
		}

		/**
		 * Add subscription data for the donation to the transaction object.
		 *
		 * @param   mixed                         $return The result of the gateway processing.
		 * @param   int                           $donation_id The donation ID.
		 * @param   Charitable_Donation_Processor $processor The Donation Processor helper.
		 * @return  boolean
		 * @access  public
		 * @since   1.2.0
		 */
		public function maybe_process_recurring_donation( $return, $donation_id, Charitable_Donation_Processor $processor ) {

			/* Bail straight away if no donation plan is set. */
			if ( ! $processor->get_donation_data_value( 'donation_plan', false ) ) {
				return $return;
			}

			$recurring_id = $processor->get_donation_data_value( 'donation_plan' );

			if ( ! $recurring_id ) {
				return $return;
			}

			/**
			 * First of all, let's cancel the subsequent transaction
			 * processing since this is a recurring donation.
			 */
			remove_action( 'charitable_process_donation_stripe', array( 'Charitable_Gateway_Stripe', 'process_donation_legacy' ), 10, 2 );
			remove_filter( 'charitable_process_donation_stripe', array( 'Charitable_Gateway_Stripe', 'process_donation' ), 10, 3 );

			$recurring 	  = charitable_get_donation( $recurring_id );
			$donation     = new Charitable_Donation( $donation_id );
			$donor        = $donation->get_donor();
			$campaign_id  = current( $donation->get_campaign_donations() )->campaign_id;
			$gateway 	  = new Charitable_Gateway_Stripe();
			$gateway_id   = $gateway::get_gateway_id();
			$keys         = $gateway->get_keys();

			\Stripe\Stripe::setApiKey( $keys['secret_key'] );

			/* Check for a plan already existing. */
			$plan_id = charitable_recurring_campaign_get_gateway_plan_id(
				$campaign_id,
				$gateway_id,
				array( 'processor' => $processor )
			);

			/* Create the plan if it doesn't exist. */
			if ( ! $plan_id ) {

				/* Save the plan ID since it was successfully created in Stripe. */
				$plan_id = charitable_recurring_campaign_create_gateway_plan_id(
					$campaign_id,
					$gateway_id,
					array( 'processor' => $processor )
				);
			}

			/* Create the customer. */
			$customer = $gateway->get_stripe_customer( $donor, $processor );

			/* Create the subscription. */
			try {

				$subscription = \Stripe\Subscription::create( array(
					'customer' => $customer,
					'plan' 	   => $plan_id,
					'source'   => $gateway->get_source( $donor, $processor ),
				) );

				/* Save the subscription ID. */
				$recurring->set_gateway_subscription_id( $subscription->id );

				$recurring->update_donation_log( sprintf( __( 'Stripe subscription ID: %s.', 'charitable-stripe' ), $subscription->id ) );

				$status = $this->get_subscription_status( $subscription );

			} catch ( Stripe_CardError $e ) {

				$body = $e->getJsonBody();

				$message = isset( $body['error']['message'] )
					? $body['error']['message']
					: __( 'There was an error processing your payment, please ensure you have entered your card number correctly.', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$status = 'charitable-failed';

			} catch ( Stripe_ApiConnectionError $e ) {

				$body = $e->getJsonBody();

				$message = __( 'There was an error processing your payment (our payment gateways\'s API is down), please try again.', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$subscription->set_to_failed( __( 'Initial subscription payment failed.', 'charitable-stripe' ) );

			} catch ( Stripe_InvalidRequestError $e ) {

				$body = $e->getJsonBody();

				$message = isset( $body['error']['message'] )
					? $body['error']['message']
					: __( 'The payment gateway API request was invalid, please try again.', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$status = 'charitable-failed';

			} catch ( Stripe_ApiError $e ) {

				$body = $e->getJsonBody();

				$message = isset( $body['error']['message'] )
					? $body['error']['message']
					: __( 'The payment gateway API request was invalid, please try again.', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$status = 'charitable-failed';

			} catch ( Stripe_AuthenticationError $e ) {

				$body = $e->getJsonBody();

				$message = isset( $body['error']['message'] )
					? $body['error']['message']
					: __( 'The API keys entered in settings are incorrect', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$status = 'charitable-failed';

			} catch ( Stripe_Error $e ) {

				$body = $e->getJsonBody();

				$message = isset( $body['error']['message'] ) ? $body['error']['message'] : __( 'Something went wrong.', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$status = 'charitable-failed';

			} catch ( Exception $e ) {

				$body = $e->getJsonBody();

				$message = isset( $body['error']['message'] ) ? $body['error']['message'] : __( 'Something went wrong.', 'charitable-stripe' );

				charitable_get_notices()->add_error( $message );

				$status = 'charitable-failed';

			}

			if ( 'charitable-failed' == $status ) {
				$recurring->set_to_failed( __( 'Initial subscription payment failed', 'charitable-stripe' ) );
				return false;
			}

			$recurring->update_status( $status );

			return true;

		}

		/**
		 * Create a recurring donation plan in Stripe.
		 *
		 * @param 	mixed    $return
		 * @param 	int      $campaign_id
		 * @param 	int      $amount
		 * @param 	string   $period
		 * @param 	int      $interval
		 * @return  string|false
		 * @access  public
		 * @since   1.2.0
		 */
		public function create_recurring_donation_plan( $return, $campaign_id, $plan_args, $args ) {

			$period    = $plan_args['period'];
			$interval  = $plan_args['interval'];
			$amount    = $plan_args['amount'];
			$plan_id   = $period . '-' . $interval . '-' . $amount . '-' . $campaign_id;
			$plan_name = sprintf(
				_x( '%s - %s every %s', 'campaign title — amount every period', 'charitable-stripe' ),
				get_the_title( $campaign_id ),
				charitable_sanitize_amount( strval( $amount / 100 ) ),
				charitable_recurring_get_donation_period_strings( $interval, $period )
			);

			try {

				$plan = \Stripe\Plan::create( array(
					'id' 	         	   => $plan_id,
					'name' 	         	   => $plan_name,
					'interval'       	   => $period,
					'interval_count' 	   => $interval,
					'currency'       	   => charitable_get_currency(),
					'amount'         	   => $plan_args['amount'],
					'statement_descriptor' => substr( get_the_title( $campaign_id ), 0, 22 ),
				) );

				return $plan_id;

			} catch ( Exception $e ) {

				/* Log the error message and return false. */
				error_log( 'STRIPE - Error creating plan: ' . $e->getMessage() );
				return false;

			}
		}

		/**
		 * Process subscription-related webhooks.
		 *
		 * @see     https://stripe.com/docs/api#events
		 *
		 * @param   string $event_type The type of event.
		 * @param   object $event The event object received from Stripe.
		 * @return  void
		 * @access  public
		 * @since   1.2.0
		 */
		public function process_webhooks( $event_type, $event ) {

			$webhooks = array(
				'invoice.created' => 'process_invoice_created',
				'invoice.payment_failed' => 'process_invoice_payment_failed',
				'invoice.payment_succeeded' => 'process_invoice_payment_succeeded',
				'customer.subscription.updated' => 'process_customer_subscription_updated',
				'customer.subscription.deleted' => 'process_customer_subscription_deleted',
			);

			if ( ! array_key_exists( $event_type, $webhooks ) ) {
				return;
			}

			call_user_func( array( $this, $webhooks[ $event_type ] ), $event );

		}

		/**
		 * Process the invoice.created webhook.
		 *
		 * @param 	$event
		 * @return  void
		 * @access  public
		 * @since   1.2.0
		 */
		public function process_invoice_created( $event ) {

			$invoice      = $event->data->object;
			$subscription = charitable_recurring_get_subscription_by_gateway_id( $invoice->subscription, 'stripe' );

			if ( empty( $subscription ) ) {
				die( __( 'Recurring Donation IPN: Missing subscription', 'charitable-stripe' ) );
			}

			$status        = $invoice->paid ? 'charitable-completed' : 'charitable-pending';
			$last_donation = $subscription->get_most_recent_donation_id();

			if ( 'charitable-pending' == get_post_status( $last_donation ) ) {

				$ipn_message = __( 'Recurring Donation IPN: Initial donation completed', 'charitable-stripe' );
				$donation    = charitable_get_donation( $last_donation );

				$donation->update_status( $status );

			} else {

				$ipn_message = __( 'Recurring Donation IPN: Recurring donation completed', 'charitable-stripe' );
				$donation_id = $subscription->create_renewal_donation( array( 'status' => $status ) );
				$donation    = charitable_get_donation( $donation_id );

			}

			$log_message = sprintf( '%s: %s', __( 'Stripe Transaction ID', 'charitable-stripe' ), $invoice->payment );

			$donation->update_donation_log( $log_message );
			$donation->set_gateway_transaction_id( $invoice->payment );

			die( $ipn_message );

		}

		/**
		 * Process the invoice.payment_failed webhook.
		 *
		 * @param 	$event
		 * @return  void
		 * @access  public
		 * @since   1.2.0
		 */
		public function process_invoice_payment_failed( $event ) {

			$invoice      = $event->data->object;
			$subscription = charitable_recurring_get_subscription_by_gateway_id( $invoice->subscription, 'stripe' );

			if ( empty( $subscription ) ) {
				die( __( 'Recurring Donation IPN: Missing subscription', 'charitable-stripe' ) );
			}

			$donation_id = $this->get_donation_by_gateway_transaction_id( $invoice->payment );

			if ( is_null( $donation_id ) ) {
				die( __( 'Recurring Donation IPN: Donation not found for failed payment.', 'charitable-stripe' ) );
			}

			$donation = charitable_get_donation( $donation_id );

			$donation->update_status( 'charitable-failed' );

			$subscription->set_to_failed( sprintf( __( 'Payment for donation #%d failed. Stripe Transaction ID: %s', 'charitable-stripe' ), $donation_id, $invoice->payment ) );

			die( __( 'Recurring Donation IPN: Failed payment status', 'charitable-stripe' ) );

		}

		/**
		 * Process the invoice.payment_succeeded webhook.
		 *
		 * @param 	$event
		 * @return  void
		 * @access  public
		 * @since   1.2.0
		 */
		public function process_invoice_payment_succeeded( $event ) {

			$invoice      = $event->data->object;
			$subscription = charitable_recurring_get_subscription_by_gateway_id( $invoice->subscription, 'stripe' );

			if ( empty( $subscription ) ) {
				die( __( 'Recurring Donation IPN: Missing subscription', 'charitable-stripe' ) );
			}

			$donation_id = $this->get_donation_by_gateway_transaction_id( $invoice->payment );

			if ( is_null( $donation_id ) ) {
				die( __( 'Recurring Donation IPN: Donation not found for successful payment.', 'charitable-stripe' ) );
			}

			$donation = charitable_get_donation( $donation_id );

			$donation->update_status( 'charitable-completed' );

			die( __( 'Recurring Donation IPN: Payment complete', 'charitable-stripe' ) );

		}

		/**
		 * Process the customer.subscription.updated webhook.
		 *
		 * @param 	$event
		 * @return  void
		 * @access  public
		 * @since   1.2.0
		 */
		public function process_customer_subscription_updated( $event ) {

			$object 	  = $event->data->object;
			$subscription = charitable_recurring_get_subscription_by_gateway_id( $object->id, 'stripe' );

			if ( empty( $subscription ) ) {
				die( __( 'Recurring Donation IPN: Missing subscription', 'charitable-stripe' ) );
			}
			
			$status = $this->get_subscription_status( $object->status );
			
			if ( 'charitable-failed' == $status ) {
				
				$subscription->set_to_failed();
				
			} else {
				
				$subscription->update_status( $status );

			}
			
			die( __( 'Recurring Donation IPN: Recurring donation updated', 'charitable-stripe' ) );

		}

		/**
		 * Process the customer.subscription.deleted webhook.
		 *
		 * @param 	$event
		 * @return  void
		 * @access  public
		 * @since   1.2.0
		 */
		public function process_customer_subscription_deleted( $event ) {

			$object 	  = $event->data->object;
			$subscription = charitable_recurring_get_subscription_by_gateway_id( $object->id, 'stripe' );

			if ( empty( $subscription ) ) {
				die( __( 'Recurring Donation IPN: Missing subscription', 'charitable-stripe' ) );
			}
			
			$subscription->update_status( 'charitable-cancelled' );
	
			die( __( 'Recurring Donation IPN: Recurring donation cancelled', 'charitable-stripe' ) );

		}

		/**
		 * Get a donation by gateway transaction ID.
		 *
		 * @param 	string $transaction_id
		 * @return  int|null
		 * @access  private
		 * @since   1.2.0
		 */
		private function get_donation_by_gateway_transaction_id( $transaction_id ) {

			if ( function_exists( 'charitable_get_donation_by_transaction_id' ) ) {
				return charitable_get_donation_by_transaction_id( $transaction_id );
			}

			global $wpdb;

			$sql = "SELECT post_id 
					FROM $wpdb->postmeta 
					WHERE meta_key = '_gateway_transaction_id' 
					AND meta_value = %s";

			return $wpdb->get_var( $wpdb->prepare( $sql, $transaction_id ) );

		}

		/**
		 * Given a Stripe subscription, return the Charitable subscription status.
		 *
		 * @param   object $subscription
		 * @return  string
		 * @access  public
		 * @since   1.2.0
		 */
		public function get_subscription_status( $subscription ) {

			switch ( $subscription->status ) {

				case 'active' :
					$status = 'charitable-active';
					break;

				case 'past_due' :
				case 'canceled' :
				case 'unpaid' :
					$status = 'charitable-failed';
					break;

				default :
					$status = 'charitable-pending';

			}

			return apply_filters( 'charitable_stripe_recurring_subscription_status', $status, $subscription->status );

		}
	}

endif; // End class_exists check
