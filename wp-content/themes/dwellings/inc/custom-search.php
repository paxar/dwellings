<?php
/**
 * Dwellings site custom search
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
            $test_date_var = strtotime($term);
            if ($test_date_var)
                $search[] = $wpdb->prepare( "$wpdb->posts.post_date LIKE %s", $n . $wpdb->esc_like( date( "Y-m-j", $test_date_var )) . $n );
        }

        $test_date_var = strtotime(implode(' ',$q['search_terms']));

        if ($test_date_var)
           $search[] = $wpdb->prepare( "$wpdb->posts.post_date LIKE %s", $n . $wpdb->esc_like( date( "Y-m-j", $test_date_var )) . $n );
        $search = ' AND post_type="post" AND (' . implode( ' OR ', $search ).')';
    }
    else {
        if (isset($_REQUEST['s'])) {
            wp_redirect( get_permalink( get_option('page_for_posts')));
            exit;
        }
    }

    return $search;
}

add_filter( 'posts_search', 'custom_search_results', 10, 2 );

add_action('pre_get_posts','sort_searchresult_by_date');
function sort_searchresult_by_date($k) {
    if(is_search()) {
        $k->query_vars['orderby'] = 'post_date';
        $k->query_vars['order'] = 'DESC';
    }
}
