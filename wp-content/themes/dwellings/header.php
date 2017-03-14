<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Dwellings_site
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<nav id="page" class="site">
	<!--<a class="skip-link screen-reader-text" href="#content"><?php /*esc_html_e( 'Skip to content', 'dwellings' ); */?></a>-->

	<header id="masthead" class="site-header" role="banner">
        <div class="container">
            <h1 class="logo">
                <?php the_custom_logo(); ?>
                Dwellings
            </h1>
            <nav class="main-nav">
                <button class="nav-btn open-btn" id="open-nav">
                    <i class="fa fa-bars"></i>
                </button>

                <?php wp_nav_menu(array('them_location' => 'menu-1', 'container' => false, 'menu_class' => 'navigation')) ?>

                <?php
                if ( is_front_page() && is_home() ) : ?>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                endif;

                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                <?php
                endif; ?>

        </div><!-- .container -->

	</header><!-- #masthead -->

	<main id="content" class="site-content">
