<?php
/**
 * Bloom - Client contact management and billing history.
 * @package bloom
 */

include_once( 'bloom/taxonomy-bloom-client.php' );
include_once( 'bloom/post-type-bloom-client.php' );
include_once( 'bloom/post-type-bloom-session.php' );

/**
 * Remove unnecessary items from Admin Menu.
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
