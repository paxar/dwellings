<?php
/**
 * Icons section
 * use in homepage and learn more  pages
 */
?>

<section class="icongroup main-icongroup">
    <div class="container">
        <div class="row">


        <h2 class="title title-decor">What’s the process?</h2>



        <?php

        $args = array(
            'post_type' => 'icons-section',
            'order' => 'ASC',
            'posts_per_page' => 3

        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :

            while ($query->have_posts()) : $query->the_post();
                ?>


                <div class="icongroup-post col-xs-12 col-md-4">
                    <div class="img-wrap">


                        <?php if (has_post_thumbnail()) : ?>

                            <?php the_post_thumbnail('medium', ['class' => 'projects-gallery-img ']); ?>

                        <?php endif; ?>

                    </div>

                    <div class="description">

                        <h3> <?php the_title(); ?> </h3>

                        <p><?php the_content(); ?></p>


                    </div>


                </div>

                <?php
            endwhile;
            wp_reset_postdata();

        else :
            echo '<p> No content </p>';

        endif;
        ?>
        </div> <!--  row   -->
    </div> <!--  container   -->

</section>