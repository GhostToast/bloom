<?php
/**
 * Client Post Type
 * @package bloom
 */

/**
 * Register Client Post Type.
 */
function bloom_register_client_post_type() {
	register_post_type(
		'_bloom-client',
		array(
			'labels'      => array(
				'name'               => 'Clients',
				'singular_name'      => 'Client',
				'add_new'            => 'Add Client',
				'search_items'       => 'Search Clients',
				'all_items'          => 'All Clients',
				'edit_item'          => 'Edit Client',
				'update_item'        => 'Update Client',
				'add_new_item'       => 'Add Client',
				'new_item_name'      => 'New Client',
				'not_found'          => 'No clients found',
				'not_found_in_trash' => 'No clients found in Trash',
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'clients' ),
			'menu_icon'   => 'dashicons-heart',
			'supports'    => array( 'title', 'editor' ),
		)
	);
}
add_action( 'init', 'bloom_register_client_post_type' );

/**
 * Adds metabox(es) for Post.
 */
function bloom_client_add_meta_boxes() {
	// Thumbnail Image. Goes in Sidebar.
	add_meta_box(
		'slc_thumbnail_metabox',
		'Thumbnail Image',
		'slc_thumbnail_meta_display',
		'bloom-client',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'slc_post_add_meta_boxes' );
