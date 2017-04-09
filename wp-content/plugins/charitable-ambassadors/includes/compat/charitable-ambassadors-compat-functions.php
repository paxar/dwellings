<?php 
/**
 * Charitable Ambassadors Compatibility Functions. 
 *
 * @version     1.1.2
 * @package     Charitable Ambassadors/Functions/Compatibility
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License 
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * When Yoast SEO is installed, Divi executes shortcodes within the admin area using do_action().
 *
 * This results in a fatal error since Charitable Ambassador's shortcodes all leverage
 * the templating system, which is only loaded on the public site.
 *
 * @param   string[] $shortcodes
 * @return  string[]
 * @since   1.1.2
 */
function charitable_ambassadors_divi_excluded_shortcodes( $shortcodes ) {

    $shortcodes = array_merge( $shortcodes, array( 
        'charitable_submit_campaign', 
        'charitable_my_campaigns',
        'charitable_creator_donations'
    ) );

    return $shortcodes;

}