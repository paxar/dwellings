<?php
/**
 * Displays the campaign loop.
 *
 * Override this template by copying it to yourtheme/charitable/campaign-loop.php
 *
 * @author  Studio 164a
 * @package Charitable/Templates/Campaign
 * @since   1.0.0
 * @version 1.2.3
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


// set up or arguments for our custom query

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    "post_type" => 'campaign',      // custom post type
    'posts_per_page' => 1,         // 7 posts in mockup
    'paged' => $paged
);
$wp_query = new WP_Query($args);


if ($wp_query->have_posts()) :
?>

<div class="projects-wrap">

    <?php
    while ($wp_query->have_posts()) :
        $wp_query->the_post();

        /*     variables for display custom fields   */
        $campaign = charitable_get_current_campaign();
        $percent = number_format($campaign->get_percent_donated_raw(), 0) . '%';
        $currency_helper = charitable_get_currency_helper();

        ?>
        <div class="projects-item col-xs-12">
            <div class="projects-item-image-wrap col-xs-12 col-sm-6 col-md-3">
                <?php
                // image
                $thumbnail_size = apply_filters('charitable_campaign_loop_thumbnail_size', 'large');
                if (has_post_thumbnail($campaign->ID)) :
                    echo get_the_post_thumbnail($campaign->ID, $thumbnail_size);
                endif;
                // end image
                ?>
            </div>
            <div class="projects-item-description col-xs-12 col-sm-6 col-md-4">
                <h3 class="item-title"><?php the_title() ?> Family</h3>

                <div class="item-info">
                    <?php echo $campaign->description ?>
                </div>

                <a class="item-read-more" href="<?php the_permalink() ?>">Read more</a>
            </div>

            <div class="projects-item-donate-info col-xs-12 col-sm-12 col-md-5">
                <div class="bar-wrapper">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             aria-valuenow="<?php echo $campaign->get_percent_donated_raw(); ?>" aria-valuemin="0"
                             aria-valuemax="100">
                    <span class="pop" data-toggle="tooltip" data-placement="top"
                          title="<?php echo $percent; ?>"> </span>
                        </div>
                    </div>
                    <div class="donate-info-wrap">
                        <div class="amount">
                            <span class="donate-text">Amount raised:</span>
                            <span class="amount-count"><?php echo $currency_helper->get_monetary_amount($campaign->get_donated_amount()) ?></span>
                        </div>
                        <div class="goal">
                            <span class="donate-text">Goal</span>
                            <span class="goalcount"> <?php echo $currency_helper->get_monetary_amount($campaign->get('goal')) ?></span>
                        </div>
                    </div>
                    <a class="projects-donate-button" href="<?php the_permalink() ?>">Donate</a>
                </div>
            </div>
        </div><!--  projects-item      -->
        <?php
    endwhile;
    else:
        get_template_part('template-parts/content', 'none');
    endif;
    wp_reset_postdata();
    ?>

</div><!--projects-wrap-->

<?php /*Pagination*/
if (function_exists("custom_numeric_posts_nav")) {
    custom_numeric_posts_nav($wp_query);
} ?>