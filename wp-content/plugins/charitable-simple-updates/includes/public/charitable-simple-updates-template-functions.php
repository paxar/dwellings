<?php 

/**
 * Charitable Simple Updates Template Functions. 
 *
 * @author      Studio164a
 * @package     Charitable Simple Updates/Functions/Template
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Displays a template. 
 *
 * @param   string|array $template_name A single template name or an ordered array of template
 * @param   arary $args                 Optional array of arguments to pass to the view.
 * @return  Charitable_Simple_Updates_Template
 * @since   1.0.0
 */
function charitable_simple_updates_template( $template_name, array $args = array() ) {
    if ( empty( $args ) ) {
        $template = new Charitable_Simple_Updates_Template( $template_name ); 
    }
    else {
        $template = new Charitable_Simple_Updates_Template( $template_name, false ); 
        $template->set_view_args( $args );
        $template->render();
    }

    return $template;
}

if ( ! function_exists( 'charitable_simple_updates_template_campaign_updates' ) ) : 
    /**
     * Display a campaign's updates. 
     *
     * @param   Charitable_Campaign $campaign
     * @return  void
     * @since   1.0.0
     */
    function charitable_simple_updates_template_campaign_updates( $campaign = "" ) {
        if ( empty( $campaign ) ) {
            $campaign = charitable_get_current_campaign();
        }

        if ( ! is_a( $campaign, 'Charitable_Campaign' ) ) {
            $campaign = new Charitable_Campaign( $campaign );
        }

        if ( ! $campaign ) {
            return;
        }
        
        charitable_simple_updates_template( 'campaign-updates.php', array( 'campaign' => $campaign ) );
    }
endif;