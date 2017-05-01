<?php
/*
Template Name: Projects_page

Description: Dwellings Projects_page
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
        <a class="projects-donate-button" href="<?php echo home_url() . '/finished-campaigns/';?>">Get finished campaigns</a>


        <?php echo do_shortcode('[campaigns]'); ?>
        <!--        /* this shortcode use theme_folder/charitable/campaign-loop.php  template */-->

    </div>





<?php get_footer();




