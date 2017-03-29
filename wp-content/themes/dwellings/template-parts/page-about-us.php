<?php
/*
Template Name: Template about us page
*/
?>
<?php get_header(); ?>

    <?php get_template_part('template-parts/post/content', 'about-us') ?>

    <main id="content" class="site-content about-us-page">

    <section class="testimonials">
        <div class="container">
            <?php if (get_theme_mod('title_testimonials') != ''): ?>
                <h2 class="title title-decor"><?php echo get_theme_mod('title_testimonials'); ?></h2>
            <?php endif; ?>
            <ul class="row wrap-quote">

                <?php
                $args = array(
                    'post_type' => 'section-testimonials',
                    'posts_per_page' => 10,
                    'paged' => $paged
                );
                $the_query = new WP_Query($args);
                if ( $the_query -> have_posts() ) : while ( $the_query -> have_posts() ) : $the_query -> the_post(); ?>

                    <?php get_template_part('template-parts/post/content', 'testimonials') ?>

                <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

            </ul>
            <?php /*Pagination*/
            if (function_exists("custom_numeric_posts_nav")) {
                custom_numeric_posts_nav($the_query);
            } ?>
        </div>
    </section>

<?php get_footer();
