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

                        <h2 class="intro"><?php echo wp_get_document_title(); ?></h2>

                    <dl class="contacts">
                        <dt>Contact Person:</dt>

                        <?php if (get_theme_mod('contact_person') != ''): ?>
                            <dd><span><?php echo get_theme_mod('contact_person'); ?></span></dd>
                        <?php endif; ?>

                        <dt>Email: </dt>

                        <?php if (get_theme_mod('contact_email') != ''): ?>
                        <dd><a href="mailto:<?php echo get_theme_mod('contact_email'); ?>"><?php echo get_theme_mod('contact_email'); ?></a></dd>
                        <?php endif; ?>

                        <dt>Phone: </dt>

                         <?php if (get_theme_mod('contact_phone') != ''): ?>
                            <dd><a href="tel:<?php echo get_theme_mod('contact_phone'); ?>"><?php echo get_theme_mod('contact_phone'); ?></a></dd>
                         <?php endif; ?>

                    </dl>
                    <dl class="address">
                        <dt>Address: </dt>

                        <?php if (get_theme_mod('contact_address') != ''): ?>
                            <dd><address><?php echo get_theme_mod('contact_address'); ?></address></dd>
                        <?php endif; ?>

                    </dl>
                </div>
                <div class="cover-contact">

                    <?php if (get_theme_mod('cover-contact-img') != ''): ?>
                        <img src="<?php echo get_theme_mod('cover-contact-img') ?>" alt="<?php echo get_theme_mod('cover-contact-img') ?>">
                    <?php endif; ?>

                </div>
            </div>
            <div class="contact-form">

                <?php if (is_active_sidebar('sidebar-3')): ?>
                    <?php dynamic_sidebar('sidebar-3'); ?>
                <?php endif; ?>

            </div>
        </div>
    </section>

<?php get_footer();
