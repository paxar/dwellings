<?php
get_header();?>

<!--    <div id="primary" class="content-area">-->
        <main id="content" class="site-content">
        <div class="container">
            <section class="blog-page-section">
            <div class="top-part-content">
                <?php
                custom_breadcrumbs();
                get_search_form();
                ?>
            </div>
            <?php
            if ( have_posts() ) :

                /* Start the Loop */
                while ( have_posts() ) : the_post();
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content-blog-page', get_post_format() );

                endwhile;

                the_posts_navigation();

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>
            </section>
        </div><!-- #primary -->
    </main><!-- #main -->

<?php

get_footer();