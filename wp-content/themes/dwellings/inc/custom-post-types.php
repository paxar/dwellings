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
    register_post_type( 'section-testimonials',
        array(
            'labels' => array(
                'name' => __('Testimonials section'),
                'singular_name' => __('Testimonials section'),
                'add_new' => __('New post')
            ),
            'public' => true,
            'has_archive' => true,
            'show_ui' => true,
            'taxonomies' => array('category', 'post_tag'),
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields'),
        )
    );
}