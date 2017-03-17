<?php
/**
 * This class is responsible for modifying the Charitable_Donor_Query.
 *
 * @see         Charitable_Donor_Query
 * 
 * @package     Charitable Anonymous/Classes/Charitable_Anonymous_Donor_Query
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2015, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Charitable_Anonymous_Donor_Query' ) ) : 

    /**
     * Charitable_Anonymous_Donor_Query
     *
     * @since       1.0.0
     */
    class Charitable_Anonymous_Donor_Query {

        /**
         * @var     Charitable_Anonymous_Donor_Query
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
                self::$instance = new Charitable_Anonymous_Donor_Query();            
            }

            return self::$instance;
        }

        /**
         * Add an exclude_anonymous field to the defaults. 
         *
         * @param   mixed[] $defaults
         * @return  mixed[]
         * @access  public
         * @since   1.0.0
         */
        public function add_exclude_anonymous_default( $defaults ) {
            $defaults[ 'exclude_anonymous' ] = false;
            return $defaults;
        }

        /**
         * Add a join to the postmeta table if we are excluding anonymous donations.
         *
         * @global  WPDB             $wpdb
         * @param   string           $sql
         * @param   Charitable_Query $query
         * @return  string
         * @access  public
         * @since   1.0.0
         */
        public function join_postmeta_table( $sql, Charitable_Query $query ) {
            global $wpdb;

            if ( ! is_a( $query, 'Charitable_Donor_Query' ) ) {
                return $sql;
            }

            if ( $query->get( 'exclude_anonymous' ) ) {
                $sql .= " LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = 'anonymous_donation'";
            }

            return $sql;
        }

        /**
         * Modify the WHERE statement to exclude anonymous donations.
         *
         * @global  WPDB             $wpdb
         * @param   string           $sql
         * @param   Charitable_Query $query
         * @return  string
         * @access  public
         * @since   1.0.0
         */
        public function exclude_anonymous_sql( $sql, Charitable_Query $query ) {    
            global $wpdb;

            if ( ! is_a( $query, 'Charitable_Donor_Query' ) ) {
                return $sql;
            }

            if ( $query->get( 'exclude_anonymous' ) ) {
                $sql .= " AND ( {$wpdb->postmeta}.meta_value = 0 OR {$wpdb->postmeta}.meta_value IS NULL )";
            }

            return $sql;
        }

        /**
         * Remove any hooks that have been attached by the class to prevent contaminating other queries. 
         *
         * @return  void
         * @access  public
         * @since   1.0.0
         */
        public function unhook_callbacks() {
            remove_filter( 'charitable_query_join', array( $this, 'join_postmeta_table' ), 10, 2 );
            remove_filter( 'charitable_query_where', array( $this, 'exclude_anonymous_sql' ), 10, 2 );
        }
    }

endif; // End class_exists check