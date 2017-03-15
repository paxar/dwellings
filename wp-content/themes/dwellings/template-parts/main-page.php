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


    <section class="icongroup">

        <!-- TODO add loop there       -->
    </section>

    <section class="about">

        <!-- TODO add custom fields there       -->
    </section>

    <section class="families">

        <!-- TODO add loop there       -->
    </section>

    <section class="testimonials">

        <!-- TODO add loop there       -->
    </section>

    <section class="info">

        <!-- TODO add custom fields there       -->
    </section>



<?php get_footer() ?>