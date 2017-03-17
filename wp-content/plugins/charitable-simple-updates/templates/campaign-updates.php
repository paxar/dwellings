<?php 
/**
 * Displays the campaign updates.
 *
 * Override this template by copying it to yourtheme/charitable-simple-updates/campaign-updates.php
 *
 * @author  Studio 164a
 * @package Charitable/Templates/Donation Receipt
 * @since   1.0.0
 * @version 1.0.0
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

?>
<div class="campaign-updates">
    <?php echo wpautop( $updates ) ?>
</div>