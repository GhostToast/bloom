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
			'label'         => 'Client',
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
	wp_nonce_field( 'bloom_client_taxonomy_metabox', 'bloom_client_taxonomy_nonce' );
	$terms = get_terms( array( 'taxonomy' => '_bloom-client', 'hide_empty' => false, 'orderby' => 'term_id' ) );
	$client_term = wp_get_object_terms( $post->ID, '_bloom-client', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );

	// See if `bcid` was provided - a method to set this Session from an client view.
	if ( empty( $client_term ) ) {
		$bcid = filter_input( INPUT_GET, 'bcid', FILTER_CALLBACK, array( 'options' => 'absint' ) );
		$client_term = wp_get_object_terms( $bcid, '_bloom-client', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	}

	if ( isset( $client_term[0] ) && isset( $client_term[0]->term_id ) ) {
		$current = $client_term[0]->term_id;
	} else {
		$current = false;
	}

	if ( ! empty( $terms ) ) {
		echo '<select name="_bloom-client">';
		echo '<option value="">-- Please select</option>';
		foreach ( $terms as $term ) {
			$client = get_post( $term->name );
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr( $term->term_id ),
				selected( $term->term_id, $current, false ),
				esc_html( $client->post_title )
			);
		}
		echo '</select>';
		$format_string = '<p>Or create a <a href="%1$s">new client</a>.</p>';
	} else {
		$format_string = '<p>First, create a <a href="%1$s">new client</a>.</p>';
	}

	printf(
		$format_string,
		esc_url( admin_url( '/post-new.php?post_type=bloom-client' ) )
	);

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