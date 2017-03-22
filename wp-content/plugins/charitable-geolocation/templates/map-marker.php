<?php 
/**
 * HTML output for a single campaign map marker.
 *
 * @author  Studio 164a
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

?>
<div class="charitable-campaign-map-marker">
    <img src="{thumbnail}" alt="{title}" />
    <h3><a href="{link}">{title}</a></h3>
    <div class="campaign-description">{description}</div>
</div>