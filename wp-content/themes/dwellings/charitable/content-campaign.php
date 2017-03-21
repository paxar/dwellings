<?php
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
$creator= $campaign->get_campaign_creator();
$user_id = charitable_get_user($creator);


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
    <p>content-campaign.php</p>

    <div class="project-post-header">
        <h3 class="item-title"><?php the_title() ?> Home, <?php the_date('F Y') ?></h3>
        <div class="post-video col-xs-6"><?php echo $video_src ?></div>


        <div class="projects-item-donate-info col-xs-6">
            <div class="creator-info">
                <div class="creator-avatar">
                    <?php echo get_avatar($creator, 65);?>
                </div>
                <div class="creator-description">
                    <span>Sponsor: </span>
                    <p><?php echo $user_id->description; ?></p>

                </div>
            </div>
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
                <div class="project-social-icons">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                </div>
                <a class="projects-donate-button" href="<?php the_permalink() ?>">Donate</a>
            </div>
        </div>


    </div>


<?php








?>

<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?>





    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#panel1">Description</a></li>
        <li><a data-toggle="tab" href="#panel2">Updates</a></li>
        <li><a data-toggle="tab" href="#panel3">Donors</a></li>
        <li><a data-toggle="tab" href="#panel4">Map</a></li>

    </ul>

    <div class="tab-content">
        <div id="panel1" class="tab-pane fade in active">
            <h3>Description</h3>
            <p>Содержимое Description</p>
        </div>
        <div id="panel2" class="tab-pane fade">
            <h3>Updates</h3>
            <p>Содержимое Updates</p>
        </div>
        <div id="panel3" class="tab-pane fade">
            <h3>Donors</h3>
            <p>Содержимое Donors</p>
        </div>
        <div id="panel4" class="tab-pane fade">
            <h3>Map</h3>
            <p>Содержимое Map</p>
        </div>
    </div>









    <p>****************************************************************************************</p>
<?php
/**
 * @hook charitable_campaign_content_before
 */
do_action('charitable_campaign_content_before', $campaign);

echo $content;

/**
 * @hook charitable_campaign_content_after
 */
do_action('charitable_campaign_content_after', $campaign);