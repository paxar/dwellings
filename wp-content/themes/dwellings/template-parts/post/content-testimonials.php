<?php
/**
 * Testimonials section
 * use in homepage and about us pages
 */
?>

<section class="testimonials">
    <div class="container">
        <h2 class="title title-decor"><?php echo get_theme_mod('title_testimonials'); ?></h2>
        <ul class="row wrap-quote">

            <?php
            $args = array(
                'post_type' => 'section-testimonials',
                'posts_per_page' => 10,
                'paged' => $paged
            );
            $the_query = new WP_Query($args);
            if ( $the_query -> have_posts() ) : while ( $the_query -> have_posts() ) : $the_query -> the_post(); ?>

                <li class="col-xs-12 col-md-6 single-quote">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="avatar-quote">
                                <?= the_post_thumbnail(); ?>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="content-quote">
                                <?php the_content(); ?>
                                <div class="author-quote">
                                    <span class="name-author">
                                        <?= get_post_meta($post->ID, 'author_quote', true) ?>
                                    </span>
                                    <span class="name-organization">
                                         - <?= get_post_meta($post->ID, 'name_organization', true) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

        </ul>
        <?php custom_numeric_posts_nav($the_query); ?>
    </div>
</section>