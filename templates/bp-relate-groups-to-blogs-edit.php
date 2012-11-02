<?php global $bp_relate_groups_to_blogs; ?>
<h2><?php echo esc_attr( __( $bp_relate_groups_to_blogs->name, 'bp-relate-groups-to-blogs' ) ); ?></h2>

<p><?php _e( 'Related blogs will appear in a group-widget in selected blogs. And blogs will appear here on the group page.', 'bp-relate-groups-to-blogs' ); ?></p>

<label for="group-blog-display-content"><?php _e( 'Group bloglist description', 'bp-relate-groups-to-blogs' ); ?></label>
<textarea id="group-blog-display-content" name="group-blog-display-content"><?php echo $bp_relate_groups_to_blogs->get_display_content( null, true ); ?></textarea>

<label for="group-blog-search"><?php _e( 'Find blogs by name', 'bp-relate-groups-to-blogs' ); ?></label>
<input id="group-blog-search" type="text" name="group-blog-search" />

<ul id="group-blog-result">
	<li class="group-blog-template">
		<input id="group-blog-id-%blog_id" name="group-blog-blogs[]" type="checkbox" value="%blog_id" />
		<label for="group-blog-id-%blog_id">%blogname — <em>%blogdescription</em></label>
		— <a href="%siteurl" title="%blogname"><?php _e( 'View blog', 'bp-relate-groups-to-blogs' ); ?></a>
	</li>
	<?php foreach( $bp_relate_groups_to_blogs->get_blogs() as $blog ) : ?>
		<li id="group-blog-<?php echo esc_attr( $blog[ 'blog_id' ] ); ?>">
			<input
				id="group-blog-id-<?php echo esc_attr( $blog[ 'blog_id' ] ); ?>"
				name="group-blog-blogs[]"
				type="checkbox"
				value="<?php echo esc_attr( $blog[ 'blog_id' ] ); ?>"
				checked="checked"
			/>
			<label for="group-blog-id-<?php echo esc_attr( $blog[ 'blog_id' ] ); ?>">
				<?php echo esc_attr( $blog[ 'blogname' ] ); ?>
				— <em><?php echo esc_attr( $blog[ 'blogdescription' ] ); ?></em>
			</label>
			— <a
				href="<?php echo esc_attr( $blog[ 'siteurl' ] ); ?>"
				title="<?php echo esc_attr( $blog[ 'blogname' ] ); ?>"
			><?php _e( 'View blog', 'bp-relate-groups-to-blogs' ); ?></a>
		</li>
	<?php endforeach; ?>
</ul>
