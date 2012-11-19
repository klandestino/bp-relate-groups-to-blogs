<?php

/**
 * If not ABSPATH is defined, then this plugin is not loaded into wordpress.
 * Then exit.
 */
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load the group-plugin class
require_once( dirname( __FILE__ ) . '/group.php' );

// Load the ajax class
require_once( dirname( __FILE__ ) . '/ajax.php' );

// Load the widget class
require_once( dirname( __FILE__ ) . '/widget.php' );

// Load the admin class
require_once( dirname( __FILE__ ) . '/admin.php' );

// Load textdomain
load_plugin_textdomain( 'bp-relate-groups-to-blogs', false, plugin_basename( BP_RELATE_GROUPS_TO_BLOGS_PLUGIN_DIR ) . "/languages/" );

// Register group extension
bp_register_group_extension( 'BP_Relate_Groups_to_Blogs' );

// Enqueue scripts
add_action( 'wp_enqueue_scripts', array( BP_Relate_Groups_to_Blogs_Ajax, 'enqueue_scripts' ) );

// Hook an ajax request
add_action( 'wp_ajax_get_blogs', array( BP_Relate_Groups_to_Blogs_Ajax, 'get_blogs' ) );

// Registers the widget
add_action( 'widgets_init', create_function( '', 'register_widget( "BP_Relate_Groups_to_Blogs_Widget" );' ) );

// If we're in the administration
if( is_site_admin() ) {
	add_action( 'admin_init', array( BP_Relate_Groups_to_Blogs_Admin, 'admin_page_save' ) );
	add_action( 'network_admin_menu', array( BP_Relate_Groups_to_Blogs_Admin, 'admin_menu' ) );
}
