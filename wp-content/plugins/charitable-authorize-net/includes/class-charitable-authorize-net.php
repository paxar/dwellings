<?php
/**
 * The main Charitable Authorize.Net class.
 *
 * The responsibility of this class is to load all the plugin's functionality.
 *
 * @package     Charitable Authorize.Net
 * @copyright   Copyright (c) 2016, Eric Daams
 * @license     http://opensource.org/licenses/gpl-1.0.0.php GNU Public License
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

if ( ! class_exists( 'Charitable_Authorize_Net' ) ) :

	/**
	 * Charitable_Authorize_Net
	 *
	 * @since   1.0.0
	 */
	class Charitable_Authorize_Net {

		/**
		 * @var string
		 */
		const VERSION = '1.1.3';

		/**
		 * @var string  A date in the format: YYYYMMDD
		 */
		const DB_VERSION = '20151229';

		/**
		 * @var string The product name.
		 */
		const NAME = 'Charitable Authorize.Net';

		/**
		 * @var string The product author.
		 */
		const AUTHOR = 'Studio 164a';

		/**
		 * @var Charitable_Authorize_Net
		 */
		private static $instance = null;

		/**
		 * The root file of the plugin.
		 *
		 * @var     string
		 * @access  private
		 */
		private $plugin_file;

		/**
		 * The root directory of the plugin.
		 *
		 * @var     string
		 * @access  private
		 */
		private $directory_path;

		/**
		 * The root directory of the plugin as a URL.
		 *
		 * @var     string
		 * @access  private
		 */
		private $directory_url;

		/**
		 * Create class instance.
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function __construct( $plugin_file ) {
			$this->plugin_file      = $plugin_file;
			$this->directory_path   = plugin_dir_path( $plugin_file );
			$this->directory_url    = plugin_dir_url( $plugin_file );

			add_action( 'charitable_start', array( $this, 'start' ), 6 );
		}

		/**
		 * Returns the original instance of this class.
		 *
		 * @return  Charitable
		 * @since   1.0.0
		 */
		public static function get_instance() {
			return self::$instance;
		}

		/**
		 * Run the startup sequence on the charitable_start hook.
		 *
		 * This is only ever executed once.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function start() {
			// If we've already started (i.e. run this function once before), do not pass go.
			if ( $this->started() ) {
				return;
			}

			// Set static instance
			self::$instance = $this;

			$this->load_dependencies();

			$this->setup_licensing();

			$this->setup_i18n();

			$this->maybe_start_admin();

			$this->attach_hooks_and_filters();

			/* Hook in here to do something when the plugin is first loaded. */
			do_action( 'charitable_authorize_net_start', $this );
		}

		/**
		 * Include necessary files.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function load_dependencies() {
			require_once( $this->get_path( 'includes/charitable-authorize-net-core-functions.php' ) );

			/* Gateway */
			require_once( $this->get_path( 'includes/gateway/class-charitable-gateway-authorize-net.php' ) );
			require_once( $this->get_path( 'includes/gateway/charitable-authorize-net-gateway-hooks.php' ) );

			/* Authorize.Net SDK */
			require_once( $this->get_path( 'includes/libraries/anet_php_sdk/vendor/autoload.php' ) );

			/* Recurring Donations */
			if ( class_exists( 'Charitable_Recurring' ) ) {
				require_once( $this->get_path( 'includes/recurring/class-charitable-authorize-net-recurring.php' ) 
					);
				require_once( $this->get_path( 'includes/recurring/charitable-authorize-net-recurring-hooks.php' ) );
			}			
		}

		/**
		 * Set up licensing for the extension.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_licensing() {
			charitable_get_helper( 'licenses' )->register_licensed_product(
				Charitable_Authorize_Net::NAME,
				Charitable_Authorize_Net::AUTHOR,
				Charitable_Authorize_Net::VERSION,
				$this->plugin_file
			);
		}

		/**
		 * Set up the internationalisation for the plugin.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_i18n() {
			if ( class_exists( 'Charitable_i18n' ) ) {

				require_once( $this->get_path( 'includes/i18n/class-charitable-authorize-net-i18n.php' ) );

				Charitable_Authorize_Net_i18n::get_instance();
			}
		}		

		/**
		 * Load the admin-only functionality.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.2
		 */
		private function maybe_start_admin() {
			if ( ! is_admin() ) {
				return;
			}

			require_once( $this->get_path( 'includes/admin/class-charitable-authorize-net-admin.php' ) );
			require_once( $this->get_path( 'includes/admin/charitable-authorize-net-admin-hooks.php' ) );
		}

		/**
		 * Set up hooks and filters.
		 *
		 * @return 	void
		 * @access 	private
		 * @since 	1.1.0
		 */
		private function attach_hooks_and_filters() {
			add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts' ), 11 );
			add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ), 11 );
		}

		/**
		 * Register Authorize.Net scripts.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.1.0
		 */
		public function setup_scripts() {

			if ( is_admin() ) {
				return;
			}

			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$version = '';
				$suffix = '';
			} else {
				$version = $this->get_version();
				$suffix = '.min';
			}

			if ( version_compare( charitable()->get_version(), '1.4.0', '>=' ) ) {

				$anet_settings = charitable_get_option( 'gateways_authorize_net' );
				$client_key    = charitable_get_option( 'client_key', '', $anet_settings );
				$api_login_id  = charitable_get_option( 'api_login_id', '', $anet_settings );

				if ( empty( $client_key ) || empty( $api_login_id ) ) {
					return;
				}

				$authorize_net_vars = array(
					'api_login_id' => $api_login_id,
					'client_key'   => $client_key,
				);

				/* Register Accept.JS script. */
				if ( charitable_get_option( 'test_mode' ) ) {

					wp_register_script(
						'accept-js',
						'https://jstest.authorize.net/v1/Accept.js',
						array(),
						null,
						true
					);

				} else {

					wp_register_script(
						'accept-js',
						'https://js.authorize.net/v1/Accept.js',
						array(),
						null,
						true
					);

				}

				wp_register_script(
					'charitable-authorize-net-handler',
					$this->get_path( 'assets', false ) . 'js/charitable-authorize-net-handler' . $suffix . '.js',
					array( 'accept-js', 'charitable-script', 'jquery-core' ),
					$version,
					true
				);

				wp_localize_script(
					'charitable-authorize-net-handler',
					'CHARITABLE_ANET_VARS',
					$authorize_net_vars
				);

			}

		}

		/**
		 * Load admin scripts on Authorize.Net settings page.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.1.0
		 */
		public function setup_admin_scripts( $page ) {
			
			if ( 'charitable_page_charitable-settings' != $page ) {
				return;
			}

			if ( ! array_key_exists( 'group', $_GET ) || 'gateways_authorize_net' != $_GET['group'] ) {
				return;
			}

			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$version = time();
				$suffix = '';
			} else {
				$version = $this->get_version();
				$suffix = '.min';
			}

			wp_register_script(
				'charitable-authorize-net-admin',
				$this->get_path( 'assets', false ) . 'js/charitable-authorize-net-admin' . $suffix . '.js',
				array( 'jquery-core' ),
				$version,
				true
			);

			wp_localize_script(
				'charitable-authorize-net-admin',
				'CHARITABLE_ANET_ADMIN_VARS',
				array(
					'syncing' 		  => __( 'Syncing', 'charitable-authorize-net' ),
					'synced_just_now' => __( 'Last synced: Just now', 'charitable-authorize-net' ),
				)
			);

			wp_register_style(
				'charitable-authorize-net-admin-styles',
				$this->get_path( 'assets', false ) . 'css/charitable-authorize-net-admin' . $suffix . '.css',
				array(),
				$version
			);

			wp_enqueue_script( 'charitable-authorize-net-admin' );
			wp_enqueue_style( 'charitable-authorize-net-admin-styles' );

		}

		/**
		 * Returns whether we are currently in the start phase of the plugin.
		 *
		 * @return  bool
		 * @access  public
		 * @since   1.0.0
		 */
		public function is_start() {
			return current_filter() == 'charitable_authorize_net_start';
		}

		/**
		 * Returns whether the plugin has already started.
		 *
		 * @return  bool
		 * @access  public
		 * @since   1.0.0
		 */
		public function started() {
			return did_action( 'charitable_authorize_net_start' ) || current_filter() == 'charitable_authorize_net_start';
		}

		/**
		 * Returns the plugin's version number.
		 *
		 * @return  string
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_version() {
			return self::VERSION;
		}

		/**
		 * Returns plugin paths.
		 *
		 * @param   string $path // If empty, returns the path to the plugin.
		 * @param   bool $absolute_path // If true, returns the file system path. If false, returns it as a URL.
		 * @return  string
		 * @since   1.0.0
		 */
		public function get_path( $type = '', $absolute_path = true ) {
			$base = $absolute_path ? $this->directory_path : $this->directory_url;

			/* Allows you to pass a relative path. */
			if ( strpos( $type, '/' ) ) {
				return $base . $type;
			}

			switch ( $type ) {
				case 'includes' :
					$path = $base . 'includes/';
					break;

				case 'directory' :
					$path = $base;
					break;

				case 'assets' :
					$path = $base . 'assets/';
					break;	

				default :
					$path = $this->plugin_file;
			}

			return $path;
		}

		/**
		 * Throw error on object clone.
		 *
		 * This class is specifically designed to be instantiated once. You can retrieve the instance using charitable()
		 *
		 * @since   1.0.0
		 * @access  public
		 * @return  void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'charitable-authorize-net' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @return  void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'charitable-authorize-net' ), '1.0.0' );
		}
	}

endif; // End if class_exists check
