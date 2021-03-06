<?php
session_start();
/**
 * Displays the campaign content.
 *
 * Override this template by copying it to yourtheme/charitable/content-campaign.php
 *
 * @author  Studio 164a
 * @package Charitable/Templates/Campaign
 * @since   1.0.0
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

global $current_user;

$campaign = charitable_get_current_campaign();
$percent = number_format($campaign->get_percent_donated_raw(), 0) . '%';
$currency_helper = charitable_get_currency_helper();
$content = $view_args['content'];
$video = $campaign->video;
$video_id = $campaign->video_id;
$creator = $campaign->get_campaign_creator();
$user_id = charitable_get_user($creator);
$value = $campaign->get_percent_donated_raw();
$ended = $campaign->get_time_since_ended();
$time_end = $campaign->get_time_left();
$date_end = $campaign->get_end_date();
$creator  = new Charitable_User( $campaign->get_campaign_creator() );

//print_r($time_end) ;




$_SESSION['sender'] = $campaign;




if ($value > 100) {
    $value = 100;
}

if ($video_id) {
    $video_src = wp_video_shortcode(array('src' => $video));
} else {
    $video_embed_args = apply_filters('charitable_campaign_video_embed_args', array(), $video, $campaign);
    $video_src = wp_oembed_get($video, $video_embed_args);
}
if (empty($video)) {

    $thumbnail_size = apply_filters('charitable_campaign_loop_thumbnail_size', 'large');
    if (has_post_thumbnail($campaign->ID)) :
        $video_src = get_the_post_thumbnail($campaign->ID, $thumbnail_size);
    endif;
}
?>


<div class="project-post-header">
    <h3 class="item-title"><?php the_title() ?> Home, <?php the_date('F Y') ?></h3>
    <div class="post-video col-xs-12 col-sm-6"><?php echo $video_src ?></div>


    <div class="projects-item-donate-info col-xs-12 col-sm-6">
        <div class="creator-info">
            <div class="creator-avatar">
<!--                --><?php //echo get_avatar($creator, 70); ?>

	            <?php echo $creator->get_avatar(); ?>
            </div>
            <div class="creator-description">
                <span>Sponsor: </span>
                <p><?php echo $user_id->description; ?></p>


            </div>
        </div>
        <div class="bar-wrapper">
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     aria-valuenow="<?php echo $value; ?>" aria-valuemin="0"
                     aria-valuemax="100">
                    <span class="pop" data-toggle="tooltip" data-placement="top"
                          title="<?php echo $percent; ?>"> </span>
                </div>
            </div>
            <div class="campaign-timestamp">
                <div class="timestamp-time"> <?php echo $time_end; ?></div>
                <p class="timestamp-date"> End date <span><?php echo $date_end; ?></span> </p>

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
            <div class="project-social-icons">
                <span>Share with:</span>

                <ul><!--TODO add links for social  -->
                    <li><a href="https://twitter.com/share"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.facebook.com/sharer.php?u=<?php the_permalink();?>"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://plus.google.com/share?url=<?php the_permalink();?>"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="http://www.tumblr.com/share/link?url=<?php the_permalink();?>"><i class="fa fa-tumblr "></i></a></li>
                </ul>
            </div>
	        <?php
	        if ( !$ended > 0){?>
            <a data-trigger-modal="charitable-donation-form-modal"
               class="projects-donate-button"
               href="<?php echo charitable_get_permalink('campaign_donation_page', array('campaign_id' => $campaign->ID)) ?>"
               aria-label="<?php printf(esc_attr_x('Make a donation to %s', 'make a donation to campaign', 'charitable'), get_the_title($campaign->ID)) ?>">
                <?php _e('Donate', 'charitable') ?></a>
		        <?php
	        }
	        ?>

        </div>
    </div>


</div>


<div class="project-post-tabs col-xs-12 col-md-8">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#panel1">Description</a></li>
        <li><a data-toggle="tab" href="#panel2">Updates</a></li>
        <li><a data-toggle="tab" href="#panel3">Donors</a></li>
        <li><a data-toggle="tab" href="#panel4">Map</a></li>

    </ul>


    <div class="tab-content">
        <div id="panel1" class="tab-pane fade in active">
            <div>

                <h3 class="description"> <?php echo $campaign->description ?></h3>
                <div class="extended-description"><?php echo $campaign->post_content ?></div>
            </div>
        </div>
        <div id="panel2" class="tab-pane fade">


            <?php dynamic_sidebar('sidebar-tabs-2'); ?>

        </div>
        <div id="panel3" class="tab-pane fade">

            <?php dynamic_sidebar('sidebar-tabs-1'); ?>
        </div>
        <div id="panel4" class="tab-pane fade">
            <?php echo do_shortcode('[campaigns map=1 zoom=4]'); ?>




        </div>

    </div>


</div>

<div class="project-involved-wrap col-xs-12 col-md-4">
    <div class="project-involved ">
        <p class="involved-text"><?php echo get_theme_mod('block1_description'); ?></p>
        <a class="projects-donate-button" href="<?php echo get_permalink(get_theme_mod('block1_btn_url')) ; ?>"><?php echo get_theme_mod('block1_btn_text'); ?></a>

    </div>
</div>
<div class="project-start-wrap col-xs-12 col-md-4">
    <div class="project-start">
        <p class="start-text"><?php echo get_theme_mod('block2_description'); ?></p>
        <a class="projects-donate-button" href="<?php echo get_permalink(get_theme_mod('block2_btn_url')) ; ?>"><?php echo get_theme_mod('block2_btn_text'); ?></a>

    </div>
</div>








