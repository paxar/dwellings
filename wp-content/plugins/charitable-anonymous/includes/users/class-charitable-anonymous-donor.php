<?php
/**
 * Manages customizations to the donor & user models.
 *
 * @package     Charitable Anonymous/Classes/Charitable_Anonymous_Donor
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Charitable_Anonymous_Donor' ) ) : 

/**
 * Charitable_Anonymous_Donor
 *
 * @since       1.0.0
 */
class Charitable_Anonymous_Donor {

    /**
     * @var     Charitable_Anonymous_Donor
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
            self::$instance = new Charitable_Anonymous_Donor();            
        }

        return self::$instance;
    }

    /**
     * Set the donor's name to anonymous. 
     *
     * @param   string $name
     * @param   Charitable_Donor $donor 
     * @return  string
     * @access  public
     * @since   1.0.0
     */
    public function set_donor_name_to_anonymous( $name, Charitable_Donor $donor ) {
        if ( ! $donor->get_donation() ) {
            return $name;
        }

        $is_anonymous = get_post_meta( $donor->donation_id, 'anonymous_donation', true );

        if ( ! $is_anonymous ) {
            return $name;
        }

        return apply_filters( 'charitable_donor_anonymous_name', __( 'Anonymous', 'charitable-anonymous' ), $name, $donor );
    }

    /**
     * Display the default Gravatar. 
     *
     * @param   string $avatar
     * @param   Charitable_Donor $donor 
     * @return  string
     * @access  public
     * @since   1.0.0
     */
    public function force_anonymous_gravatar( $avatar, Charitable_Donor $donor ) {
        if ( ! $donor->get_donation() ) {
            return $avatar;
        }

        $is_anonymous = get_post_meta( $donor->donation_id, 'anonymous_donation', true );

        if ( ! $is_anonymous ) {
            return $avatar;
        }

        return get_avatar( '' );
    }    
}

endif; // End class_exists check