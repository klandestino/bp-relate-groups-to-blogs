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
			__( 'Relate Groups to Blogs Settings', 'bp-relate-groups-to-blogs' ),
			__( 'Relate Groups to Blogs', 'bp-relate-groups-to-blogs' ),
			'manage_options',
			'relate-groups-to-blogs',
			array( BP_Relate_Groups_to_Blogs_Admin, 'admin_page' )
		);
	}

	/**
	 * Adds default settings to a settings array
	 * @param array $settings settings to check
	 * @return array a new settings array with defaults
	 */
	public static function defaults( $settings ) {
		$defaults = array(
			'group-header-enabled' => true,
			'group-header-title' => __( 'Blogs', 'bp-relate-groups-to-blogs' ),
			'group-tab-title' => __( 'Blogs', 'bp-relate-groups-to-blogs' ),
			'group-tab-enabled' => true,
			'group-page-title' => __( 'Blogs', 'bp-relate-groups-to-blogs' ),
			'group-page-desc' => '',
			'group-page-desc-enabled' => true,
			'group-page-slogan-enabled' => true,
			'group-edit-desc' => __( 'Add blogs below by writing their names in the search field. The search result will be shown automatically in a list below.', 'bp-relate-groups-to-blogs' ),
			'group-edit-searchfield' => __( 'Find blogs by name', 'bp-relate-groups-to-blogs' ),
			'group-widget-title' => __( 'Groups', 'bp-relate-groups-to-blogs' )
		);

		if( is_array( $settings ) ) {
			foreach( $defaults as $key => $val ) {
				if( array_key_exists( $key, $settings ) ) {
					$defaults[ $key ] = $settings[ $key ];
				}
			}
		}

		return $defaults;
	}

	/**
	 * Prints an admin page through template
	 * @return void
	 */
	public static function admin_page() {
		global $settings;
		$settings = BP_Relate_Groups_to_Blogs_Admin::defaults( get_site_option( 'bp_relate_groups_to_blogs_settings', array() ) );
		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-admin' );
	}

	/**
	 * Receives the posted admin form and saved the settings
	 * @return void
	 */
	public static function admin_page_save() {
		if( array_key_exists( 'group-save', $_POST ) ) {
			check_admin_referer( 'bp_relate_groups_to_blogs_settings' );
			$settings = BP_Relate_Groups_to_Blogs_Admin::defaults( $_POST );

			if( ! array_key_exists( 'group-header-enabled', $_POST ) ) {
				$settings[ 'group-header-enabled' ] = false;
			}

			if( ! array_key_exists( 'group-tab-enabled', $_POST ) ) {
				$settings[ 'group-tab-enabled' ] = false;
			}

			if( ! array_key_exists( 'group-page-desc-enabled', $_POST ) ) {
				$settings[ 'group-page-desc-enabled' ] = false;
			}

			if( ! array_key_exists( 'group-page-desc-enabled', $_POST ) ) {
				$settings[ 'group-page-slogan-enabled' ] = false;
			}

			update_site_option( 'bp_relate_groups_to_blogs_settings', $settings );
			wp_redirect( add_query_arg( array( 'updated' => '1' ) ) );
		} elseif( array_key_exists( 'updated', $_GET ) ) {
			add_action( 'network_admin_notices', create_function( '', sprintf(
				'echo "<div class=\"updated\"><p>%s</p></div>";',
				__( 'Settings updated.', 'bp-relate-groups-to-blogs' )
			) ) );
		}
	}

}
