<?php
/**
 * The class that handles the routing logic of Charitable Ambassadors. 
 *
 * @package     Charitable_Ambassadors/Classes/Charitable_Ambassadors_Templates
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Charitable_Ambassadors_Templates' ) ) : 

/**
 * Charitable_Ambassadors_Templates
 *
 * @since       1.0.0
 */
class Charitable_Ambassadors_Templates {
	
	/**
	 * Instantiate the class, but only during the start phase.
	 * 
	 * @param 	Charitable_Ambassadors 		$charitable_ambassadors
	 * @return 	void
	 * @static 
	 * @access 	public
	 * @since 	1.0.0
	 */
	public static function start( Charitable_Ambassadors $charitable_ambassadors ) {
		if ( ! $charitable_ambassadors->is_start() ) {
			return;
		}

		$charitable_ambassadors->register_object( new Charitable_Ambassadors_Templates() );
	}

    /**
     * Create class object.
     * 
     * @access  public
     * @since   1.0.0
     */
    public function __construct() {
     	add_action( 'template_redirect', array( $this, 'maybe_redirect_campaign_submission_template' ), 1 );
    }

    /**
     * Redirect to the login page if we are on the campaign submission page but we're not logged in.  
     *
     * @return  void|false      Void when redirected. False when not redirected.
     * @access  public
     * @since   version
     */
    public function maybe_redirect_campaign_submission_template() {
		/** 
		 * Only redirect if three things are true: 
		 * 1. The user is not logged in.
		 * 2. We require the user to be logged in to submit a campaign.
		 * 3. The user is currently trying to access the campaign submission page.
		 */
        if ( ! is_user_logged_in() 
			&& charitable_get_option( 'require_user_account_for_campaign_submission', 1 ) 
			&& charitable_is_page( 'campaign_submission_page' ) ) {            

			$url = charitable_get_permalink( 'login_page' );
			$url = add_query_arg( array( 'redirect_to' => charitable_get_permalink( 'campaign_submission_page' ) ), $url );
			$url = esc_url_raw( apply_filters( 'charitable_campaign_submission_logged_out_redirect', $url ) );

			wp_safe_redirect( $url );

			exit();
		}

    	return false;
    }
}

endif; // End class_exists check