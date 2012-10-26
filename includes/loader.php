<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BP_Relate_Groups_to_Blogs extends BP_Component {

	function __construct() {
		parent::start(
			'bp-relate-group-to-blogs',
			__( 'BP Relate Groups to Blogs', 'bp-relate-groups-blogs' ),
			BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_DIR
		);
	}

}

function bp_relate_groups_to_blogs_load_component() {
	global $bp;
	$bp->relate_groups_to_blogs = new BP_Relate_Groups_to_Blogs();
}

add_action( 'bp_loaded', 'bp_relate_groups_to_blogs_load_component' );
