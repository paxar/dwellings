<?php
/*
Template Name: Template learn more page
*/
?>
<?php get_header() ?>
<main id="content" class="learn-more-content">
    <section class="map-learn-more"></section>
    <?php get_template_part( 'template-parts/icongroup', 'none' ); ?>
    <div class="container">
        <section class="right-image-section">
            <div class="learn-image-box">
                <?php if (get_theme_mod('right-image-section-image')) : ?>
                     <img src="<?php echo get_theme_mod('right-image-section-image'); ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="section-info">
                <?php if (get_theme_mod('right-image-section-title')) : ?>
                    <h2 class="learn-section-title"><?php echo get_theme_mod('right-image-section-title'); ?></h2>
                <?php endif; ?>
                <?php if (get_theme_mod('right-image-section-paragraph1')) : ?>
                    <p class="learn-paragraph"><?php echo get_theme_mod('right-image-section-paragraph1'); ?></p>
                <?php endif; ?>
                <?php if (get_theme_mod('right-image-section-paragraph2')) : ?>
                    <p class="learn-paragraph"><?php echo get_theme_mod('right-image-section-paragraph2'); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <section class="left-image-section">
            <div class="learn-image-box">
                <?php if (get_theme_mod('left-image-section-image')) : ?>
                    <img src="<?php echo get_theme_mod('left-image-section-image'); ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="section-info">
                <?php if (get_theme_mod('left-image-section-title')) : ?>
                    <h2 class="learn-section-title"><?php echo get_theme_mod('left-image-section-title'); ?></h2>
                <?php endif; ?>
                <?php if (get_theme_mod('left-image-section-paragraph1')) : ?>
                    <p class="learn-paragraph"><?php echo get_theme_mod('left-image-section-paragraph1'); ?></p>
                <?php endif; ?>
                <?php if (get_theme_mod('left-image-section-paragraph2')) : ?>
                    <p class="learn-paragraph"><?php echo get_theme_mod('left-image-section-paragraph2'); ?></p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <section class="learn-more-contact">
        <div class="container">
            <?php if (get_theme_mod('learn-more-contact-title')) : ?>
                <h2 class="section-title"><?php echo get_theme_mod('learn-more-contact-title'); ?></h2>
            <?php endif; ?>
            <?php if (get_theme_mod('learn-more-contact-description')): ?>
                <p class="section-description"><?php echo get_theme_mod('learn-more-contact-description'); ?></p>
            <?php endif; ?>
            <div class="contact-form">
                <?php dynamic_sidebar( 'sidebar-4' ); ?>
            </div>
        </div>
    </section>

<?php get_footer() ?>