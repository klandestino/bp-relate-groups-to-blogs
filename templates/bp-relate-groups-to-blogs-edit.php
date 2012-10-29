<?php global $bp_relate_groups_to_blogs; ?>
<h2><?php echo esc_attr( __( $bp_relate_groups_to_blogs->name, 'bp-relate-groups-to-blogs' ) ); ?></h2>

<p><?php _e( 'Some text...', 'bp-relate-groups-to-blogs' ); ?></p>

<label for="group-blog-search"><?php _e( 'Find blogs by name', 'bp-relate-groups-to-blogs' ); ?></label>
<input id="group-blog-search" type="text" name="group-blog-search" />

<ul id="group-blog-result">
	<?php foreach( $bp_relate_groups_to_blogs->get_blogs() as $blog ) : ?>
		<li><input id="group-blog-id-<?php echo esc_attr( $blog->id ); ?>" name="group-blog-blogs" value="<?php echo esc_attr( $blog->id ); ?>" checked="checked" /> <?php $blog->name; ?></li>
	<?php endforeach; ?>
</ul>

