<?php
/**
 * Dwellings site custom search
 *
 */

function custom_search_results($search, &$wp_query) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term ){
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
            $search[] = $wpdb->prepare( "$wpdb->posts.post_content LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
            $search[] = $wpdb->prepare( "$wpdb->posts.post_date LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
        }

        $search = ' AND post_type="post" AND (' . implode( ' OR ', $search ).')';

    }

    return $search;
}

add_filter( 'posts_search', 'custom_search_results', 10, 2 );