<?php
/*
Template Name: Template contact us page
*/
?>
<?php get_header(); ?>

    <main id="content" class="site-content">
    <section class="contact-us">
        <div class="container">
            <div class="information">
                <div class="contact-info">
                    <h2 class="intro"><?php echo get_theme_mod('contact_title'); ?></h2>
                    <dl class="contacts">
                        <dt>Contact Person:</dt>
                        <dd><span><?php echo get_theme_mod('contact_person'); ?></span></dd>
                        <dt>Email: </dt>
                        <dd><a href="mailto:<?php echo get_theme_mod('contact_email'); ?>"><?php echo get_theme_mod('contact_email'); ?></a></dd>
                        <dt>Phone: </dt>
                        <dd><a href="tel:<?php echo get_theme_mod('contact_phone'); ?>"><?php echo get_theme_mod('contact_phone'); ?></a></dd>
                    </dl>
                    <dl class="address">
                        <dt>Address: </dt>
                        <dd><address><?php echo get_theme_mod('contact_address'); ?></address></dd>
                    </dl>
                </div>
                <div class="cover-contact">
                    <img src="<?php echo get_theme_mod('cover-contact-img') ?>" alt="<?php echo get_theme_mod('cover-contact-img') ?>">
                </div>
            </div>
            <div class="contact-form">
                <?php dynamic_sidebar( 'sidebar-3' ); ?>
            </div>
        </div>
    </section>

<?php get_footer();
