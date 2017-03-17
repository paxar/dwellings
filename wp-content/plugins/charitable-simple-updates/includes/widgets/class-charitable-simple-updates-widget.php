<?php
/**
 * Campaign updates widget class.
 *
 * @version     1.0.0
 * @package     Charitable Simple Updates/Widgets/Donors Widget
 * @category    Class
 * @author      Eric Daams
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
if ( ! class_exists( 'Charitable_Simple_Updates_Widget' ) ) :

	/**
	 * Charitable_Simple_Updates_Widget class.
	 *
	 * @since       1.0.0
	 */
	class Charitable_Simple_Updates_Widget extends WP_Widget {

		/**
		 * Instantiate the widget and set up basic configuration.
		 *
		 * @access  public
		 * @since   1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'charitable_simple_updates_widget',
				__( 'Campaign Updates', 'charitable-simple-updates' ),
				array( 'description' => __( 'Display a campaign`s updates.', 'charitable-simple-updates' ) )
			);
		}

		/**
		 * Display the widget contents on the front-end.
		 *
		 * @param   array   $args
		 * @param   array   $instance
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function widget( $args, $instance ) {
			$campaign = $this->get_campaign( $instance );

			$hide_if_empty = isset( $instance['hide_if_empty'] ) && $instance['hide_if_empty'];

			if ( $hide_if_empty && ( ! $campaign || ! strlen( $campaign->updates ) ) ) {
				return;
			}

			$view_args = array_merge( $args, $instance );
			$view_args['campaign'] = $campaign;

			charitable_simple_updates_template( 'campaign-updates-widget.php', $view_args );
		}

		/**
		 * Display the widget form in the admin.
		 *
		 * @param   array $instance     The current settings for the widget options.
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function form( $instance ) {
			$defaults = array(
				'title' => '',
				'campaign_id' => 'current',
				'hide_if_empty' => true,
			);

			$args = wp_parse_args( $instance, $defaults );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"><?php _e( 'Title', 'charitable-simple-updates' ) ?>:</label>
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>" value="<?php echo esc_attr( $args['title'] ) ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'campaign_id' ) ) ?>"><?php _e( 'Show updates by campaign', 'charitable-simple-updates' ) ?>:</label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'campaign_id' ) ) ?>">
					<option value="current" <?php selected( 'current', $args['campaign_id'] ) ?>><?php _e( 'Campaign currently viewed', 'charitable-simple-updates' ) ?></option>
					<optgroup label="<?php _e( 'Specific campaign', 'charitable-simple-updates' ) ?>">
						<?php foreach ( Charitable_Campaigns::query()->posts as $campaign ) : ?>
							<option value="<?php echo intval( $campaign->ID ) ?>" <?php selected( $campaign->ID, $args['campaign_id'] ) ?>><?php echo $campaign->post_title ?></option>
						<?php endforeach ?>
					</optgroup>
				</select>                
			</p>
			<p>            
				<input id="<?php echo esc_attr( $this->get_field_id( 'hide_if_empty' ) ) ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'hide_if_empty' ) ); ?>" <?php checked( $args['hide_if_empty'] ) ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'hide_if_empty' ) ) ?>"><?php _e( 'Hide if there are no updates', 'charitable-simple-updates' ) ?></label>
			</p>
			<?php
		}

		/**
		 * Update the widget settings in the admin.
		 *
		 * @param   array $new_instance     The updated settings.
		 * @param   array $new_instance     The old settings.
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = isset( $new_instance['title'] ) ? $new_instance['title'] : $old_instance['title'];
			$instance['campaign_id'] = isset( $new_instance['campaign_id'] ) ? $new_instance['campaign_id'] : $old_instance['campaign_id'];
			$instance['hide_if_empty'] = isset( $new_instance['hide_if_empty'] ) && $new_instance['hide_if_empty'];
			return $instance;
		}

		/**
		 * Get campaign to display in widget.
		 *
		 * @return  Charitable_Campaign|false
		 * @access  private
		 * @since   1.0.0
		 */
		private function get_campaign( $instance ) {
			$campaign_id = isset( $instance['campaign_id'] ) ? $instance['campaign_id'] : $instance['campaign'];

			if ( in_array( $campaign_id, array( 'current', 'current-campaign' ) ) ) {

				if ( ! charitable_is_campaign_page() ) {
					return false;
				}

				return charitable_get_current_campaign();
			}

			return new Charitable_Campaign( $campaign_id );
		}
	}

endif; // End class_exists check
