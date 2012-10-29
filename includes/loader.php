<?php

/**
 * If not ABSPATH is defined, then this plugin is not loaded into wordpress.
 * Then exit.
 */
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin/component witch is an extension of the Group Components
 */
class BP_Relate_Groups_to_Blogs extends BP_Group_Extension {

	/**
	 * The contructor
	 * Starts the plugin and hooks some actions
	 */
	function __construct() {
		parent::start(
			'bp-relate-group-to-blogs',
			__( 'BP Relate Groups to Blogs', 'bp-relate-groups-blogs' ),
			BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_DIR
		);

		//
	}

}

/**
 * Used with the bp_loaded action to load this plugin
 */
function bp_relate_groups_to_blogs_load_component() {
	global $bp;
	$bp->relate_groups_to_blogs = new BP_Relate_Groups_to_Blogs();
}

// Hook the bp_loaded action
add_action( 'bp_loaded', 'bp_relate_groups_to_blogs_load_component' );
