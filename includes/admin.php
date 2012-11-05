<?php

/**
 * Administration class.
 * Adds admin menu item and admin page
 */
class BP_Relate_Groups_to_Blogs_Admin {

	/**
	 * Adds menu item
	 * @return void
	 */
	public static function admin_menu() {
		add_submenu_page(
			'settings.php',
			__( 'Group-blog relationships', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ),
			__( 'Group-blog relationships', BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN ),
			'manage_options',
			'relate-groups-to-blogs',
			array( BP_Relate_Groups_to_Blogs_Admin, 'admin_page' )
		);
	}

	/**
	 * Prints an admin page through template
	 * @return void
	 */
	public static function admin_page() {
		global $settings;
		$settings = get_site_option( 'bp_relate_groups_to_blogs_settings', array() );

		if( ! array_key_exists( 'group-tab-title', $settings ) ) {
			$settings[ 'group-tab-title' ] = 'Blogs';
		}

		if( ! array_key_exists( 'group-page-title', $settings ) ) {
			$settings[ 'group-page-title' ] = 'Blogs';
		}

		if( ! array_key_exists( 'group-page-desc-enabled', $settings ) ) {
			$settings[ 'group-page-desc-enabled' ] = true;
		}

		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-admin' );
	}

}
