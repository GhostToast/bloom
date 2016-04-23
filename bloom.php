<?php
/**
 * Plugin Name: Bloom - Client Management
 * Plugin URI: https://github.com/GhostToast/bloom
 * Description: Client management and session history for private practices. Not intended for <strong>public facing</strong> web use. Heavily pares down other WordPress menus and content types.
 * Version: 0.1
 * Author: Gustave F. Gerahrdt
 * Author URI: http://ghosttoa.st
 * License: GPLv2 or later
 *
 * @package bloom
 */

// Bloom Folder URL.
if ( ! defined( 'BLOOM_PLUGIN_URL' ) ) {
	define( 'BLOOM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

include_once( 'post-types/post-type-bloom-client.php' );
include_once( 'post-types/post-type-bloom-session.php' );
include_once( 'taxonomies/taxonomy-bloom-client.php' );
include_once( 'taxonomies/taxonomy-bloom-client-status.php' );
include_once( 'taxonomies/taxonomy-bloom-session-status.php' );

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
	wp_enqueue_script( 'bloom-admin', BLOOM_PLUGIN_URL . 'assets/js/bloom-admin.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'bloom_enqueue_admin_js' );

/**
 * Custom labels for custom post types.
 * @param $bulk_messages
 * @param $bulk_counts
 *
 * @return mixed
 */
function bloom_bulk_post_updated_messages_filter( $bulk_messages, $bulk_counts ) {
	$bulk_messages['bloom-client'] = array(
		'updated'   => _n( '%s client updated.', '%s clients updated.', $bulk_counts['updated'] ),
		'locked'    => _n( '%s client not updated, somebody is editing it.', '%s clients not updated, somebody is editing them.', $bulk_counts['locked'] ),
		'deleted'   => _n( '%s client permanently deleted.', '%s clients permanently deleted.', $bulk_counts['deleted'] ),
		'trashed'   => _n( '%s client moved to the Trash.', '%s clients moved to the Trash.', $bulk_counts['trashed'] ),
		'untrashed' => _n( '%s client restored from the Trash.', '%s clients restored from the Trash.', $bulk_counts['untrashed'] ),
	);

	$bulk_messages['bloom-session'] = array(
		'updated'   => _n( '%s session updated.', '%s sessions updated.', $bulk_counts['updated'] ),
		'locked'    => _n( '%s session not updated, somebody is editing it.', '%s sessions not updated, somebody is editing them.', $bulk_counts['locked'] ),
		'deleted'   => _n( '%s session permanently deleted.', '%s sessions permanently deleted.', $bulk_counts['deleted'] ),
		'trashed'   => _n( '%s session moved to the Trash.', '%s sessions moved to the Trash.', $bulk_counts['trashed'] ),
		'untrashed' => _n( '%s session restored from the Trash.', '%s sessions restored from the Trash.', $bulk_counts['untrashed'] ),
	);
	return $bulk_messages;
}
add_filter( 'bulk_post_updated_messages', 'bloom_bulk_post_updated_messages_filter', 10, 2 );
