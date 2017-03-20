<?php
/*
Template Name: Template donate page
*/
?>
<?php get_header() ?>
    <main id="content" class="site-content">

    <div class="container">
        <section class="donation">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="cover-organization">
                        <iframe width="100%" height="300px" src="<?php echo get_theme_mod('cover_organization-url'); ?>"
                                frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                    <h2 class="title-cover">
                        <?php echo get_theme_mod('cover_title'); ?>
                    </h2>
                    <p class="description-cover">
                        <?php echo get_theme_mod('cover_description'); ?>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="donation-wrap">
                        <div id="mcmeqeil46hzy"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php get_footer() ?>