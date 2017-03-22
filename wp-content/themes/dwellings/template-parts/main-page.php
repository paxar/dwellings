<?php
/*
Template Name: Template main page
*/
?>

<?php get_header() ?>

    <section class="hero">
        <div class="container">

            <?php if (get_theme_mod('hero-intro') != ''): ?>
                <h2 class="intro"><?php echo get_theme_mod('hero-intro'); ?></h2>
            <?php endif; ?>

            <?php if (get_theme_mod('hero_description') != ''): ?>
                <p class="intro-description"><?php echo get_theme_mod('hero_description'); ?></p>
            <?php endif; ?>

             <?php if (get_theme_mod('btn_text') != ''): ?>
                <a href="<?php echo get_theme_mod('btn_url'); ?>" class="btn"><?php echo get_theme_mod('btn_text'); ?></a>
             <?php endif; ?>

        </div>
    </section>
    <main id="content" class="site-content">



        <!-- Icons section show there      -->

       <?php get_template_part( 'template-parts/icongroup', 'none' ); ?>


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