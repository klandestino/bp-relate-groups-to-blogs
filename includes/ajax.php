<?php

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
	 * @param string|int|array $query optional, search string or int or array with blog id's. Using $_POST[ query ] if empty
	 * @param boolean $print_json optional, if set to true, result will be printed as json and exit
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

		if( is_array( $query ) && ! empty( $query ) ) {
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
		}

		if( $print_json ) {
			echo json_encode( $blogs );
			// Exit when done and before wordpress or something else prints a zero.
			exit;
		} else {
			return $blogs;
		}
	}

}
