<?php
/**
 * Shortcode handler for the [campaign_updates] shortcode.
 * 
 * @author      Studio 164a
 * @version     1.0.0
 * @since       1.0.0
 * @package     Charitable Simple Updates/Shortcodes/Updates 
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Charitable_Simple_Updates_Shortcode' ) ) : 

/**
 * Charitable_Simple_Updates_Shortcode class. 
 *
 * @since       1.0.0
 */
class Charitable_Simple_Updates_Shortcode {

    /**
     * The callback method for the campaigns shortcode.
     *
     * This receives the user-defined attributes and passes the logic off to the class. 
     *
     * @param   array       $atts       User-defined shortcode attributes.
     * @return  string
     * @access  public
     * @static
     * @since   1.0.0
     */
    public static function display( $atts ) {
        $default = array(
            'campaign_id' => false
        );

        $args = shortcode_atts( $default, $atts, 'campaign_updates' );
        
        $campaign = self::get_campaign( $args[ 'campaign_id' ] );

        ob_start();

        charitable_simple_updates_template_campaign_updates( $campaign );

        return apply_filters( 'charitable_campaign_updates_shortcode', ob_get_clean(), $campaign, $args );
    }

    /**
     * Return the campaign to be displayed. 
     *
     * @param   int|false $campaign_id
     * @return  Charitable_Campaign|false
     * @access  protected
     * @since   1.0.0
     */
    protected static function get_campaign( $campaign_id ) {
        if ( false == $campaign_id ) {
            return charitable_get_current_campaign();
        }

        return new Charitable_Campaign( $campaign_id );
    }
}

endif;