<?php get_header() ?>
<main id="content" class="site-content">
<section class=""></section>

<?php get_template_part( 'template-parts/icongroup', 'none' ); ?>

<section class="learn-more-contact">
    <div class="container">
        <h2 class="section-title "><?php echo get_theme_mod('learn-more-contact-title'); ?></h2>
        <div class="contact-form">
            <?php dynamic_sidebar( 'sidebar-3' ); ?>
        </div>
    </div>
</section>

<?php get_footer() ?>