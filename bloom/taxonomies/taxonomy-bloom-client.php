<?php
/**
 * Client Taxonomy.
 * @package bloom
 */

/**
 * Register bloom-client taxonomy.
 */
function bloom_client_register_taxonomy() {

	register_taxonomy(
		'_bloom-client',
		'bloom-session',
		array(
			'label'         => 'Client (Required)',
			'sort'          => true,
			'rewrite'       => false,
			'show_in_menu'  => false,
			'show_tagcloud' => false,
			'hierarchical'  => false,
			'capabilities'  => array( 'assign_terms' => 'edit_posts' ),
			'meta_box_cb'  => 'bloom_client_taxonomy_metabox',
		)
	);
}
add_action( 'init', 'bloom_client_register_taxonomy' );

/**
 * Display the Bloom-Client Term select box
 *
 * @param $post
 * @param $box
 */
function bloom_client_taxonomy_metabox( $post, $box ) {
	echo '<form>';
	wp_nonce_field( 'bloom_client_taxonomy_metabox', 'bloom_client_taxonomy_nonce' );
	$terms = get_terms( array( 'taxonomy' => '_bloom-client', 'hide_empty' => false, 'orderby' => 'term_id' ) );
	$client_terms = wp_get_object_terms( $post->ID, '_bloom-client', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );

	// See if `bcid` was provided - a method to set this Session from an client view.
	if ( empty( $client_terms ) ) {
		$bcid = filter_input( INPUT_GET, 'bcid', FILTER_CALLBACK, array( 'options' => 'absint' ) );
		$client_terms[0] = get_term_by( 'name', $bcid, '_bloom-client' );
	}

	if ( isset( $client_terms[0] ) && isset( $client_terms[0]->term_id ) ) {
		$current_id = $client_terms[0]->term_id;
		$current_name = $client_terms[0]->name;
		$view_client_hidden = false;
	} else {
		$current_id = false;
		$current_name = 0;
		$view_client_hidden = true;
	}

	if ( ! empty( $terms ) ) {
		echo '<select name="_bloom-client" id="_bloom-client-dropdown" class="js-session-title" required>';
		echo '<option value="">-- Please select</option>';
		foreach ( $terms as $term ) {
			$client = get_post( $term->name );
			printf(
				'<option value="%1$s" data-termname="%4$s" %2$s>%3$s</option>',
				esc_attr( $term->term_id ),
				selected( $term->term_id, $current_id, false ),
				esc_html( $client->post_title ),
				esc_attr( $term->name )
			);
		}
		echo '</select>';

		printf(
			'<p><span style="%1$s" id="bloom-view-client-link-container"><a href="%2$s">View client</a> |</span> <a href="%3$s">New client</a>',
			$view_client_hidden ? esc_attr( 'display:none;' ) : esc_attr( '' ),
			esc_url( admin_url( "/post.php?post={$current_name}&action=edit" ) ),
			esc_url( admin_url( '/post-new.php?post_type=bloom-client' ) )
		);
	} else {
		printf(
			'<p>First, create a <a href="%1$s">new client</a>.</p>',
			esc_url( admin_url( '/post-new.php?post_type=bloom-client' ) )
		);
	}


	echo '</form>';
}

/**
 * Save our Session's Client
 * @param $post_id
 */
function bloom_session_save_client( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$nonce = filter_input( INPUT_POST, 'bloom_client_taxonomy_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( ! wp_verify_nonce( $nonce, 'bloom_client_taxonomy_metabox' ) ) {
	}

	if ( isset( $_POST['_bloom-client'] ) ) {
		$client_term_id = sanitize_text_field( $_POST['_bloom-client'] );
	}

	if ( empty( $client_term_id ) ) {
		return;
	}
	$term = get_term( $client_term_id, '_bloom-client' );
	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
		wp_set_object_terms( $post_id, $term->term_id, '_bloom-client', false );
	}
}
add_action( 'save_post_bloom-session', 'bloom_session_save_client' );

/**
 * Filter by taxonomy terms (admin screen).
 */
function bloom_client_taxonomy_admin_filter() {
	global $typenow;

	if ( 'bloom-session' === $typenow ) {
		$tax_slug = '_bloom-client';

		$tax_obj  = get_taxonomy( $tax_slug );
		$tax_name = $tax_obj->labels->name;
		$terms    = get_terms( array( 'taxonomy' => $tax_slug ) );
		if ( count( $terms ) > 0 ) {
			printf(
				'<select name="%1$s" id="%1$s" class="postform">',
				esc_attr( $tax_slug )
			);

			echo '<option value="">Show All Clients</option>';

			foreach ( $terms as $term ) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					esc_attr( $term->slug ),
					selected( $_GET[ $tax_slug ], $term->slug, false ),
					esc_html( get_the_title( $term->name ) ),
					intval( $term->count )
				);
			}
			echo '</select>';
		}
	}

}
add_action( 'restrict_manage_posts', 'bloom_client_taxonomy_admin_filter' );
