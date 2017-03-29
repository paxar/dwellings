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
            'section' => 'hero-section',
            'type'     => 'dropdown-pages'
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
    # about section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'about-section',
        array(
            'title' => esc_html__('About settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'main_page',
        )
    );
    $wp_customize->add_setting(
        'about-title'
    );
    $wp_customize->add_control(
        'about-title',
        array(
            'label' => esc_html__('About title', 'dwellings'),
            'section' => 'about-section'
        )
    );
    $wp_customize->add_setting(
        'about_description'
    );
    $wp_customize->add_control(
        'about_description',
        array(
            'label' => esc_html__('About description', 'dwellings'),
            'section' => 'about-section',
            'type' => 'textarea'
        )
    );
    $wp_customize->add_setting(
        'about_btn_text'
    );
    $wp_customize->add_control(
        'about_btn_text',
        array(
            'label' => esc_html__('About button text', 'dwellings'),
            'section' => 'about-section'
        )
    );
    $wp_customize->add_setting(
        'about_btn_url'
    );
    $wp_customize->add_control(
        'about_btn_url',
        array(
            'label' => esc_html__('About button URL', 'dwellings'),
            'section' => 'about-section',
            'type'     => 'dropdown-pages'
        )
    );

    $wp_customize->add_setting(
        'bg-about'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'bg-about',
            array(
                'label' => esc_html__('Background image', 'dwellings'),
                'section' => 'about-section'
            )
        )
    );
    $wp_customize->add_setting(
        'about_hide'
    );
    $wp_customize->add_control(
        'about_hide',
        array(
            'label' => esc_html__('Show section', 'dwellings'),
            'section' => 'about-section',
            'type'     => 'checkbox'
        )
    );

    /*--------------------------------------------------------------
    # Families section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'families-section',
        array(
            'title' => esc_html__('Families settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'main_page',
        )
    );
    $wp_customize->add_setting(
        'families-title'
    );
    $wp_customize->add_control(
        'families-title',
        array(
            'label' => esc_html__('Families title', 'dwellings'),
            'section' => 'families-section'
        )
    );
    $wp_customize->add_setting(
        'families-posts'
    );
    $wp_customize->add_control(
        'families-posts',
        array(
            'label' => esc_html__('Families post count', 'dwellings'),
            'section' => 'families-section'
        )
    );

    $wp_customize->add_setting(
        'families_btn_text'
    );
    $wp_customize->add_control(
        'families_btn_text',
        array(
            'label' => esc_html__('Families button text', 'dwellings'),
            'section' => 'families-section'
        )
    );
    $wp_customize->add_setting(
        'families_btn_url'
    );
    $wp_customize->add_control(
        'families_btn_url',
        array(
            'label' => esc_html__('Families button URL', 'dwellings'),
            'section' => 'families-section',
            'type'     => 'dropdown-pages'
        )
    );
    $wp_customize->add_setting(
        'families_map_hide'
    );
    $wp_customize->add_control(
        'families_map_hide',
        array(
            'label' => esc_html__('Show map', 'dwellings'),
            'section' => 'families-section',
            'type'     => 'checkbox'
        )
    );

    $wp_customize->add_setting(
        'families_hide'
    );
    $wp_customize->add_control(
        'families_hide',
        array(
            'label' => esc_html__('Show section', 'dwellings'),
            'section' => 'families-section',
            'type'     => 'checkbox'
        )
    );
    /*--------------------------------------------------------------
   # Testimonials section
   --------------------------------------------------------------*/
    $wp_customize->add_section(
        'testimonials-section',
        array(
            'title' => esc_html__('Testimonials settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'main_page',
        )
    );
    $wp_customize->add_setting(
        'testimonials-title'
    );
    $wp_customize->add_control(
        'testimonials-title',
        array(
            'label' => esc_html__('Testimonials title', 'dwellings'),
            'section' => 'testimonials-section'
        )
    );
    $wp_customize->add_setting(
        'testimonials-posts'
    );
    $wp_customize->add_control(
        'testimonials-posts',
        array(
            'label' => esc_html__('Testimonials post count', 'dwellings'),
            'section' => 'testimonials-section'
        )
    );

    $wp_customize->add_setting(
        'testimonials_btn_text'
    );
    $wp_customize->add_control(
        'testimonials_btn_text',
        array(
            'label' => esc_html__('Testimonials button text', 'dwellings'),
            'section' => 'testimonials-section'
        )
    );
    $wp_customize->add_setting(
        'testimonials_btn_url'
    );
    $wp_customize->add_control(
        'testimonials_btn_url',
        array(
            'label' => esc_html__('Testimonials button URL', 'dwellings'),
            'section' => 'testimonials-section',
            'type'     => 'dropdown-pages'
        )
    );


    $wp_customize->add_setting(
        'testimonials_hide'
    );
    $wp_customize->add_control(
        'testimonials_hide',
        array(
            'label' => esc_html__('Show section', 'dwellings'),
            'section' => 'testimonials-section',
            'type'     => 'checkbox'
        )
    );
    /*--------------------------------------------------------------
   # Info section
   --------------------------------------------------------------*/
    $wp_customize->add_section(
        'info-section',
        array(
            'title' => esc_html__('Info settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'main_page',
        )
    );
    $wp_customize->add_setting(
        'info-title'
    );
    $wp_customize->add_control(
        'info-title',
        array(
            'label' => esc_html__('info title', 'dwellings'),
            'section' => 'info-section'
        )
    );
    $wp_customize->add_setting(
        'info_description'
    );
    $wp_customize->add_control(
        'info_description',
        array(
            'label' => esc_html__('Info description', 'dwellings'),
            'section' => 'info-section',
            'type' => 'textarea'
        )
    );
    $wp_customize->add_setting(
        'info_btn_text'
    );
    $wp_customize->add_control(
        'info_btn_text',
        array(
            'label' => esc_html__('Info button text', 'dwellings'),
            'section' => 'info-section'
        )
    );
    $wp_customize->add_setting(
        'info_btn_url'
    );
    $wp_customize->add_control(
        'info_btn_url',
        array(
            'label' => esc_html__('Info button URL', 'dwellings'),
            'section' => 'info-section',
            'type'     => 'dropdown-pages'
        )
    );

    $wp_customize->add_setting(
        'bg-info'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'bg-info',
            array(
                'label' => esc_html__('Background image', 'dwellings'),
                'section' => 'info-section'
            )
        )
    );
    $wp_customize->add_setting(
        'info_hide'
    );
    $wp_customize->add_control(
        'info_hide',
        array(
            'label' => esc_html__('Show section', 'dwellings'),
            'section' => 'info-section',
            'type'     => 'checkbox'
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
            'title' => esc_html__('Donation', 'dwellings'),
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

    /*--------------------------------------------------------------
    # Contact-us page panel
    --------------------------------------------------------------*/
    $wp_customize->add_panel( 'contact_us_page', array(
        'priority' => 11,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'Contact-us page', 'dwellings' ),
        'description' => __( 'Settings of contact-us page.', 'dwellings' ),
    ) );

    /*--------------------------------------------------------------
    # Contact-us section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'cover-contact-us',
        array(
            'title' => esc_html__('Contact-us', 'dwellings'),
            'priority' => 10,
            'panel' => 'contact_us_page'
        )
    );
    $contact = array("person", "email", "phone", "address",);
    for ($i=0; $i<count($contact); $i++) {
        $wp_customize->add_setting(
            'contact_'.$contact[$i]
        );
        $wp_customize->add_control(
            'contact_'.$contact[$i],
            array(
                'label' => esc_html__('Contact '.$contact[$i], 'dwellings'),
                'section' => 'cover-contact-us'
            )
        );
    }
    $wp_customize->add_setting(
        'cover-contact-img'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'cover-contact-img',
            array(
                'label' => esc_html__('Background image', 'dwellings'),
                'section' => 'cover-contact-us'
            )
        )
    );

    /*--------------------------------------------------------------
    # Learn more panel
    --------------------------------------------------------------*/
    $wp_customize->add_panel( 'learn_more_page', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'Learn more', 'dwellings' ),
        'description' => __( 'Settings of learn more page.', 'dwellings' ),
    ) );

    /*--------------------------------------------------------------
    # Learn more - > Hero section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'learn-more-hero-section',
        array(
            'title' => esc_html__('Hero settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'learn_more_page',
        )
    );
    $wp_customize->add_setting(
        'bg-hero-learn'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'bg-hero-learn',
            array(
                'label' => esc_html__('Background image', 'dwellings'),
                'section' => 'learn-more-hero-section'
            )
        )
    );
    $wp_customize->add_setting(
        'learn-more-hero-show',
        array(
            'default'    =>  'true',
            'transport'  =>  'postMessage'
        ));
    $wp_customize->add_control(
        'learn-more-hero-show',
        array(
            'section'   => 'learn-more-hero-section',
            'label'     => esc_html__('Display Section?', 'dwellings' ),
            'type'      => 'checkbox'
        )
    );
    /*--------------------------------------------------------------
    # Learn more -> Right image section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'right-image-section',
        array(
            'title' => esc_html__('Right image section', 'dwellings'),
            'priority' => 10,
            'panel' => 'learn_more_page',
        )
    );
    $wp_customize->add_setting(
        'right-image-section-title'
    );
    $wp_customize->add_control(
        'right-image-section-title',
        array(
            'label' => esc_html__('Title', 'dwellings'),
            'section' => 'right-image-section'
        )
    );
    $wp_customize->add_setting(
        'right-image-section-paragraph1'
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'right-image-section-paragraph1',
            array(
                'label'          => __( 'First paragraph', 'dwellings' ),
                'section'        => 'right-image-section',
                'type'           => 'textarea'
            )
        )
    );
    $wp_customize->add_setting(
        'right-image-section-paragraph2'
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'right-image-section-paragraph2',
            array(
                'label'          => __( 'Second paragraph', 'dwellings' ),
                'section'        => 'right-image-section',
                'type'           => 'textarea'
            )
        )
    );
    $wp_customize->add_setting(
        'right-image-section-image'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'right-image-section-image',
            array(
                'label' => esc_html__('Section image', 'dwellings'),
                'section' => 'right-image-section'
            )
        )
    );
    $wp_customize->add_setting(
        'learn-more-right-show',
        array(
            'default'    =>  'true',
            'transport'  =>  'postMessage'
        ));
    $wp_customize->add_control(
        'learn-more-right-show',
        array(
            'section'   => 'right-image-section',
            'label'     => esc_html__('Display Section?', 'dwellings' ),
            'type'      => 'checkbox'
        )
    );
    /*--------------------------------------------------------------
    # Learn more -> Left image section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'left-image-section',
        array(
            'title' => esc_html__('Left image section', 'dwellings'),
            'priority' => 10,
            'panel' => 'learn_more_page',
        )
    );
    $wp_customize->add_setting(
        'left-image-section-title'
    );
    $wp_customize->add_control(
        'left-image-section-title',
        array(
            'label' => esc_html__('Title', 'dwellings'),
            'section' => 'left-image-section'
        )
    );
    $wp_customize->add_setting(
        'left-image-section-paragraph1'
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'left-image-section-paragraph1',
            array(
                'label'          => __( 'First paragraph', 'dwellings' ),
                'section'        => 'left-image-section',
                'type'           => 'textarea'
            )
        )
    );
    $wp_customize->add_setting(
        'left-image-section-paragraph2'
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'left-image-section-paragraph2',
            array(
                'label'          => __( 'Second paragraph', 'dwellings' ),
                'section'        => 'left-image-section',
                'type'           => 'textarea'
            )
        )
    );
    $wp_customize->add_setting(
        'left-image-section-image'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'left-image-section-image',
            array(
                'label' => esc_html__('Section image', 'dwellings'),
                'section' => 'left-image-section'
            )
        )
    );
    $wp_customize->add_setting(
        'learn-more-left-show',
        array(
            'default'    =>  'true',
            'transport'  =>  'postMessage'
        ));
    $wp_customize->add_control(
        'learn-more-left-show',
        array(
            'section'   => 'left-image-section',
            'label'     => esc_html__('Display Section?', 'dwellings' ),
            'type'      => 'checkbox'
        )
    );
    /*--------------------------------------------------------------
        # Learn more -> Contact section
        --------------------------------------------------------------*/
    $wp_customize->add_section(
        'learn-more-contact-section',
        array(
            'title' => esc_html__('Contact settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'learn_more_page',
        )
    );
    $wp_customize->add_setting(
        'learn-more-contact-title'
    );
    $wp_customize->add_control(
        'learn-more-contact-title',
        array(
            'label' => esc_html__('Title', 'dwellings'),
            'section' => 'learn-more-contact-section'
        )
    );
    $wp_customize->add_setting(
        'learn-more-contact-description'
    );
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'learn-more-contact-description',
            array(
                'label'          => __( 'Description', 'dwellings' ),
                'section'        => 'learn-more-contact-section',
                'type'           => 'textarea'
            )
        )
    );
    $wp_customize->add_setting(
        'learn-more-contact-show',
         array(
        'default'    =>  'true',
        'transport'  =>  'postMessage'
    ));
    $wp_customize->add_control(
        'learn-more-contact-show',
        array(
            'section'   => 'learn-more-contact-section',
            'label'     => esc_html__('Display Section?', 'dwellings' ),
            'type'      => 'checkbox'
        )
    );

    /*--------------------------------------------------------------
    # About us page panel
    --------------------------------------------------------------*/
    $wp_customize->add_panel( 'about_us_page', array(
        'priority' => 11,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'About-us page', 'dwellings' ),
        'description' => __( 'Settings of about-us page.', 'dwellings' ),
    ) );

    /*--------------------------------------------------------------
    # About-us section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'section-about-us',
        array(
            'title' => esc_html__('About us settings', 'dwellings'),
            'priority' => 10,
            'panel' => 'about_us_page',
        )
    );
    $wp_customize->add_setting(
        'description_abut_us'
    );
    $wp_customize->add_control(
        'description_abut_us',
        array(
            'label' => esc_html__('Description about us', 'dwellings'),
            'section' => 'section-about-us',
            'type' => 'textarea'
        )
    );
    $wp_customize->add_setting(
        'title_testimonials'
    );
    $wp_customize->add_control(
        'title_testimonials',
        array(
            'label' => esc_html__('Title testimonials', 'dwellings'),
            'section' => 'section-about-us'
        )
    );
    $wp_customize->add_setting(
        'about-cover-image'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about-cover-image',
            array(
                'label' => esc_html__('Section image', 'dwellings'),
                'section' => 'section-about-us'
            )
        )
    );
    /*--------------------------------------------------------------
    # Thank section
    --------------------------------------------------------------*/
    $wp_customize->add_section(
        'thank-section',
        array(
            'title' => esc_html__('Thank settings', 'dwellings'),
            'priority' => 10
        )
    );
    $wp_customize->add_setting(
        'title_thank'
    );
    $wp_customize->add_control(
        'title_thank',
        array(
            'label' => esc_html__('Gratitude', 'dwellings'),
            'section' => 'thank-section'
        )
    );
    $wp_customize->add_setting(
        'thank-setting'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'thank-setting',
            array(
                'label' => esc_html__('Thank image', 'dwellings'),
                'section' => 'thank-section'
            )
        )
    );
    /*--------------------------------------------------------------
   # Contact-us section
   --------------------------------------------------------------*/
    $wp_customize->add_section(
        'not-found-page',
        array(
            'title' => esc_html__('Error 404', 'dwellings'),
            'priority' => 200
        )
    );
    $wp_customize->add_setting(
        'not-found'
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'not-found',
            array(
                'label' => esc_html__('Icon 404 page', 'dwellings'),
                'section' => 'not-found-page'
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
        .info {
            background: url(<?php echo get_theme_mod('bg-info') ?>)center /cover no-repeat;


        }
        .about-image {
            background: url(<?php echo get_theme_mod('bg-about') ?>)center /cover no-repeat;


        }
        .site-footer {
            background-color: <?php echo get_theme_mod('bg-footer') ?>;
        }
        .map-learn-more {
            background: url(<?php echo get_theme_mod('bg-hero-learn')  ?>) center center /cover no-repeat;
        }

        <?php if( false === get_theme_mod( 'testimonials_hide' ) ) { ?>
        .main-testimonials { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'families_hide' ) ) { ?>
        .families { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'families_map_hide' ) ) { ?>
        .families-map { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'about_hide' ) ) { ?>
        .about { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'info_hide' ) ) { ?>
        .info { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'learn-more-hero-show' ) ) { ?>
        .map-learn-more { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'learn-more-left-show' ) ) { ?>
        .left-image-section { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'learn-more-right-show' ) ) { ?>
        .right-image-section { display: none; }
        <?php } // end if ?>
        <?php if( false === get_theme_mod( 'learn-more-contact-show' ) ) { ?>
        .learn-more-contact { display: none; }
        <?php } // end if ?>

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
