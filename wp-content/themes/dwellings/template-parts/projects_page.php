<?php
/*
Template Name: Projects_page

Description:  Projects_page
*/
?>

<?php get_header() ?>

<section class="projects">
    <div class="container">

        <h2 class="title">bla bla bla</h2>
        <p class="subtitle">bla bla bla</p>



        <?php

        $args = array(
            'post_type' => 'campaign'
        );

        $query = new WP_Query( $args );

        if ($query -> have_posts()) :

            while ($query -> have_posts()) : $query -> the_post();
                ?>


                <div class="project-post">
                    <div class="img-wrap">

                        <a href="<?php the_permalink(); ?>">

                            <?php if (has_post_thumbnail()) : ?>

                                <?php the_post_thumbnail('medium', ['class' => 'projects-gallery-img ']); ?>

                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="description">

                        <h3> <?php the_title(); ?> </h3>

                        <div><?php the_content(); ?></div>

                       <div class="post-meta"> <?php echo get_post_meta( $post->ID, 'description', true ); ?> </div>

                        <div class="post-meta2"> <?php the_meta(); ?> </div>


                        <div class="campaign-description">

                        </div>


                        <a class="description-link" href="<?php the_permalink(); ?>"> read more</a>

                    </div>



                    <div class="project-info">



                    </div>

                </div>

                <?php
            endwhile;
            wp_reset_postdata();

        else :
            echo '<p> No content </p>';

        endif;
        ?>




    </div>
</section>





<?php get_footer() ?>




