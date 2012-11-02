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
	 * Name of extension
	 */
	public $name = 'Blogs';

	/**
	 * Plugin slug
	 */
	public $slug = 'related-blogs';

	/**
	 * If this plugin is visible for non-group members
	 */
	public $visible = true;

	/**
	 * If this plugin is available in the creation process
	 */
	public $enable_create_step = true;

	/**
	 * If this plugin is available in the edit form
	 */
	public $enable_edit_item = true;

	/**
	 * If this plugin is available in the nav bar
	 */
	public $enable_nav_item = false;

	/**
	 * Where this plugin will render it's forms in the creation process
	 */
	public $create_step_position = 51;

	/**
	 * Where this plugin will render it's edit form
	 */
	public $edit_step_position = 51;

	/**
	 * Where this plugin will render it's content in the group
	 */
	public $nav_item_position = 51;

	/**
	 * The contructor
	 */
	function __construct() {
		load_plugin_textdomain( 'bp-relate-groups-to-blogs', false, dirname( plugin_basename( __FILE__ ) . '/languages' ) );
		$this->name = __( $this->name, 'bp-relate-groups-to-blogs' );
		$this->slug = __( $this->slug, 'bp-relate-groups-to-blogs' );
		$this->enable_nav_item = $this->enable_nav_item();
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
		global $bp;

		if( empty( $group_id ) ) {
			$group_id = $bp->groups->current_group->id;
		}

		$blogs_id = groups_get_groupmeta( $group_id, 'bp_relate_groups_to_blogs' );

		if( ! empty( $blogs_id ) ) {
			if( ! is_array( $blogs_id ) ) {
				$blogs_id = array( $blogs_id );
			}
		}

		return BP_Relate_Groups_to_Blogs_Ajax::get_blogs( $blogs_id, false );
	}

	/**
	 * Save related blogs by group
	 * @param group_id int optional, default is current group
	 * @param blogs_id int|array optional, default is null and will erase all relationsships
	 * @return void
	 */
	public function set_blogs( $group_id = 0, $blogs_id = 0 ) {
		global $bp;

		if( empty( $group_id ) ) {
			$group_id = $bp->groups->current_group->id;
		}

		if( empty( $blogs_id ) ) {
			groups_delete_groupmeta( $group_id, 'bp_relate_groups_to_blogs' );
		} else {
			if( ! is_array( $blogs_id ) ) {
				$blogs_id = array( $blogs_id );
			}

			groups_update_groupmeta( $group_id, 'bp_relate_groups_to_blogs', $blogs_id );
		}
	}

	/**
	 * Get display content
	 * @param group_id int optional, default is current group
	 * @param raw boolean optional, if true, content will be returned without any filtering
	 * @return content text filtered through get_content filter
	 */
	public function get_display_content( $group_id = 0, $raw = false ) {
		global $bp;

		if( empty( $group_id ) ) {
			$group_id = $bp->groups->current_group->id;
		}
	
		if( $raw ) {
			return groups_get_groupmeta( $group_id, 'bp_relate_groups_to_blogs_display_content' );
		} else {
			return apply_filters( 'get_content', groups_get_groupmeta( $group_id, 'bp_relate_groups_to_blogs_display_content' ) );
		}
	}

	/**
	 * Set display content
	 * @param group_id int optional, default is current group
	 * @param content string the content
	 * @return void
	 */
	public function set_display_content( $group_id = 0, $content ) {
		global $bp;

		if( empty( $group_id ) ) {
			$group_id = $bp->groups->current_group->id;
		}

		groups_update_groupmeta( $group_id, 'bp_relate_groups_to_blogs_display_content', $content );
	}

	/**
	 * Getter for $enable_nav_item. Says true if there's at least
	 * one blog related to this group.
	 * @param group_id int optional, default is current group
	 * @return void
	 */
	public function enable_nav_item( $group_id = 0 ) {
		global $bp;

		if( empty( $group_id ) ) {
			$group_id = $bp->groups->current_group->id;
		}

		$blogs = groups_get_groupmeta( $group_id, 'bp_relate_groups_to_blogs' );

		return ( ! empty( $blogs ) );
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
	 * Receives the posted create-form
	 * @see create_screen
	 * @return void
	 */
	public function create_screen_save() {
		check_admin_referer( 'groups_create_save_' . $this->slug );

		if( array_key_exists( 'group-blog-blogs', $_POST ) ) {
			global $bp;
			$this->set_blogs( $bp->groups->new_group_id, $_POST[ 'group-blog-blogs' ] );
		}
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
		?><p><input type="submit" value="<?php _e( 'Save changes', 'bp-relate-groups-to-blogs' ) ?>" id="save" name="save" /></p><?php
		wp_nonce_field( 'groups_edit_save_' . $this->slug );
	}

	/**
	 * Receives the posted edit-form
	 * @see edit_screen
	 * @return void
	 */
	public function edit_screen_save() {
		global $bp;

		// edit_screen_save() is executed before edit_screen(). Don't know why,
		// but we need to know if a form has been posted to this request.
		// If $_POST[ 'save' ] exist, then we know a form has been posted. If
		// not we'll return with false so the rest of the screen-rendering
		// will work.
		if( ! array_key_exists( 'save', $_POST ) ) {
			return false;
		}

		check_admin_referer( 'groups_edit_save_' . $this->slug );

		if( array_key_exists( 'group-blog-blogs', $_POST ) ) {
			$this->set_blogs( $bp->groups->current_group->id, $_POST[ 'group-blog-blogs' ] );
		} else {
			$this->set_blogs( $bp->groups->current_group->id, 0 );
		}

		if( array_key_exists( 'group-blog-display-content', $_POST ) ) {
			$this->set_display_content( $bp->groups->current_group->id, $_POST[ 'group-blog-display-content' ] );
		}

		bp_core_add_message( __( 'Group blog settings were successfully updated.', 'bp-relate-groups-to-blogs' ) );

		bp_core_redirect( sprintf(
			'%s/admin/%s',
			bp_get_group_permalink( $bp->groups->current_group ),
			$this->slug
		) );
	}

	/**
	 * Displays the related blogs in this plugin tab
	 */
	public function display() {
		global $bp;
		$this->get_template( 'bp-relate-groups-to-blogs-display', $bp->groups->current_group->slug );
	}

}

