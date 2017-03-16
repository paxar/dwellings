<?php
get_header();?>
    <main id="content" class="site-content">
        <div class="container">
            <div class="top-part-content">
                <?php
                custom_breadcrumbs();
                get_search_form();
                ?>
            </div>
            <section class="blog-page-section">
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

                custom_numeric_posts_nav();

                else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>
            </section>
        </div>
    </main><!-- #main -->
<?php

get_footer();