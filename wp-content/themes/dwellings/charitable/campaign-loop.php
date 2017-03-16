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

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

$campaigns = $view_args['campaigns'];
//$columns   = $view_args['columns'];
$args      = charitable_campaign_loop_args( $view_args );



if ( ! $campaigns->have_posts() ) :
	return;
endif;

/*if ( $columns > 1 ) :
	$loop_class = sprintf( 'campaign-loop campaign-grid campaign-grid-%d', $columns );
else :
	$loop_class = 'campaign-loop campaign-list';
endif;*/
$loop_class = 'row';


/**
 * @hook charitable_campaign_loop_before
 */
do_action( 'charitable_campaign_loop_before', $campaigns, $args );

?>
<div class="<?php echo $loop_class ?>">

<?php
while ( $campaigns->have_posts() ) :

	$campaigns->the_post();
// variables for display custom fields
    $campaign = charitable_get_current_campaign();
// image
    $thumbnail_size = apply_filters( 'charitable_campaign_loop_thumbnail_size', 'medium' );

    if ( has_post_thumbnail( $campaign->ID ) ) :

        echo get_the_post_thumbnail( $campaign->ID, $thumbnail_size );

    endif;
// end image
?>
    <h3><?php the_title() ?></h3>


    <div class="campaign-description">
        <?php echo $campaign->description ?>
    </div>

    <a href="<?php the_permalink() ?>">Read more -></a>


    <?php
    //progress bar
    if ( ! $campaign->has_goal() ) :
    return;
    endif;

    ?>
    <div class="campaign-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo $campaign->get_percent_donated_raw(); ?>"><span class="bar" style="width: <?php echo $campaign->get_percent_donated_raw() ?>%;"></span></div>

    <div class="campaign-donation-stats">
        <?php echo $campaign->get_donation_summary() ?>
    </div>


<p><?php echo $campaign->get_donated_amount() ?></p>
    <p><?php echo $campaign->get('amount') ?></p>

    <p><?php echo $campaign->get_goal() ?></p>







    <?php
	//charitable_template( 'campaign-loop/campaign.php', $args );



endwhile;

wp_reset_postdata();
?>
</div>

