<?php
/**
 * Dwellings site functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dwellings_site
 */

if ( ! function_exists( 'dwellings_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dwellings_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Dwellings site, use a find and replace
	 * to change 'dwellings' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dwellings', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'dwellings' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dwellings_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

    // Add theme support for Custom Logo.
    add_theme_support( 'custom-logo', array(
        'width'       => 131,
        'height'      => 57,
        'flex-width'  => true,
    ) );
}
endif;
add_action( 'after_setup_theme', 'dwellings_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dwellings_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dwellings_content_width', 640 );
}
add_action( 'after_setup_theme', 'dwellings_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dwellings_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dwellings' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'dwellings' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer widgets', 'dwellings' ),
        'id'            => 'sidebar-2',
        'description'   => esc_html__( 'Add subscription form.', 'dwellings' ),
        'before_widget' => '<diiv class="subscribe">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-footer">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'dwellings_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dwellings_scripts() {
    /*Add styles*/

    wp_enqueue_style('vendor_css', get_template_directory_uri() . '/css/vendor.css');

    wp_enqueue_style('style_css', get_stylesheet_uri(), ['vendor_css']);

    /*Add scripts*/
    wp_deregister_script( 'jquery' );

    wp_register_script( 'jquery', get_template_directory_uri() . '/vendors/jquery/dist/jquery.min.js', '', '', true);

    wp_enqueue_script('jquery');

    wp_register_script( 'bootstrap', get_template_directory_uri() . '/vendors/bootstrap-sass/assets/javascripts/bootstrap.min.js', ['jquery'], '', true );

    wp_enqueue_script('bootstrap');

    wp_register_script('home_page_js', get_template_directory_uri() . '/js/home-page.js', ['jquery'], '', true);

    wp_enqueue_script('home_page_js');

    wp_register_script('donate_page_js', get_template_directory_uri() . '/js/donate-page.js', ['jquery'], '', true);

    wp_enqueue_script('donate_page_js');

}
add_action( 'wp_enqueue_scripts', 'dwellings_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom post types file.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Load custom breadcrumbs file.
 */
require get_template_directory() . '/inc/custom-breadcrumbs.php';

function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">See more</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

// Pagination

function custom_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /**	Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /**	Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="dwelling-pagination"><ul>' . "\n";

    /**	Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /**	Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /**	Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /**	Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /**	Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";

}

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