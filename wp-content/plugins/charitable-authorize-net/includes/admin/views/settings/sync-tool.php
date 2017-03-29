<?php
/**
 * Display the Authorize.Net required fields sync tool.
 *
 * @author  Studio 164a
 * @package Charitable Authorize.Net/Admin Views/Settings
 * @since   1.1.0
 */

$submit_url = add_query_arg( array(
	'charitable_action' => 'sync_authorize_net_fields',
), admin_url( 'admin.php' ) );

?>
<div id="charitable-authorize-net-sync">
	<form method="post" action="<?php echo esc_url( $submit_url ) ?>">		     
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php _e( 'Sync Settings with Authorize.Net Account', 'charitable-authorize-net' ) ?></th>
					<td><hr /></td>
				</tr>
				<tr>
					<td colspan="2" style="padding: 0 0 15px 0;">
						<p><?php _e( "You can choose which form fields are required for payments in your Authorize.Net account under Account > Payment Form > Form Fields. If you have used this option, the Sync tool will  your Charitable donation form with your Authorize.Net settings.", 'charitable-authorize-net' ) ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button" value="<?php esc_attr_e( 'Sync Settings', 'charitable-authorize-net' ) ?>"></p>
	</form>
</div>
