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
	 * Name of plugin
	 */
	public $name = 'Relate groups to blogs';

	/**
	 * Plugin slug
	 */
	public $slug = 'relate-groups-to-blogs';

	/**
	 * Where this plugin will render it's forms in the creation process
	 */
	public $create_step_position = 51;

	public $nav_item_position = 51;

	/**
	 * The contructor
	 */
	function __construct() {
		load_plugin_textdomain( 'bp-relate-groups-to-blogs', false, dirname( plugin_basename( __FILE__ ) . '/languages' ) );
		$this->name = __( $this->name, 'bp-relate-groups-to-blogs' );
		$this->slug = __( $this->slug, 'bp-relate-groups-to-blogs' );
	}

	/**
	 * Locates and loads a template by using Wordpress locate_template.
	 * If no template is found, it loads a template from this plugins template
	 * directory.
	 * @see locate_template
	 * @param string $slug
	 * @param string $name
	 * @return void
	 */
	public function get_template( $slug, $name = '' ) {
		$template_names = array(
			$slug . '-' . $name . '.php',
			$slug . '.php'
		);

		$located = locate_template( $template_names );

		global $bp_relate_groups_to_blogs;
		$bp_relate_groups_to_blogs = $this;

		if ( empty( $located ) ) {
			foreach( $template_names as $name ) {
				if ( file_exists( BP_RELATE_GROUPS_TO_BLOGS_TEMPLATE_DIR . '/' . $name ) ) {
					load_template( BP_RELATE_GROUPS_TO_BLOGS_TEMPLATE_DIR . '/' . $name, false );
					return;
				}
			}
		} else {
			load_template( $located, false );
		}
	}

	/**
	 * Get related blogs by group
	 * @param group_id int optional, default is current group
	 * @return array
	 */
	public function get_blogs( $group_id = 0 ) {
		if( ! $group_id ) {
			global $bp;
			$group_id = $bp->groups->current_group->id;
		}
	}

	/**
	 * Displays a create-form.
	 * Function executed when group is about to be created.
	 * @return void
	 */
	public function create_screen() {
		if( ! bp_is_group_creation_step( $this->slug ) ) {
			return false;
		}

		$this->get_template( 'bp-relate-groups-to-blogs-edit', 'create' );
		wp_nonce_field( 'groups_create_save_' . $this->slug );
	}

	/**
	 * Displays a edit-form.
	 * Function executed when groups is about to be edited.
	 * @return void
	 */
	public function edit_screen() {
		if( ! bp_is_group_admin_screen( $this->slug ) ) {
			return false;
		}

		global $bp;
		$this->get_template( 'bp-relate-groups-to-blogs-edit', $bp->groups->current_group->slug );
		wp_nonce_field( 'groups_create_save_' . $this->slug );
	}

}

/**
 * Handles the ajax-requests
 */
class BP_Relate_Groups_to_Blogs_Ajax {

	/**
	 * Makes wordpress load scripts
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'bp-relate-groups-to-blogs', BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_URL . '/js/bp-relate-groups-to-blogs.js', array( 'jquery' ) );
	}

	/**
	 * Searches for blogs by name
	 * @return array
	 */
	public function get_blogs( $query = '' ) {
		global $wpdb;
		$blogs = array();

		if( empty( $query ) && array_key_exists( 'query', $_POST ) ) {
			$query = $_POST[ 'query' ];
		}

		$result = $wpdb->get_results( sprintf(
			'SELECT `blog_id`, `domain` FROM `%s` WHERE `domain` LIKE "%%%s%%" AND `public` = "1" AND `archived` = "0"',
			mysql_real_escape_string( $wpdb->blogs ),
			mysql_real_escape_string( $query )
		) );

		foreach( $result as $blog ) {
			$blogs[] = $blog;
		}

		echo json_encode( $blogs );

		// Exit when done and before wordpress or something else prints a zero.
		exit;
	}

}

// Register group extension
bp_register_group_extension( 'BP_Relate_Groups_to_Blogs' );

// Enqueue scripts
add_action( 'wp_enqueue_scripts', array( BP_Relate_Groups_to_Blogs_Ajax, 'enqueue_scripts' ) );

// Hook an ajax request
add_action( 'wp_ajax_get_blogs', array( BP_Relate_Groups_to_Blogs_Ajax, 'get_blogs' ) );
