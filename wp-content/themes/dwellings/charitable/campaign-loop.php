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

$campaigns = $view_args['campaigns'];
//$columns   = $view_args['columns'];
$args = charitable_campaign_loop_args($view_args);
$currency_helper = charitable_get_currency_helper();


if (!$campaigns->have_posts()) :
    return;
endif;


/**
 * @hook charitable_campaign_loop_before
 */
do_action('charitable_campaign_loop_before', $campaigns, $args);

?>
<div class="projects-wrap">

    <?php
    while ($campaigns->have_posts()) :

    $campaigns->the_post();
    // variables for display custom fields
    $campaign = charitable_get_current_campaign();
    $percent = number_format($campaign->get_percent_donated_raw(), 0) . '%';

    ?>
    <div class="projects-item">
        <?php
        // image
        $thumbnail_size = apply_filters('charitable_campaign_loop_thumbnail_size', 'medium');

        if (has_post_thumbnail($campaign->ID)) :

            echo get_the_post_thumbnail($campaign->ID, $thumbnail_size);

        endif;
        // end image
        ?>
        <h3><?php the_title() ?></h3>


        <div class="campaign-description">
            <?php echo $campaign->description ?>
        </div>

        <a class="campaign-read-more" href="<?php the_permalink() ?>">Read more -></a>




        <!-- ***********************progress bar new-->
        <div class="barWrapper">

            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     aria-valuenow="<?php echo $campaign->get_percent_donated_raw(); ?>" aria-valuemin="0"
                     aria-valuemax="100">
                    <span class="popOver" data-toggle="tooltip" data-placement="top"
                          title="<?php echo $percent; ?>"> </span>
                </div>
            </div>
            <!-- ************************************-->



            <span class="amount"><?php echo $currency_helper->get_monetary_amount($campaign->get_donated_amount())?></span>
            <span class="goal-amount"> <?php echo $currency_helper->get_monetary_amount($campaign->get('goal'))?></span>




            <a class="campaign-donate-button" href="<?php the_permalink() ?>">Read more -></a>

        </div> <!--  projects-item      -->

        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div><!--projects-wrap-->


