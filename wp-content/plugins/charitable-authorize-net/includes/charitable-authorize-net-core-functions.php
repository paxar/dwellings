<?php 
/**
 * Charitable Authorize.Net Core Functions. 
 *
 * General core functions.
 *
 * @author      Studio164a
 * @category    Core
 * @package     Charitable Authorize.Net
 * @subpackage  Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This returns the original Charitable_Authorize_Net object. 
 *
 * Use this whenever you want to get an instance of the class. There is no
 * reason to instantiate a new object, though you can do so if you're stubborn :)
 *
 * @return  Charitable_Authorize_Net
 * @since   1.0.0
 */
function charitable_authorize_net() {
    return Charitable_Authorize_Net::get_instance();
}