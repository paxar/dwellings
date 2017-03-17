<?php
/**
 * Charitable Ambassadors Compatibility Hooks
 *
 * @version     1.1.2
 * @package     Charitable Ambassadors/Functions/Compatibility
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Divi compatibility.
 *
 * @see     charitable_ambassadors_divi_excluded_shortcodes()
 */
add_filter( 'et_pb_admin_excluded_shortcodes', 'charitable_ambassadors_divi_excluded_shortcodes' );
