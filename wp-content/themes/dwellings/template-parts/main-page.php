<?php
/*
Template Name: Template main page
*/
?>

<?php get_header() ?>

    <section class="hero">
        <div class="container">
            <h2 class="intro"><?php echo get_theme_mod('hero-intro'); ?></h2>
            <p class="intro-description"><?php echo get_theme_mod('hero_description'); ?></p>
            <a href="<?php echo get_theme_mod('btn_url'); ?>" class="btn"><?php echo get_theme_mod('btn_text'); ?></a>
        </div>
    </section>

<?php get_footer() ?>