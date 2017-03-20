<?php
get_header();?>
    <main id="content" class="site-content blog-page-main">
        <div class="container">
            <div class="row top-part-content">
                <?php
                custom_breadcrumbs();
                get_search_form();
                ?>
            </div>
            <section class="row blog-posts-section">
            <?php
            if ( have_posts() ) :

                /* Start the Loop */
                while ( have_posts() ) : the_post();
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', get_post_format() );

                endwhile;

                else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>
            </section>
            <?php custom_numeric_posts_nav() ?>
        </div>
<?php

get_footer();