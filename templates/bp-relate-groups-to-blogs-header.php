<?php

global $bp_relate_groups_to_blogs;
$blogs = $bp_relate_groups_to_blogs->get_blogs();

if( count( $blogs ) ): ?>
	<p>
		<strong><?php echo $bp_relate_groups_to_blogs->settings[ 'group-header-title' ]; ?>:</strong>
		<?php $blog = reset( $blogs ); do { ?>
			<span id="group-blog-<?php echo esc_attr( $blog[ 'blog_id' ] ); ?>" class="group-blog">
				<a
					href="<?php echo esc_attr( $blog[ 'siteurl' ] ); ?>"
					title="<?php echo esc_attr( $blog[ 'blogname' ] ); ?>"
				><?php echo esc_attr( $blog[ 'blogname' ] ); ?></a>
			</span>
			<?php if( next( $blogs ) ): ?>
				<span class="separator">|</span>
			<?php prev( $blogs ); endif; ?>
		<?php } while( $blog = next( $blogs ) ); ?>
	</p>
<?php endif; ?>
