<?php global $settings; ?>
<div class="wrap">
	<h2><?php _e( 'Relate Groups to Blogs Settings', 'bp-relate-groups-to-blogs' ); ?></h2>
	<form action="" method="post">
		<?php wp_nonce_field( 'bp_relate_groups_to_blogs_settings' ); ?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="group-header-enabled"><?php _e( 'Show related blogs in group header', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-header-enabled" name="group-header-enabled" type="checkbox" <?php if ( $settings[ 'group-header-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="group-header-title"><?php _e( 'Group page header title', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-header-title" name="group-header-title" type="text" value="<?php echo esc_attr( $settings[ 'group-header-title' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-tab-enabled"><?php _e( 'Show related blogs in group tab', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-tab-enabled" name="group-tab-enabled" type="checkbox" <?php if ( $settings[ 'group-tab-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="group-tab-title"><?php _e( 'Group page tab title', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-tab-title" name="group-tab-title" type="text" value="<?php echo esc_attr( $settings[ 'group-tab-title' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-title"><?php _e( 'Group page title', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-page-title" name="group-page-title" type="text" value="<?php echo esc_attr( $settings[ 'group-page-title' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-desc"><?php _e( 'Group page description', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<textarea id="group-page-desc" name="group-page-desc"><?php echo $settings[ 'group-page-desc' ]; ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-desc-enabled"><?php _e( 'Allow groups to add their own description', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-page-desc-enabled" name="group-page-desc-enabled" type="checkbox" <?php if ( $settings[ 'group-page-desc-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-edit-searchfield"><?php _e( 'Group edit page searchfield label', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-edit-searchfield" name="group-edit-searchfield" type="text" value="<?php echo esc_attr( $settings[ 'group-edit-searchfield' ] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-edit-desc"><?php _e( 'Group edit page description', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<textarea id="group-edit-desc" name="group-edit-desc"><?php echo $settings[ 'group-edit-desc' ]; ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-page-slogan-enabled"><?php _e( 'Show blog slogan in blog list on group page', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-page-slogan-enabled" name="group-page-slogan-enabled" type="checkbox" <?php if ( $settings[ 'group-page-slogan-enabled' ] ) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="group-widget-title"><?php _e( 'Blog widget default title', 'bp-relate-groups-to-blogs' ); ?></label>
					</th>
					<td>
						<input id="group-widget-title" name="group-widget-title" type="text" value="<?php echo esc_attr( $settings[ 'group-widget-title' ] ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit clear">
			<input class="button-primary" name="group-save" type="submit" value="<?php echo esc_attr( __( 'Save' ) ); ?>" />
		</p>
	</form>
</div>
