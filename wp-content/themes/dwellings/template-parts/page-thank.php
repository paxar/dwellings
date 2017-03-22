<?php
/*
Template Name: Template thank page
*/
?>
<?php get_header() ?>
    <main id="content" class="site-content">

    <section class="thank">
        <div class="container">
            <div class="thank-block">
                <img src="<?php echo get_theme_mod('thank-setting') ?>" alt="<?php echo get_theme_mod('thank-setting') ?>">
                <h2><?php echo get_theme_mod('title_thank') ?></h2>
            </div>
        </div>
    </section>

<?php get_footer() ?>