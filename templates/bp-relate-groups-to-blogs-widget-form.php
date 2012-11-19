<?php global $title, $title_id, $title_name, $groups; ?>
<p>
	<label for="<?php echo $title_id; ?>"><?php _e( 'Title:' ); ?></label>
	<input class="widefat" id="<?php echo $title_id ?>" name="<?php echo $title_name ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<h4><?php _e( 'Groups', 'bp-relate-groups-to-blogs' ); ?></h4>

<p><?php _e( 'Add or remove a blog-group relationship on the group administration pages', 'bp-relate-groups-to-blogs' ); ?></p>

<ul>
	<?php foreach( $groups as $group ): ?>
		<li><a href="<?php echo esc_url( bp_get_group_permalink( $group ) ); ?>"><?php echo $group->name; ?></a></li>
	<?php endforeach; ?>
</ul>