/**
 * Handles the ajax-requests
 */
class BP_Relate_Groups_to_Blogs_Ajax {

	/**
	 * Makes wordpress load scripts and styles
	 * @return void
	 */
	static public function enqueue_scripts() {
		wp_enqueue_script( 'bp-relate-groups-to-blogs', BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_URL . '/js/bp-relate-groups-to-blogs.js', array( 'jquery' ) );
		wp_enqueue_style( 'bp-relate-groups-to-blogs', BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_URL . '/css/bp-relate-groups-to-blogs.css' );
	}

	/**
	 * Searches for blogs by name
	 * @param query string|int|array optional, search string or int or array with blog id's. Using $_POST[ query ] if empty
	 * @param print_json boolean optional, if set to true, result will be printed as json and exit
	 * @return array|void
	 */
	static public function get_blogs( $query = '', $print_json = true ) {
		global $wpdb;
		$blogs = array();
		$current_blog_id = $wpdb->blogid;

		if( empty( $query ) && array_key_exists( 'query', $_POST ) ) {
			$query = $_POST[ 'query' ];
		}

		if( is_numeric( $query ) ) {
			$query = array( $query );
		}

		if( is_array( $query ) ) {
			$query = $wpdb->get_results( sprintf(
				'SELECT `blog_id`, `domain` FROM `%s` WHERE `blog_id` IN ( %s ) AND `public` = "1" AND `archived` = "0"',
				mysql_real_escape_string( $wpdb->blogs ),
				mysql_real_escape_string( implode( ',', $query ) )
			), ARRAY_A );
		} elseif( ! empty( $query ) ) {
			$query = $wpdb->get_results( sprintf(
				'SELECT `blog_id`, `domain` FROM `%s` WHERE `domain` LIKE "%%%s%%" AND `public` = "1" AND `archived` = "0"',
				mysql_real_escape_string( $wpdb->blogs ),
				mysql_real_escape_string( $query )
			), ARRAY_A );
		}

		foreach( $query as $blog ) {
			$wpdb->set_blog_id( $blog[ 'blog_id' ] );

			$subquery = $wpdb->get_results( sprintf(
				'SELECT `option_name`, `option_value` FROM `%s` WHERE `option_name` IN ( "siteurl", "blogname", "blogdescription" )',
				mysql_real_escape_string( $wpdb->options )
			), ARRAY_A );

			foreach( $subquery as $opt ) {
				$blog[ $opt[ 'option_name' ] ] = esc_attr( $opt[ 'option_value' ] );
			}

			$blogs[] = $blog;
		}

		$wpdb->set_blog_id( $current_blog_id );

		if( $print_json ) {
			echo json_encode( $blogs );
			// Exit when done and before wordpress or something else prints a zero.
			exit;
		} else {
			return $blogs;
		}
	}

}

// Register group extension
bp_register_group_extension( 'BP_Relate_Groups_to_Blogs' );

// Enqueue scripts
add_action( 'wp_enqueue_scripts', array( BP_Relate_Groups_to_Blogs_Ajax, 'enqueue_scripts' ) );

// Hook an ajax request
add_action( 'wp_ajax_get_blogs', array( BP_Relate_Groups_to_Blogs_Ajax, 'get_blogs' ) );
