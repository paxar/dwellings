<?php
/**
 * Class responsible for adding Charitable Anonymous settings in admin area.
 *
 * @package     Charitable Anonymous/Classes/Charitable_Anonymous_Admin
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Charitable_Anonymous_Admin' ) ) : 

/**
 * Charitable_Anonymous_Admin
 *
 * @since       1.0.0
 */
class Charitable_Anonymous_Admin {

    /**
     * @var     Charitable_Anonymous_Admin
     * @access  private
     * @static
     * @since   1.1.0
     */
    private static $instance = null;

    /**
     * Create class object. Private constructor. 
     * 
     * @access  private
     * @since   1.1.0
     */
    private function __construct() {
    }

    /**
     * Create and return the class object.
     *
     * @access  public
     * @static
     * @since   1.1.0
     */
    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Charitable_Anonymous_Admin();            
        }

        return self::$instance;
    }

    /**
     * Set the admin view path to our views folder for any of our views.  
     *
     * @param   string  $path
     * @param   string  $view
     * @param   array   $view_args
     * @return  string
     * @access  public
     * @since   1.0.0
     */
    public function admin_view_path( $path, $view, $view_args ) {
        if ( isset( $view_args[ 'view_source' ] ) && 'charitable-anonymous' == $view_args[ 'view_source' ] ) {

            $path = charitable_anonymous()->get_path( 'includes' ) . 'admin/views/' . $view . '.php';

        }

        return $path;
    }

    /**
     * If the donation was made anonymously, show that in the donation details. 
     *
     * @param   Charitable_User|Charitable_Donor $donor
     * @param   Charitable_Donation $donation
     * @return  void
     * @access  public
     * @since   1.1.0
     */
    public function add_anonymous_donation_information( $donor, Charitable_Donation $donation ) {        
        if ( ! $donation->anonymous_donation ) {
            return;
        }

        charitable_admin_view( 'anonymous-donation-note', array( 
            'view_source'   => 'charitable-anonymous', 
            'donation'      => $donation
        ) );
    }
}

endif; // End class_exists check