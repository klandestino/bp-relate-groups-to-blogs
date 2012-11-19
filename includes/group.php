<?php

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
	 * Loaded settings from get_site_option
	 */
	public $settings = array();

	/**
	 * Current group id
	 */
	public $group_id = 0;

	/**
	 * All related blog ids
	 */
	public $blogs_id = array();

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
		global $bp;

		// Get current group
		if( isset( $bp->groups->current_group ) ) {
			$this->group_id = $bp->groups->current_group->id;
		}

		// Get group blogs
		$this->blogs_id = groups_get_groupmeta( $this->group_id, 'bp_relate_groups_to_blogs' );

		// Load settings
		$this->settings = BP_Relate_Groups_to_Blogs_Admin::defaults( get_site_option( 'bp_relate_groups_to_blogs_settings', array() ) );

		// Apply
		$this->name = esc_attr( $this->settings[ 'group-tab-title' ] );
		$this->slug = __( 'related-blogs', 'bp-relate-groups-to-blogs' );
		$this->enable_nav_item = count( $this->blogs_id ) && $this->settings[ 'group-tab-enabled' ];

		if( count( $this->blogs_id ) && $this->settings[ 'group-header-enabled' ] ) {
			add_action( 'bp_group_header_meta', array( $this, 'display_header' ) );
		}
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
	public static function get_template( $slug, $name = '' ) {
		$template_names = array(
			$slug . '-' . $name . '.php',
			$slug . '.php'
		);

		$located = locate_template( $template_names );

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

	public static function check_array_value( $value ) {
		if( ! is_array( $value ) ) {
			if( is_numeric( $value ) ) {
				// Assume this is a group id
				$value = array( $value );
			} else {
				$value = array();
			}
		}

		return $value;
	}

	/**
	 * Get related blogs by group
	 * @param int $group_id optional, default is current group
	 * @return array
	 */
	public function get_blogs( $group_id = 0 ) {
		if( empty( $group_id ) ) {
			$group_id = $this->group_id;
		}

		if( $group_id == $this->group_id ) {
			$blogs_id = $this->blogs_id;
		} else {
			$blogs_id = groups_get_groupmeta( $group_id, 'bp_relate_groups_to_blogs' );
		}

		if( ! empty( $blogs_id ) ) {
			if( ! is_array( $blogs_id ) ) {
				$blogs_id = array( $blogs_id );
			}
		}

		return BP_Relate_Groups_to_Blogs_Ajax::get_blogs( $blogs_id, false );
	}

	/**
	 * Save related blogs by group
	 * Saves group reference in blog option and blog reference in group meta
	 * @param int $group_id int optional, default is current group
	 * @param int|array $blogs_id optional, default is null and will erase all relationsships
	 * @return void
	 */
	public function set_blogs( $group_id = 0, $blogs_id = 0 ) {
		global $wpdb;

		if( empty( $group_id ) ) {
			$group_id = $this->group_id;
		}

		$blogs_id = BP_Relate_Groups_to_Blogs::check_array_value( $blogs_id );

		// If there's no blogs, all meta and options shall be deleted
		if( empty( $blogs_id ) ) {
			// Group meta
			groups_delete_groupmeta( $group_id, 'bp_relate_groups_to_blogs' );

			// Blog option
			$query = $wpdb->get_results( sprintf(
				'SELECT `blog_id` FROM `%s`',
				mysql_real_escape_string( $wpdb->blogs )
			), ARRAY_A );

			foreach( $query as $blog ) {
				$groups = BP_Relate_Groups_to_Blogs::check_array_value( get_blog_option( $blog[ 'blog_id' ], 'bp_relate_groups_to_blogs', array() ) );

				// Using a while if there's any duplicates
				while( $i = array_search( $group_id, $groups ) ) {
					array_splice( $groups, $i, 1 );
				}

				if( count( $groups ) ) {
					// Update option
					update_blog_options( $blog[ 'blog_id' ], 'bp_relate_groups_to_blogs', $groups );
				} else {
					// Delete option instead of adding an empty array
					delete_blog_option( $blog[ 'blog_id' ], 'bp_relate_groups_to_blogs' );
				}
			}
		// Add meta and options
		} else {
			$query = $wpdb->get_results( sprintf(
				'SELECT `blog_id` FROM `%s` WHERE `blog_id` IN ( %s ) AND `public` = "1" AND `archived` = "0"',
				mysql_real_escape_string( $wpdb->blogs ),
				mysql_real_escape_string( implode( ',', $blogs_id ) )
			), ARRAY_A );

			foreach( $query as $blog ) {
				$groups = BP_Relate_Groups_to_Blogs::check_array_value( get_blog_option( $blog[ 'blog_id' ], 'bp_relate_groups_to_blogs', array() ) );

				// Check if group has alfready been added, if not, add
				if( ! in_array( $group_id, $groups ) ) {
					$groups[] = $group_id;
					update_blog_option( $blog[ 'blog_id' ], 'bp_relate_groups_to_blogs', $groups );
				}
			}

			groups_update_groupmeta( $group_id, 'bp_relate_groups_to_blogs', $blogs_id );
		}
	}

	/**
	 * Get display content
	 * @param int $group_id optional, default is current group
	 * @param boolean $raw optional, if true, content will be returned without any filtering
	 * @return content text filtered through the_content filter
	 */
	public function get_display_content( $group_id = 0, $raw = false ) {
		if( empty( $group_id ) ) {
			$group_id = $this->group_id;
		}

		$content = groups_get_groupmeta( $group_id, 'bp_relate_groups_to_blogs_display_content' );

		if( ! $this->settings[ 'group-page-desc-enabled' ] || empty( $content ) ) {
			$content = $this->settings[ 'group-page-desc' ];
		}
	
		if( $raw ) {
			return $content;
		} else {
			return apply_filters( 'the_content', $content );
		}
	}

	/**
	 * Set display content
	 * @param int $group_id optional, default is current group
	 * @param string $content the content
	 * @return void
	 */
	public function set_display_content( $group_id = 0, $content ) {
		global $bp;

		if( empty( $group_id ) ) {
			$group_id = $this->group_id;
		}

		groups_update_groupmeta( $group_id, 'bp_relate_groups_to_blogs_display_content', $content );
	}

	/**
	 * Get edit content
	 * @param int $group_id optional, default is current group
	 * @param boolean $raw optional, if true, content will be returned without any filtering
	 * @return content text filtered through the_content filter
	 */
	public function get_edit_content( $raw = false ) {
		$content = $this->settings[ 'group-edit-desc' ];
	
		if( $raw ) {
			return $content;
		} else {
			return apply_filters( 'the_content', $content );
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

		global $bp_relate_groups_to_blogs;
		$bp_relate_groups_to_blogs = $this;
		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-edit', 'create' );
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

		global $bp, $bp_relate_groups_to_blogs;
		$bp_relate_groups_to_blogs = $this;
		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-edit', $bp->groups->current_group->slug );
		?><p><input type="submit" value="<?php _e( 'Save' ) ?>" id="save" name="save" /></p><?php
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
			$this->set_blogs( 0, $_POST[ 'group-blog-blogs' ] );
		} else {
			$this->set_blogs( 0, 0 );
		}

		if( array_key_exists( 'group-blog-display-content', $_POST ) ) {
			$this->set_display_content( 0, $_POST[ 'group-blog-display-content' ] );
		}

		bp_core_add_message( __( 'Settings were successfully updated.', 'bp-relate-groups-to-blogs' ) );

		bp_core_redirect( sprintf(
			'%s/admin/%s',
			bp_get_group_permalink( $bp->groups->current_group ),
			$this->slug
		) );
	}

	/**
	 * Displays the related blogs in group tab
	 */
	public function display() {
		global $bp, $bp_relate_groups_to_blogs;
		$bp_relate_groups_to_blogs = $this;
		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-display', $bp->groups->current_group->slug );
	}

	/**
	 * Displays the related blogs in the group header
	 */
	public function display_header() {
		global $bp, $bp_relate_groups_to_blogs;
		$bp_relate_groups_to_blogs = $this;
		BP_Relate_Groups_to_Blogs::get_template( 'bp-relate-groups-to-blogs-header', $bp->groups->current_group->slug );
	}

}
