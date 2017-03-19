<?php
/*
Template Name: Projects_page

Description:  Projects_page
*/
?>

<?php get_header() ?>

<main id="content" class="site-content projects-page">
    <div class="container">

        <div class="top-part-content">
            <?php
            custom_breadcrumbs();
            ?>
        </div>


            <?php echo do_shortcode( '[campaigns]' ); ?>
<!--        /* this shortcode use theme_folder/charitable/campaign-loop.php  template */-->





    </div>
<?php custom_numeric_posts_nav() ?>







<?php get_footer();




