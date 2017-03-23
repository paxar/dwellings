<?php
/**
 * About us section
 * use in homepage and about us pages
 */
?>

<section class="about-us">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="about-content">

                    <h2 class="title title-decor"><h2 class="intro"><?php echo wp_get_document_title(); ?></h2></h2>

                    <div class="about-content">
                        <p><?php echo get_theme_mod('description_abut_us') ?></p>
                    </div>
                </div>
            </div>
            <div class="about-wrap-img">
                <?php if (get_theme_mod('about-cover-image') != ''): ?>
                <img src="<?php echo get_theme_mod('about-cover-image') ?>" alt="<?php echo get_theme_mod('about-cover-image') ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
