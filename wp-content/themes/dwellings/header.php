<?php
session_start();  /*Starting session for send variables   Added paxar*/
?>

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
        <?php
        global $user_ID, $user_identity;

        ?>
        <!--<nav id="page" class="site">-->
        <!--<a class="skip-link screen-reader-text" href="#content"><?php /*esc_html_e( 'Skip to content', 'dwellings' ); */ ?></a>-->
        <div id="container">
            <header id="masthead" class="site-header header-page" role="banner">
                <div class="header-wrap container">

                    <h1 class="logo">
						<?php the_custom_logo(); ?>
                        Dwellings
                    </h1>
                    <nav class="main-nav">
                        <button class="nav-btn open-btn" id="open-nav">
                            <i class="fa fa-bars"></i>
                        </button>
                        <button class="nav-btn close-btn remove-btn" id="close-nav">
                            <i class="fa fa-times"></i>
                        </button>
                        <a href="<?php echo get_permalink( get_theme_mod( 'url_login' ) ); ?>" class="login sign-in"><i
                                    class="fa fa-user"></i></a>
                        <div class="login-wrap">
                            <a href="<?php echo home_url() . '/charitable-profile/'  ?>" class="login username"><?php echo $user_identity; ?> </a>
                            <a href="<?php echo wp_logout_url( home_url() ); ?>" class="login sign-out"><i
                                        class="fa fa-sign-out"></i></a>

                        </div>


						<?php wp_nav_menu( array(
							'them_location' => 'menu-1',
							'container'     => false,
							'menu_class'    => 'navigation'
						) ) ?>
                </div>

            </header><!-- #masthead -->
        </div><!-- .container -->
