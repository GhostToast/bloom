<?php
/**
 * Status Taxonomy - Active, Inactive
 *
 * @package Wirecutter
 */

/**
 * Register Status Taxonomy.
 */
function bloom_client_status_taxonomy() {
	register_taxonomy(
		'bloom-client-status',
		'_bloom-client',
		array(
			'label'              => 'Status',
			'public'             => true,
			'show_admin_column'  => false,
			'show_in_nav_menus'  => false,
			'show_in_menu'       => false,
			'show_in_quick_edit' => false,
			'show_ui'            => true,
			'hierarchical'       => true,
			'sort'               => true,
			'rewrite'            => false,
			'capabilities'       => array(
				'assign_terms' => 'edit_posts',
			),
			'meta_box_cb'        => 'bloom_client_status_metabox',
		)
	);

	$terms = array(
		'Active',
		'Inactive',
	);

	/**
	 * Create our terms.
	 */
	foreach ( $terms as $term ) {
		if ( ! term_exists( $term, 'bloom-client-status' ) ) {
			wp_insert_term( $term, 'bloom-client-status' );
		}
	}
}
add_action( 'init', 'bloom_client_status_taxonomy' );

/**
 * Display the Status Term select box
 *
 * @param $post
 * @param $box
 */
function bloom_client_status_metabox( $post, $box ) {
	wp_nonce_field( 'bloom-client-status_meta_display', 'bloom-client-status_nonce' );
	$terms = get_terms( array( 'taxonomy' => 'bloom-client-status', 'hide_empty' => false, 'orderby' => 'term_id' ) );
	$status = wp_get_object_terms( $post->ID, 'bloom-client-status', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );

	if ( ! is_wp_error( $status ) && isset( $status[0] ) && isset( $status[0]->name ) ) {
		$current = $status[0]->name;
	} else {
		$current = '';
	}

	foreach ( $terms as $term ) {
		printf(
			'<label title="%1$s"><input type="radio" name="bloom-client-status" value="%1$s" %2$s><span>%1$s</span></label><br>',
			esc_attr( $term->name ),
			checked( $term->name, $current, false )
		);
	}
}

/**
 * Save our Status for Client
 * @param $post_id
 */
function bloom_client_save_status( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$nonce = filter_input( INPUT_POST, 'bloom-client-status_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( ! wp_verify_nonce( $nonce, 'bloom-client-status_meta_display' ) ) {
	}

	if ( isset( $_POST['bloom-client-status'] ) ) {
		$status = sanitize_text_field( $_POST['bloom-client-status'] );
	}

	if ( empty( $status ) ) {
		$status = 'Active';
	}
	$term = get_term_by( 'name', $status, 'bloom-client-status' );
	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
		wp_set_object_terms( $post_id, $term->term_id, 'bloom-client-status', false );
	}
}
add_action( 'save_post__bloom-client', 'bloom_client_save_status' );
