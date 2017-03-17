<?php 

/**
 * Charitable Simple Updates Core Functions. 
 *
 * General core functions.
 *
 * @author      Studio164a
 * @package     Charitable Simple Updates/Functions/Core
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This returns the original Charitable_Simple_Updates object. 
 *
 * Use this whenever you want to get an instance of the class. There is no
 * reason to instantiate a new object, though you can do so if you're stubborn :)
 *
 * @return  Charitable_Simple_Updates
 * @since   1.0.0
 */
function charitable_simple_updates() {
    return Charitable_Simple_Updates::get_instance();
}