<?php
/**
 * Client Taxonomy.
 * @package bloom
 */

/**
 * Register bloom-client taxonomy.
 */
function bloom_register_client_taxonomy() {

	register_taxonomy(
		'bloom-client',
		'bloom-session',
		array(
			'label'         => 'Client',
			'sort'          => true,
			'rewrite'       => false,
			'show_in_menu'  => false,
			'show_tagcloud' => false,
			'hierarchical'  => false,
			'capabilities'  => array( 'assign_terms' => 'edit_posts' ),
			//'meta_box_cb'  => 'bloom_client_metabox',
		)
	);
}
add_action( 'init', 'bloom_register_client_taxonomy' );
