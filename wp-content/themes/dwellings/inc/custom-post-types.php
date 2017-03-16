<?php
/**
 * Dwellings site custom post types
 *
 */


/*Main page icons section*/

add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'icons-section',
        array(
            'labels' => array(
                'name' => __( 'Icons section' ),
                'singular_name' => __( 'Icons section' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'thumbnail'),
        )
    );
}