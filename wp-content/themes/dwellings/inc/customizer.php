<?php
/**
 * Dwellings site Theme Customizer
 *
 * @package Dwellings_site
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function dwellings_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    /*--------------------------------------------------------------
    # Main page panel
    --------------------------------------------------------------*/
    $wp_customize->add_panel( 'main_page', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'Main page', 'dwellings' ),
        'description' => __( 'Settings of main page.', 'dwellings' ),
    ) );

    /*--------------------------------------------------------------
    # Hero section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'hero-section',
        array(
            'title' => esc_html__('Hero settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'main_page',
        )
    );
    $wp_customize->add_setting(
        'hero-intro'
    );
    $wp_customize->add_control(
        'hero-intro',
        array(
            'label' => esc_html__('Intro', 'dwellings'),
            'section' => 'hero-section'
        )
    );
    $wp_customize->add_setting(
        'hero_description'
    );
    $wp_customize->add_control(
        'hero_description',
        array(
            'label' => esc_html__('Intro description', 'dwellings'),
            'section' => 'hero-section',
            'type' => 'textarea'
        )
    );
    $wp_customize->add_setting(
        'btn_url'
    );
    $wp_customize->add_control(
        'btn_url',
        array(
            'label' => esc_html__('Button URL', 'dwellings'),
            'section' => 'hero-section'
        )
    );
    $wp_customize->add_setting(
        'btn_text'
    );
    $wp_customize->add_control(
        'btn_text',
        array(
            'label' => esc_html__('Button text', 'dwellings'),
            'section' => 'hero-section'
        )
    );
    $wp_customize->add_setting(
        'bg-hero'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'bg-hero',
            array(
                'label' => esc_html__('Background image', 'dwellings'),
                'section' => 'hero-section'
            )
        )
    );

    /*--------------------------------------------------------------
    # Example section
    --------------------------------------------------------------*/
    $wp_customize->add_section( 'section_test', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'Example Section', 'dwellings' ),
        'description' => '',
        'panel' => 'main_page',
    ) );

    $wp_customize->add_setting(
        'test',
        array(
            'default' => 'Hello'
        )
    );
    $wp_customize->add_control(
        'test',
        array(
            'label' => esc_html__('test', 'dwellings'),
            'section' => 'section_test',
            'type' => 'textarea'
        )
    );

    /*--------------------------------------------------------------
    # Footer
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'footer',
        array(
            'title' => esc_html__('Footer settings', 'dwellings'),
            'priority' => 50,
            'panel' => 'main_page',
        )
    );
    $wp_customize->add_setting(
        'copy',
        array(
            "default"=>esc_html__('Copy', 'dwellings')
        )
    );
    $wp_customize->add_control(
        'copy',
        array(
            'label' => esc_html__('Copyright text', 'dwellings'),
            'section' => 'footer'
        )
    );
    $wp_customize->add_setting(
        'bg-footer',
        array(
            'default' => '#fff'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'bg-footer',
            array(
                'label' => esc_html__('Background color', 'dwellings'),
                'section' => 'footer'
            )
        )
    );

    /*--------------------------------------------------------------
    # Donate page panel
    --------------------------------------------------------------*/
    $wp_customize->add_panel( 'donate_page', array(
        'priority' => 11,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'Donate page', 'dwellings' ),
        'description' => __( 'Settings of donate page.', 'dwellings' ),
    ) );

    /*--------------------------------------------------------------
    # Donate section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'cover-donate',
        array(
            'title' => esc_html__('Donation page', 'dwellings'),
            'priority' => 10,
            'panel' => 'donate_page'
        )
    );
	$cover = array("organization-url", "title");
    for ($i=0; $i<count($cover); $i++) {
        $wp_customize->add_setting(
            'cover_'.$cover[$i]
        );
        $wp_customize->add_control(
            'cover_'.$cover[$i],
            array(
                'label' => esc_html__('Cover '.$cover[$i], 'dwellings'),
                'section' => 'cover-donate'
            )
        );
    }
    $wp_customize->add_setting(
        'cover_description'
    );
    $wp_customize->add_control(
        'cover_description',
        array(
            'label' => esc_html__('Cover description', 'dwellings'),
            'section' => 'cover-donate',
            'type' => 'textarea'
        )
    );

}
add_action( 'customize_register', 'dwellings_customize_register' );

function custom_style() {
    ?>
    <style type="text/css">
        .hero {
            background: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url(<?php echo get_theme_mod('bg-hero') ?>) 50% 0 /cover no-repeat;
        }
        .site-footer {
            background-color: <?php echo get_theme_mod('bg-footer') ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'custom_style');


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function dwellings_customize_preview_js() {
	wp_enqueue_script( 'dwellings_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'dwellings_customize_preview_js' );
