<?php global $settings; ?>
<div class="wrap">
	<h2><?php _e( 'Relate Groups to Blogs Settings', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></h2>
	<form action="" method="post">
		<?php wp_nonce_field( 'bp_relate_groups_to_blogs_settings' ); ?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="group-header-enabled"><?php _e( 'Show related blogs in group header', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<input id="group-header-enabled" name="group-header-enabled" type="checkbox" <?php if ( $settings[ 'group-header-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="group-header-title"><?php _e( 'Group page header title', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<input id="group-header-title" name="group-header-title" type="text" value="<?php echo esc_attr( $settings[ 'group-header-title' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-tab-enabled"><?php _e( 'Show related blogs in group tab', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<input id="group-tab-enabled" name="group-tab-enabled" type="checkbox" <?php if ( $settings[ 'group-tab-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="group-tab-title"><?php _e( 'Group page tab title', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<input id="group-tab-title" name="group-tab-title" type="text" value="<?php echo esc_attr( $settings[ 'group-tab-title' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-title"><?php _e( 'Group-blog relation page title', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<input id="group-page-title" name="group-page-title" type="text" value="<?php echo esc_attr( $settings[ 'group-page-title' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-desc"><?php _e( 'Group-blog relation page description', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<textarea id="group-page-desc" name="group-page-desc"><?php echo $settings[ 'group-page-desc' ]; ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-desc-enabled"><?php _e( 'Allow groups to add their own description', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ); ?></label>
					</th>
					<td>
						<input id="group-page-desc-enabled" name="group-page-desc-enabled" type="checkbox" <?php if ( $settings[ 'group-page-desc-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit clear">
			<input class="button-primary" name="group-save" type="submit" value="<?php echo esc_attr( __( 'Save' ) ); ?>" />
		</p>
	</form>
</div>
