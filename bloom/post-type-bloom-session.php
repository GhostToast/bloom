<?php
/**
 * Session Post Type
 * @package bloom
 */

/**
 * Register Session Post Type.
 */
function bloom_register_session() {
	register_post_type( 'bloom-session',
		array(
			'labels'      => array(
				'name'               => 'Sessions',
				'singular_name'      => 'Session',
				'add_new'            => 'Add Session',
				'search_items'       => 'Search Sessions',
				'all_items'          => 'All Sessions',
				'edit_item'          => 'Edit Session',
				'update_item'        => 'Update Session',
				'add_new_item'       => 'Add Session',
				'new_item_name'      => 'New Session',
				'not_found'          => 'No sessions found',
				'not_found_in_trash' => 'No sessions found in Trash',
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'sessions' ),
			'menu_icon'   => 'dashicons-carrot',
			'supports'    => array( 'title', 'editor' ),
		)
	);
}
add_action( 'init', 'bloom_register_session' );
