<?php
/**
 * The class responsible for adding & saving extra settings in the Charitable admin.
 *
 * @package     Charitable Authorizet.Net/Classes/Charitable_Authorize_Net_Admin
 * @version     1.0.2
 * @author      Eric Daams
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Authorize_Net_Admin' ) ) :

	/**
	 * Charitable_Authorize_Net_Admin
	 *
	 * @since       1.0.2
	 */
	class Charitable_Authorize_Net_Admin {

		/**
		 * @var     Charitable_Authorize_Net_Admin
		 * @access  private
		 * @static
		 * @since   1.0.2
		 */
		private static $instance = null;

		/**
		 * Create class object. Private constructor.
		 *
		 * @access  private
		 * @since   1.0.2
		 */
		private function __construct() {
		}

		/**
		 * Create and return the class object.
		 *
		 * @access  public
		 * @static
		 * @since   1.0.2
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new Charitable_Authorize_Net_Admin();
			}

			return self::$instance;
		}

		/**
		 * Add links to activate
		 *
		 * @param   string[] $links
		 * @return  string[]
		 * @access  public
		 * @since   1.0.2
		 */
		public function add_plugin_action_links( $links ) {

			if ( Charitable_Gateways::get_instance()->is_active_gateway( 'authorize_net' ) ) {

				$links[] = '<a href="' . admin_url( 'admin.php?page=charitable-settings&tab=gateways&group=gateways_authorize_net' ) . '">' . __( 'Settings', 'charitable-authorize-net' ) . '</a>';

			} else {

				$activate_url = esc_url( add_query_arg( array(
					'charitable_action' => 'enable_gateway',
					'gateway_id'        => 'authorize_net',
					'_nonce'            => wp_create_nonce( 'gateway' ),
				), admin_url( 'admin.php?page=charitable-settings&tab=gateways' ) ) );

				$links[] = '<a href="' . $activate_url . '">' . __( 'Activate Authorize.Net', 'charitable-authorize-net' ) . '</a>';

			}

			return $links;
		}

		/**
		 * Get the required fields from Authorize.Net.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.1.0
		 */
		public function get_authorize_net_required_fields() {

			$sync_data = array(
				'last_synced' => time(),
				'fields'      => array(),
				'shipping'	  => false,
			);

			$errors = Charitable_Gateway_Authorize_Net::do_empty_transaction();

			foreach ( $errors as $error ) {
				switch ( $error->getErrorText() ) {
					case 'Bill To First Name is required.' :
						$sync_data['fields'][] = 'first_name';
						break;

					case 'Bill To Last Name is required.' :
						$sync_data['fields'][] = 'last_name';
						break;

					case 'Bill To Address is required.' :
						$sync_data['fields'][] = 'address';
						break;

					case 'Bill To City is required.' :
						$sync_data['fields'][] = 'city';
						break;

					case 'Bill To State/Province is required.' :
						$sync_data['fields'][] = 'state';
						break;

					case 'Bill To Zip/Postal Code is required.' :
						$sync_data['fields'][] = 'postcode';
						break;

					case 'Bill To Country is required.' :
						$sync_data['fields'][] = 'country';
						break;

					case 'Phone is required.' :
						$sync_data['fields'][] = 'phone';
						break;

					case 'Email is required.' :
						$sync_data['fields'][] = 'email';
						break;

					case 'Ship To First Name is required.' :
						$sync_data['fields'][] = 'first_name';
						$sync_data['shipping'] = true;
						break;

					case 'Ship To Last Name is required.' :
						$sync_data['fields'][] = 'last_name';
						$sync_data['shipping'] = true;
						break;

					case 'Ship To Address is required.' :
						$sync_data['fields'][] = 'address';
						$sync_data['shipping'] = true;
						break;

					case 'Ship To City is required.' :
						$sync_data['fields'][] = 'city';
						$sync_data['shipping'] = true;
						break;

					case 'Ship To State/Province is required.' :
						$sync_data['fields'][] = 'state';
						$sync_data['shipping'] = true;
						break;

					case 'Ship To Zip/Postal Code is required.' :
						$sync_data['fields'][] = 'postcode';
						$sync_data['shipping'] = true;
						break;

					case 'Ship To Country is required.' :
						$sync_data['fields'][] = 'country';
						$sync_data['shipping'] = true;
						break;

				}
			}

			$sync_data['fields'] = array_unique( $sync_data['fields'] );

			$settings = get_option( 'charitable_settings' );
			$settings['gateways_authorize_net']['sync'] = $sync_data;

			update_option( 'charitable_settings', $settings );

			return $sync_data;

		}

		/**
		 * AJAX request handler to sync the required fields with Authorize.Net
		 *
		 * @return  void
		 * @access  public
		 * @since   1.1.0
		 */
		public function ajax_get_authorize_net_required_fields() {
			wp_send_json_success( $this->get_authorize_net_required_fields() );
		}

		/**
		 * Save the Authorize.Net settings, without losing synced required fields.
		 *
		 * @param	array $values
		 * @param	array $new_values
		 * @param	array $old_values
		 * @return	array
		 * @access	public
		 * @since	1.1.0
		 */
		public function save_authorize_net_settings( $values, $new_values, $old_values ) {

			/* Bail early if this is not the Authorize.Net settings page. */
			if ( ! array_key_exists( 'gateways_authorize_net', $values ) ) {
				return $values;
			}

			/* Bail if we don't have any sync data. */
			if ( ! array_key_exists( 'sync', $old_values['gateways_authorize_net'] ) ) {
				return $values;
			}

			$values['gateways_authorize_net']['sync'] = $old_values['gateways_authorize_net']['sync'];

			return $values;

		}
	}

endif; // End class_exists check
