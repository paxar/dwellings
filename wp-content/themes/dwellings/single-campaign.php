<?php
/*Testing page*/
?>
<?php get_header(); ?>

<p>Single cammaign page !</p>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        while ( have_posts() ) : the_post();

          the_content();

        endwhile; // End of the loop.
        ?>


    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
