<?php global $settings; ?>
<h2><?php _e( 'Relate Group to Blogs Settings', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></h2>
<form action="" method="post">
	<?php wp_nonce_field( 'bp_relate_groups_to_blogs_settings' ); ?>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row">
					<label for="group-tab-title"><?php _e( 'Group tab title', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
				</th>
				<td>
					<input id="group-tab-title" type="text" value="<?php echo esc_attr( $settings[ 'group-tab-title' ] ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="group-page-title"><?php _e( 'Group page title', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
				</th>
				<td>
					<input id="group-page-title" type="text" value="<?php echo esc_attr( $settings[ 'group-page-title' ] ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="group-page-desc-enabled"><?php _e( 'Group page description enabled', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
				</th>
				<td>
					<input id="group-page-desc-enabled" type="checkbox" <?php if ( $settings[ 'group-page-desc-enabled' ] ) echo 'checked="checked"'; ?> />
				</td>
			</tr>
		</tbody>
	</table>

	<p class="submit clear">
		<input class="button-primary" type="submit" value="<?php echo esc_attr( __( 'Save' ) ); ?>" />
	</p>
</form>
