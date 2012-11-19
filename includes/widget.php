<?php

/**
 * Creates a widget for the related blogs
 */
class BP_Relate_Groups_to_Blogs_Widget extends WP_Widget {

	/**
	 * Initiates the widget and register with Wordpress
	 */
	function __construct() {
		parent::__construct(
			'bp_relate_groups_to_blogs_widget',
			'Related Groups Widget',
			array( 'description' => __( 'Related Groups Widget', 'bp-relate-groups-to-blogs' ), )
		 );
	}

	/**
	 * Front-end widget display that display a list of related groups, but only if there are an.
	 *
	 * @param array $args Widget arguments
	 * @param array $instance Widget instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		global $wpdb, $before, $after, $title, $groups;
		$args[ 'title' ] = apply_filters( 'widget_title', $instance[ 'title' ] );
		$groups = BP_Relate_Groups_to_Blogs::check_array_value( get_option( 'bp_relate_groups_to_blogs', array() ) );

		if ( ! empty( $args[ 'title' ] ) ) {
			$title = $args[ 'before_title' ] . $args[ 'title' ] . $args[ 'after_title' ];
		}

		$before = $args[ 'before_widget' ];
		$after = $args[ 'after_widget' ];

		// Only print widget if there's any groups defined
		if( count( $groups ) ) {
			foreach( $groups as $i => $group ) {
				$groups[ $i ] = groups_get_group( array( 'group_id' => $group ) );
			}

			BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-widget' );
		}
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 * @return void
	 */
	public function form( $instance ) {
		global $title, $title_id, $title_name, $groups;
		$title_id = $this->get_field_id( 'title' );
		$title_name = $this->get_field_name( 'title' );
		$groups = BP_Relate_Groups_to_Blogs::check_array_value( get_option( 'bp_relate_groups_to_blogs', array() ) );

		foreach( $groups as $i => $group ) {
			$groups[ $i ] = groups_get_group( array( 'group_id' => $group ) );
		}

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$settings = BP_Relate_Groups_to_Blogs_Admin::defaults( get_option( 'bp_relate_groups_to_blogs_settings', array() ) );
			$title = $settings[ 'group-widget-title' ];
		}

		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-widget-form' );
	}

}
