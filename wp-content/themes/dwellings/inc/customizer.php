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
    # Hero section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'hero-section',
        array(
            'title' => esc_html__('Hero settings'),
            'priority' => 10,
        )
    );
    $wp_customize->add_setting(
        'hero-intro'
    );
    $wp_customize->add_control(
        'hero-intro',
        array(
            'label' => esc_html__('Intro'),
            'section' => 'hero-section'
        )
    );
    $wp_customize->add_setting(
        'hero_description'
    );
    $wp_customize->add_control(
        'hero_description',
        array(
            'label' => esc_html__('Intro description'),
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
            'label' => esc_html__('Button URL'),
            'section' => 'hero-section'
        )
    );
    $wp_customize->add_setting(
        'btn_text'
    );
    $wp_customize->add_control(
        'btn_text',
        array(
            'label' => esc_html__('Button text'),
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
                'label' => esc_html__('Background image'),
                'section' => 'hero-section'
            )
        )
    );

    /*--------------------------------------------------------------
    # Donate page
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'cover-donate',
        array(
            'title' => esc_html__('Donation page'),
            'priority' => 10,
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
                'label' => esc_html__('Cover '.$cover[$i]),
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
            'label' => esc_html__('Cover description'),
            'section' => 'cover-donate',
            'type' => 'textarea'
        )
    );

    /*--------------------------------------------------------------
    # Footer
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'footer',
        array(
            'title' => esc_html__('Footer settings'),
            'priority' => 50,
        )
    );
    $wp_customize->add_setting(
        'copy',
        array(
            "default"=>esc_html__('Copy')
        )
    );
    $wp_customize->add_control(
        'copy',
        array(
            'label' => esc_html__('Copyright text'),
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
                'label' => esc_html__('Background color'),
                'section' => 'footer'
            )
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
