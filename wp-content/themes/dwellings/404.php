<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Dwellings_site
 */

get_header() ?>
<main id="content" class="site-content blog-page-main">

    <section class="thank not-found">
        <div class="container">
            <div class="thank-block error-block">
                <img src="<?php echo get_theme_mod('not-found') ?>" alt="<?php echo get_theme_mod('not-found') ?>">
                <h2><?php echo esc_html__('Page not found!', 'dwellings'); ?></h2>
            </div>
        </div>
    </section>

<?php get_footer() ?>
