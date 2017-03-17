<?php 
/**
 * Charitable Anonymous Donor Hooks
 *
* Action/filter hooks used to customize the output of the Charitable_Donor and Charitable_Donor_Query objects.
 *
 * @package     Charitable Anonymous/Functions/Donor
 * @version     1.1.0
 * @author      Eric Daams 
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

$donor = Charitable_Anonymous_Donor::get_instance();
$donor_query = Charitable_Anonymous_Donor_Query::get_instance();

/**
 * When a donation was made anonymously, set the donor name to anonymous.
 *
 * @see     Charitable_Anonymous_Donor::set_donor_name_to_anonymous()
 */
add_filter( 'charitable_donor_name', array( $donor, 'set_donor_name_to_anonymous' ), 10, 2 );
    
/**
 * When the donation was made anonymously, show the placeholder avatar.
 *
 * @see     Charitable_Anonymous_Donor::force_anonymous_gravatar()
 */
add_filter( 'charitable_donor_avatar', array( $donor, 'force_anonymous_gravatar' ), 10, 2 );

/**
 * Set a default value for the exclude_anonymous argument.
 *
 * @see     Charitable_Anonymous_Donor_Query::add_exclude_anonymous_default()
 */
add_filter( 'charitable_donor_query_default_args', array( $donor_query, 'add_exclude_anonymous_default' ) );

/**
 * Join the postmeta table on the query.
 *
 * @see     Charitable_Anonymous_Donor_Query::join_postmeta_table
 */
add_filter( 'charitable_query_join', array( $donor_query, 'join_postmeta_table' ), 10, 2 );

/**
 * Exclude anonymous donations in the where clause.
 *
 * @see     Charitable_Anonymous_Donor_Query::exclude_anonymous_sql
 */
add_filter( 'charitable_query_where', array( $donor_query, 'exclude_anonymous_sql' ), 10, 2 );

/**
 * Remove the hooks after the query has been executed.
 *
 * @see     Charitable_Anonymous_Donor_Query::unhook_callbacks()
 */
add_action( 'charitable_post_query', array( $donor_query, 'unhook_callbacks' ) );