<?php global $before, $after, $title, $groups; ?>
<?php echo $before; ?>

<?php echo $title; ?>

<ul>
	<?php foreach( $groups as $group ): ?>
		<li><a href="<?php echo esc_url( bp_get_group_permalink( $group ) ); ?>"><?php echo $group->name; ?></a></li>
	<?php endforeach; ?>
</ul>

<?php echo $after; ?>
