<?php
/**
 * Client Taxonomy.
 * @package bloom
 */
/**
 * Register bloom-client taxonomy.
 */
function bloom_register_client() {

	register_taxonomy( 'bloom-client',
		'bloom-session',
		array(
			'label'  => 'Client',
			'labels' => array(
				'name'                       => 'Clients',
				'singular_name'              => 'Client',
				'menu_name'                  => 'Clients',
				'all_items'                  => 'All Clients',
				'edit_items'                 => 'Edit Client',
				'view_item'                  => 'View Client',
				'update_item'                => 'Update Client',
				'add_new_item'               => 'Add New Client',
				'new_item_name'              => 'New Client Name',
				'parent_item'                => 'Parent Client',
				'parent_item_colon'          => 'Parent Client:',
				'search_items'               => 'Search Clients',
				'popular_items'              => 'Popular Clients',
				'separate_items_with_commas' => 'Separate clients with commas',
				'add_or_remove_items'        => 'Add or remove clients',
				'choose_from_most_used'      => 'Choose from the most used clients',
				'not_found'                  => 'No clients found.',
			),
			'hierarchical' => true,
			'sort'         => true,
			'args'         => array( 'orderby' => 'term_order' ),
			'rewrite'      => array( 'slug' => 'client' ),
			'capabilities' => array( 'assign_terms' => 'edit_posts' ),
			'meta_box_cb'  => 'bloom_client_metabox',
		)
	);
}
add_action( 'init', 'bloom_register_client' );
