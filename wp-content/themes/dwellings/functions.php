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
        'description'   => esc_html__( 'Add widgets form.', 'dwellings' ),
        'before_widget' => '<diiv class="subscribe">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-footer">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Contact us widgets', 'dwellings' ),
        'id'            => 'sidebar-3',
        'description'   => esc_html__( 'Add widgets form.', 'dwellings' ),
        'before_widget' => '<diiv class="widget-contact">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-contact-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Learn more widget', 'dwellings' ),
        'id'            => 'sidebar-4',
        'description'   => esc_html__( 'Add widgets form.', 'dwellings' ),
        'before_widget' => '<div class="widget-learn-more">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-learn-more-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Tabs widget', 'dwellings' ),
        'id'            => 'sidebar-tabs-1',
        'description'   => esc_html__( 'Single campaign tabs donors-list', 'dwellings' ),
        'before_widget' => '<div class="widget-donors">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-donors-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Tabs widget', 'dwellings' ),
        'id'            => 'sidebar-tabs-2',
        'description'   => esc_html__( 'Single campaign tabs updates-list', 'dwellings' ),
        'before_widget' => '<div class="widget-updates">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-updates-title">',
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

    wp_register_script('learn_more_page_js', get_template_directory_uri() . '/js/learn-more-page.js', ['jquery'], '', true);

    wp_enqueue_script('learn_more_page_js');

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

/**
 * Load custom Pagination file.
 */
require get_template_directory() . '/inc/custom-pagination.php';

/**
 * Load custom Search file.
 */
require get_template_directory() . '/inc/custom-search.php';

/*
 * Break text for blog page
 */
add_filter("the_excerpt", "break_text");
function break_text($text){
    $length = 120;
    if(strlen($text)<$length+10) return $text;//don't cut if too short

    $break_pos = strpos($text, ' ', $length);//find next space after desired length
    $visible = substr($text, 0, $break_pos);
    return balanceTags($visible) . " …</p>";
}

function modify_products() {
    if ( post_type_exists( 'campaign' ) ) {
        global $wp_post_types;
        $wp_post_types['campaign']->has_archive=true;
        $wp_post_types['campaign']->labels->name= __('Candidate families', 'dwelling');
        $wp_post_types['campaign']->rewrite['slug']='candidate-families';
    }
}
add_action( 'init', 'modify_products', 100 );

add_filter('document_title_parts', function( $parts ){
    if( isset($parts['site']) ) unset($parts['site']);
    return $parts;
});

add_filter( 'gform_confirmation_anchor_2', function() {
    return 2000;
} );