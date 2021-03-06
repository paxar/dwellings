<?php 
/**
 * Charitable Anonymous Widget Hooks
 *
* Action/filter hooks used to integrate with the Donors widget in Charitable.
 *
 * @package     Charitable Anonymous/Functions/Widget
 * @version     1.1.0
 * @author      Eric Daams 
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

$object = Charitable_Anonymous_Donors_Widget::get_instance();

/**
 * Add additional settings to the widget form.
 *
 * @see     Charitable_Anonymous_Donors_Widget::add_anonymous_donors_fields()
 */
add_action( 'charitable_donor_widget_settings_bottom', array( $object, 'add_anonymous_donors_fields' ), 10, 2 );

/**
 * Save the additional settings.
 *
 * @see     Charitable_Anonymous_Donors_Widget::save_anonymous_donors_fields
 */
add_filter( 'charitable_donors_widget_update_instance', array( $object, 'save_anonymous_donors_fields' ), 10, 2 );

/**
 * Set default arguments for the new settings.
 *
 * @see     Charitable_Anonymous_Donors_Widget::anonymous_donors_fields_default_args
 */
add_filter( 'charitable_donors_widget_default_args', array( $object, 'anonymous_donors_fields_default_args' ) );

/**
 * Set arguments to pass to the donors query to retrieve donors.
 *
 * @see     Charitable_Anonymous_Donors_Widget::anonymous_donors_query_args
 */
add_filter( 'charitable_donors_widget_donor_query_args', array( $object, 'anonymous_donors_query_args' ), 10, 2 );