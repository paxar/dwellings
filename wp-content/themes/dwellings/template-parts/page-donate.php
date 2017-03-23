<?php
/*
Template Name: Template donate page
*/
?>
<?php get_header() ?>
    <main id="content" class="site-content">

        <section class="donation">
            <div class="container">
                <div class="donation-block">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="organization-wrap">
                                <div class="cover-organization">

                                    <?php if (get_theme_mod('cover_organization-url') != ''): ?>
                                        <iframe width="100%" height="300px" src="<?php echo get_theme_mod('cover_organization-url'); ?>"
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                                <h2 class="title-cover">

                                    <?php if (get_theme_mod('cover_title') != ''): ?>
                                        <?php echo get_theme_mod('cover_title'); ?>
                                    <?php endif; ?>

                                </h2>

                                <?php if (get_theme_mod('cover_description') != ''): ?>
                                <p class="description-cover">
                                    <?php echo get_theme_mod('cover_description'); ?>
                                </p>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="donation-wrap">
                                <div id="mcmeqeil46hzy"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php get_footer() ?>