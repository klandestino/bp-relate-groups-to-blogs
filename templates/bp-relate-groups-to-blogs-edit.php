<?php global $bp_relate_groups_to_blogs; ?>
<h2><?php echo $bp_relate_groups_to_blogs->settings[ 'group-page-title' ]; ?></h2>

<?php echo $bp_relate_groups_to_blogs->get_edit_content(); ?>

<?php if( $bp_relate_groups_to_blogs->settings[ 'group-page-desc-enabled' ] ): ?>
	<label for="group-blog-display-content"><?php _e( 'Group bloglist description', 'bp-relate-groups-to-blogs' ); ?></label>
	<textarea id="group-blog-display-content" name="group-blog-display-content"><?php echo $bp_relate_groups_to_blogs->get_display_content( null, true ); ?></textarea>
<?php endif; ?>

<label for="group-blog-search"><?php echo esc_attr( $bp_relate_groups_to_blogs->settings[ 'group-edit-searchfield' ] ); ?></label>
<input id="group-blog-search" type="text" name="group-blog-search" autocomplete="off" />

<ul id="group-blog-result">
	<li class="group-blog-template">
		<input id="group-blog-id-%blog_id" name="group-blog-blogs[]" type="checkbox" value="%blog_id" />
		<label for="group-blog-id-%blog_id">
			%blogname
			<?php if( $bp_relate_groups_to_blogs->settings[ 'group-page-slogan-enable' ] ) :?>
				— <em>%blogdescription</em>
			<?php endif; ?>
			</label>
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
				<?php if( $bp_relate_groups_to_blogs->settings[ 'group-page-slogan-enable' ] ) :?>
					— <em><?php echo esc_attr( $blog[ 'blogdescription' ] ); ?></em>
				<?php endif; ?>
			</label>
			— <a
				href="<?php echo esc_attr( $blog[ 'siteurl' ] ); ?>"
				title="<?php echo esc_attr( $blog[ 'blogname' ] ); ?>"
			><?php _e( 'View blog', 'bp-relate-groups-to-blogs' ); ?></a>
		</li>
	<?php endforeach; ?>
</ul>
