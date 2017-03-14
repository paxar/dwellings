<?php
/*
Template Name: Template donation page
*/
?>

<?php get_header() ?>
    <main class="content">
        <div class="container">
            <section class="donation">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="cover-organization">
                            <iframe width="560" height="315" src="<?php echo get_theme_mod('cover_organization-url'); ?>" frameborder="0" allowfullscreen>
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
                        Место для Артема
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php get_footer() ?>