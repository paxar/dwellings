<?php get_header(); ?>

    <main id="content" class="site-content">
    <div class="container">
        <section class="contact-us">
            <div class="information">
                <div class="contact-info">
                    <h2 class="intro">Contact us</h2>
                    <dl class="contacts">
                        <dt>Contact Person:</dt>
                        <dd><span>Tom Hackett</span></dd>
                        <dt>Email: </dt>
                        <dd><a href="mailto:tom@alternativemissions.com">tom@alternativemissions.com</a></dd>
                        <dt>Phone: </dt>
                        <dd><a href="tel:6235219742"> (623) 521-9742</a></dd>
                    </dl>
                    <dl class="address">
                        <dt>Address: </dt>
                        <dd><address> PO Box 3107 Ferndale, WA 98248</address></dd>
                    </dl>
                </div>
                <div>
                    <img src="<?php echo get_theme_mod('cover-contact-img') ?>" alt="<?php echo get_theme_mod('cover-contact-img') ?>">
                </div>
            </div>
            <div class="contact-form">
                <input type="text">
            </div>
        </section>
    </div>

<?php get_footer();
