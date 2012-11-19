<?php global $bp_relate_groups_to_blogs; ?>
<h2><?php echo $bp_relate_groups_to_blogs->settings[ 'group-page-title' ]; ?></h2>

<?php echo $bp_relate_groups_to_blogs->get_display_content(); ?>

<ul id="group-blogs">
	<?php foreach( $bp_relate_groups_to_blogs->get_blogs() as $blog ) : ?>
		<li id="group-blog-<?php echo esc_attr( $blog[ 'blog_id' ] ); ?>">
			<a
				href="<?php echo esc_attr( $blog[ 'siteurl' ] ); ?>"
				title="<?php echo esc_attr( $blog[ 'blogname' ] ); ?>"
			><?php echo esc_attr( $blog[ 'blogname' ] ); ?></a>
			<?php if( $bp_relate_groups_to_blogs->settings[ 'group-page-slogan-enable' ] ) :?>
				— <em><?php echo esc_attr( $blog[ 'blogdescription' ] ); ?></em>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

