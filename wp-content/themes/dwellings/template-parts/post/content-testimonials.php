<?php
/**
 * Testimonials section
 * use in homepage and about us pages
 */
?>

    <li class="col-xs-12 col-md-6 single-quote">
        <div class="row">
            <div class="col-xs-2">
                <div class="avatar-quote">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                    }
                    ?>
                </div>
            </div>
            <div class="col-xs-10">
                <div class="content-quote">
                    <?php the_content(); ?>
                    <div class="author-quote">
                        <span class="name-author">
                            <?= get_post_meta($post->ID, 'author_quote', true) ?>
                        </span>
                        <span class="name-organization">
                             - <?= get_post_meta($post->ID, 'name_organization', true) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </li>
