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

// Load textdomain
load_plugin_textdomain( BP_RELATE_GROUPS_TO_BLOGS_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) . '/languages' ) );

// Register group extension
bp_register_group_extension( 'BP_Relate_Groups_to_Blogs' );

// Enqueue scripts
add_action( 'wp_enqueue_scripts', array( BP_Relate_Groups_to_Blogs_Ajax, 'enqueue_scripts' ) );

// Hook an ajax request
add_action( 'wp_ajax_get_blogs', array( BP_Relate_Groups_to_Blogs_Ajax, 'get_blogs' ) );

// Registers the widget
add_action( 'widgets_init', create_function( '', 'register_widget( "BP_Relate_Groups_to_Blogs_Widget" );' ) );
