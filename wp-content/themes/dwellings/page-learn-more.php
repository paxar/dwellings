<?php get_header() ?>
<main id="content" class="site-content">
    <section class="map-learn-more"></section>
    <?php get_template_part( 'template-parts/icongroup', 'none' ); ?>
    <div class="container">
        <section class="right-image-section">
            <div>
                <h2 class="learn-section-title"><?php echo get_theme_mod('right-image-section-title'); ?></h2>
                <p class="learn-paragraph"><?php echo get_theme_mod('right-image-section-paragraph1'); ?></p>
                <p class="learn-paragraph"><?php echo get_theme_mod('right-image-section-paragraph2'); ?></p>
            </div>
            <div class="learn-image-box">
                <img src="" alt="">
            </div>
        </section>
    </div>

    <section class="learn-more-contact">
        <div class="container">
            <h2 class="section-title"><?php echo get_theme_mod('learn-more-contact-title'); ?></h2>
            <p class="section-description"><?php echo get_theme_mod('learn-more-contact-description'); ?></p>
            <div class="contact-form">
                <?php dynamic_sidebar( 'sidebar-3' ); ?>
            </div>
        </div>
    </section>

<?php get_footer() ?>