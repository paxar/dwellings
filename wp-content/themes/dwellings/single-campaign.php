<?php
/*
 * Template Name: Template single-campaign
 * Testing page*/
?>
<?php get_header(); ?>

    <p>Single cammaign page !</p>

    <main id="content" class="site-content projects-post">
        <div class="container">
            <div class="top-part-content">
                <?php
                custom_breadcrumbs();
                ?>
            </div>

            <?php
            while (have_posts()) : the_post();

               get_template_part( 'charitable/content-campaign', get_post_format() );
                //the_content();

            endwhile; // End of the loop.
            ?>


        </div><!-- #primary -->
    </main><!-- #main -->

<?php
get_sidebar();
get_footer();
