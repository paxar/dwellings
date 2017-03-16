<?php
/**
 * Icons section
 * use in homepage and learn more  pages

 */
?>

<section class="icongroup">



    <h2 class="title">bla bla bla</h2>




    <?php

    $args = array(
        'post_type' => 'icons-section'
    );

    $query = new WP_Query( $args );

    if ($query -> have_posts()) :

        while ($query -> have_posts()) : $query -> the_post();
            ?>


            <div class="project-post">
                <div class="img-wrap">



                        <?php if (has_post_thumbnail()) : ?>

                            <?php the_post_thumbnail('medium', ['class' => 'projects-gallery-img ']); ?>

                        <?php endif; ?>

                </div>

                <div class="description">

                    <h3> <?php the_title(); ?> </h3>

                    <div><?php the_content(); ?></div>






                </div>





            </div>

            <?php
        endwhile;
        wp_reset_postdata();

    else :
        echo '<p> No content </p>';

    endif;
    ?>
</section>