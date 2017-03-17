<?php 
/**
 * Displays the campaign updates in a widget.
 *
 * @author  Studio 164a
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$campaign = $view_args[ 'campaign' ];

if ( ! $campaign ) :
    return;
endif;

$updates = $campaign->updates;

if ( empty( $updates ) ) : 
    return;
endif;

$widget_title = apply_filters( 'widget_title', $view_args[ 'title' ] );

echo $view_args['before_widget'];

if ( ! empty( $widget_title ) ) :
    echo $view_args['before_title'] . $widget_title . $view_args['after_title'];
endif;

charitable_simple_updates_template_campaign_updates( $campaign );

echo $view_args['after_widget'];