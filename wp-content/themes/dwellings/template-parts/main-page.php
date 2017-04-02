<?php
session_start();  /*Starting session for send variables   Added paxar*/
?>
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
                <a href="<?php echo get_permalink(get_theme_mod('btn_url')); ?>"
                   class="btn"><?php echo get_theme_mod('btn_text'); ?></a>
            <?php endif; ?>

        </div>
    </section>
    <main id="content" class="main-page">



    <!-- Icons section show there      -->

    <?php get_template_part('template-parts/icongroup', 'none'); ?>


    <section class="about">

        <div class="container">
            <div class="about-wrapper col-xs-12 col-sm-6 col-lg-6">
                <?php if (get_theme_mod('about-title') != ''): ?>
                    <h2 class="title-left title-small-decor"><?php echo get_theme_mod('about-title'); ?></h2>
                <?php endif; ?>
                <?php if (get_theme_mod('about_description') != ''): ?>
                    <p class="about-description"><?php echo get_theme_mod('about_description'); ?></p>
                <?php endif; ?>

                <?php if (get_theme_mod('about_btn_text') != ''): ?>
                    <a href="<?php echo get_permalink(get_theme_mod('about_btn_url')); ?>"
                       class="more-link"><?php echo get_theme_mod('about_btn_text'); ?></a>
                <?php endif; ?>

            </div>
        </div>
        <div class="about-image">

        </div>



    </section>

    <section class="families">
        <div class="container">
            <div class="row">
            <?php if (get_theme_mod('families-title') != ''): ?>
                <h2 class="title title-decor"><?php echo get_theme_mod('families-title'); ?></h2>
            <?php endif; ?>

            <?php
            $args = array(
                'post_type' => 'campaign',
                'posts_per_page' => get_theme_mod('families-posts'),
                'paged' => $paged
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                $campaign = charitable_get_current_campaign();
                ?>
                <div class="col-xs-12 col-sm-4">
                    <div class="families-item ">
                        <div class="img-wrap">
                            <?php
                            // image
                            $thumbnail_size = apply_filters('charitable_campaign_loop_thumbnail_size', 'large');
                            if (has_post_thumbnail($campaign->ID)) :
                                echo get_the_post_thumbnail($campaign->ID, $thumbnail_size);
                            endif;
                            // end image
                            ?>
                            <div class="hover">
                                <a class="hover-button" href="<?php the_permalink() ?> ">Explore</a>
                            </div>
                        </div>
                        <div class="families-item-description">
                            <h3 class="item-title"><?php the_title() ?> Family</h3>

                            <div class="item-info">
                                <?php echo $campaign->description ?>
                            </div>


                        </div>


                    </div>
                </div>


            <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>




        </div>

            <div class="families-map">
                <?php echo do_shortcode('[campaigns map=1 zoom=2]'); ?>
            </div>

            <?php if (get_theme_mod('families_btn_text') != ''): ?>
                <a href="<?php echo get_permalink(get_theme_mod('families_btn_url')); ?>"
                   class="more-link"><?php echo get_theme_mod('families_btn_text'); ?></a>
            <?php endif; ?>
        </div>

    </section>

    <section class="testimonials main-testimonials">
        <div class="container">
            <?php if (get_theme_mod('testimonials-title') != ''): ?>
                <h2 class="title title-decor"><?php echo get_theme_mod('testimonials-title'); ?></h2>
            <?php endif; ?>
            <ul class="row wrap-quote">

                <?php
                $args = array(
                    'post_type' => 'section-testimonials',
                    'posts_per_page' => get_theme_mod('testimonials-posts'),
                    'paged' => $paged
                );
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>

                    <?php get_template_part('template-parts/post/content', 'testimonials') ?>

                <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

            </ul>
            <?php if (get_theme_mod('testimonials_btn_text') != ''): ?>
                <a href="<?php echo get_permalink(get_theme_mod('testimonials_btn_url')); ?>"
                   class="more-link"><?php echo get_theme_mod('testimonials_btn_text'); ?></a>
            <?php endif; ?>
        </div>
    </section>

    <section class="info">

        <div class="container">


            <div class="info-wrapper col-xs-12 col-md-5 col-lg-4">
                <?php if (get_theme_mod('info-title') != ''): ?>
                    <h2 class="info-title"><?php echo get_theme_mod('info-title'); ?></h2>
                <?php endif; ?>
                <?php if (get_theme_mod('info_description') != ''): ?>
                    <p class="info-description"><?php echo get_theme_mod('info_description'); ?></p>
                <?php endif; ?>

                <?php if (get_theme_mod('info_btn_text') != ''): ?>
                    <a href="<?php echo get_permalink(get_theme_mod('info_btn_url')); ?>"
                       class="btn"><?php echo get_theme_mod('info_btn_text'); ?></a>
                <?php endif; ?>

            </div>

        </div>


    </section>



<?php get_footer() ?>