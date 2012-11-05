<?php global $args, $instance; ?>
<?php echo $args[ 'before_widget' ]; ?>

<?php if ( ! empty( $args[ 'title' ] ) ): ?>
	<?php echo $args[ 'before_title' ] . $args[ 'title' ] . $args[ 'after_title' ]; ?>
<?php endif; ?>

<?php echo $args[ 'after_widget' ]; ?>
