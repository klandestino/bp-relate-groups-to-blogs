<?php
/*
Plugin Name: BuddyPress Relate Groups to Blogs
Plugin URI: https://github.com/klandestino/bp-relate-groups-to-blogs
Description: Makes it possible to relate groups to blogs.
Version: 1.2.1
Revision Date: 11 19, 2012
Requires at least: 3.4.2
Tested up to: 3.4.2
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: spurge
Author URI: https://github.com/spurge
Network: true
*/

define( 'BP_RELATE_GROUPS_TO_BLOGS_IS_INSTALLED', 1 );
define( 'BP_RELATE_GROUPS_TO_BLOGS_VERSION', '1.1.2' );
define( 'BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_DIR', dirname( $network_plugin ) );
define( 'BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_URL', plugin_dir_url( '' ) . basename( BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_DIR ) );
define( 'BP_RELATE_GROUPS_TO_BLOGS_TEMPLATE_DIR', dirname( __FILE__ ) . '/templates' );

function bp_relate_groups_to_blogs_init() {
	if( version_compare( BP_VERSION, '1.3', '>' ) ) {
		require_once( dirname( __FILE__ ) . '/includes/loader.php' );
	}
}

add_action( 'bp_include', 'bp_relate_groups_to_blogs_init' );
