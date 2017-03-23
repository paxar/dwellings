<?php

get_header();
?>

<p>Archive-campaign.php</p>





    <main id="content" class="site-content projects-page">
    <div class="container">

        <div class="top-part-content">
            <?php
            custom_breadcrumbs();
            ?>
        </div>

        <?php echo do_shortcode('[campaigns]'); ?>
        <!--        /* this shortcode use theme_folder/charitable/campaign-loop.php  template */-->

    </div>





<?php get_footer();

