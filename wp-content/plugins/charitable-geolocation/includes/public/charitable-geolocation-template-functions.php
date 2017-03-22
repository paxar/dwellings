<?php 
/**
 * Charitable Template Functions. 
 *
 * Functions used with template hooks.
 * 
 * @package     Charitable/Functions/Templates
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2014, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**********************************************/ 
/* CAMPAIGN LOOP
/**********************************************/

if ( ! function_exists( 'charitable_geolocation_template_campaign_loop_location' ) ) :
    /**
     * Output the campaign location on campaigns displayed within the loop.
     *
     * @param   Charitable_Campaign $campaign
     * @return  void
     * @since   1.0.0
     */
    function charitable_geolocation_template_campaign_loop_location( $campaign ) {
        charitable_geolocation_template( 'campaign-loop/location.php', array( 'campaign' => $campaign ) );
    }
endif;


