<?php
/**
 * Session Status Taxonomy - Submitted, Paid
 *
 * @package Wirecutter
 */

/**
 * Register Status Taxonomy.
 */
function bloom_session_status_taxonomy() {
	register_taxonomy(
		'bloom-session-status',
		'bloom-session',
		array(
			'label'              => 'Status',
			'public'             => true,
			'show_admin_column'  => true,
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
			'meta_box_cb'        => 'bloom_session_status_metabox',
		)
	);

	$terms = array(
		'Submitted',
		'Paid',
	);

	/**
	 * Create our terms.
	 */
	foreach ( $terms as $term ) {
		if ( ! term_exists( $term, 'bloom-session-status' ) ) {
			wp_insert_term( $term, 'bloom-session-status' );
		}
	}
}
add_action( 'init', 'bloom_session_status_taxonomy' );

/**
 * Display the Status Term select box
 *
 * @param $post
 * @param $box
 */
function bloom_session_status_metabox( $post, $box ) {
	wp_nonce_field( 'bloom-session-status_meta_display', 'bloom-session-status_nonce' );
	$terms = get_terms( array( 'taxonomy' => 'bloom-session-status', 'hide_empty' => false, 'orderby' => 'term_id' ) );
	$status = wp_get_object_terms( $post->ID, 'bloom-session-status', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );

	if ( ! is_wp_error( $status ) && isset( $status[0] ) && isset( $status[0]->name ) ) {
		$current = $status[0]->name;
	} else {
		$current = '';
	}

	foreach ( $terms as $term ) {
		printf(
			'<label title="%1$s"><input type="radio" name="bloom-session-status" value="%1$s" %2$s><span>%1$s</span></label><br>',
			esc_attr( $term->name ),
			checked( $term->name, $current, false )
		);
	}
}

/**
 * Save our Status for Session
 * @param $post_id
 */
function bloom_session_save_status( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$nonce = filter_input( INPUT_POST, 'bloom-session-status_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( ! wp_verify_nonce( $nonce, 'bloom-session-status_meta_display' ) ) {
		return;
	}

	if ( isset( $_POST['bloom-session-status'] ) ) {
		$status = sanitize_text_field( $_POST['bloom-session-status'] );
	}

	if ( empty( $status ) ) {
		$status = 'Submitted';
	}
	$term = get_term_by( 'name', $status, 'bloom-session-status' );
	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
		wp_set_object_terms( $post_id, $term->term_id, 'bloom-session-status', false );
	}
}
add_action( 'save_post_bloom-session', 'bloom_session_save_status' );

/**
 * Filter by taxonomy terms (admin screen).
 */
function bloom_session_status_admin_filter() {
	global $typenow;

	if ( 'bloom-session' === $typenow ) {
		$tax_slug = 'bloom-session-status';

		$tax_obj  = get_taxonomy( $tax_slug );
		$tax_name = $tax_obj->labels->name;
		$terms    = get_terms( array( 'taxonomy' => $tax_slug ) );
		if ( count( $terms ) > 0 ) {
			printf(
				'<select name="%1$s" id="%1$s" class="postform">',
				esc_attr( $tax_slug )
			);
			printf(
				'<option value="">Show All %1$s</option>',
				esc_html( $tax_name )
			);

			foreach ( $terms as $term ) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					esc_attr( $term->slug ),
					selected( $_GET[ $tax_slug ], $term->slug, false ),
					esc_html( $term->name ),
					intval( $term->count )
				);
			}
			echo '</select>';
		}
	}

}
add_action( 'restrict_manage_posts', 'bloom_session_status_admin_filter' );
