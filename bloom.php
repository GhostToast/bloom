<?php
/**
 * Bloom - Client contact management and billing history.
 * @package bloom
 */

// Bloom Folder URL.
if ( ! defined( 'BLOOM_PLUGIN_URL' ) ) {
	define( 'BLOOM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

include_once( 'bloom/post-types/post-type-bloom-client.php' );
include_once( 'bloom/post-types/post-type-bloom-session.php' );
include_once( 'bloom/taxonomies/taxonomy-bloom-client.php' );
include_once( 'bloom/taxonomies/taxonomy-bloom-client-status.php' );

/**
 * Remove unnecessary Admin Menu items.
 */
function bloom_remove_admin_menu_items() {

	remove_menu_page( 'index.php' );
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'upload.php' );
	remove_menu_page( 'edit.php?post_type=page' );
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'themes.php' );
	remove_menu_page( 'users.php' );
	remove_menu_page( 'tools.php' );

}
add_action( 'admin_menu', 'bloom_remove_admin_menu_items' );

/**
 * Remove unnecessary items from Admin Bar +New menu
 */
function bloom_remove_admin_bar_menu_items() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node( 'new-post' );
	$wp_admin_bar->remove_node( 'new-media' );
	$wp_admin_bar->remove_node( 'new-page' );
	$wp_admin_bar->remove_node( 'new-user' );
}
add_action( 'admin_bar_menu', 'bloom_remove_admin_bar_menu_items', 999 );

/**
 * Enqueue admin scripts for Bloom.
 */
function bloom_enqueue_admin_js() {
	wp_enqueue_media();
	wp_enqueue_script( 'bloom-admin', BLOOM_PLUGIN_URL . 'bloom/assets/js/bloom-admin.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'bloom_enqueue_admin_js' );
