<?php
/**
 * Session Post Type
 * @package bloom
 */

/**
 * Register Session Post Type.
 */
function bloom_register_session_post_type() {
	register_post_type(
		'bloom-session',
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
			'public'             => true,
			'publicly_queryable' => false,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'sessions' ),
			'menu_icon'          => 'dashicons-clock',
			'supports'           => array( 'title' ),
		)
	);
}
add_action( 'init', 'bloom_register_session_post_type' );

/**
 * Adds metabox(es) for Session.
 */
function bloom_session_add_meta_boxes() {
	// Details.
	add_meta_box(
		'bloom_session_details_metabox',
		'Details',
		'bloom_session_details_metabox',
		'bloom-session',
		'advanced',
		'default'
	);

	// Notes.
	add_meta_box(
		'bloom_session_notes_metabox',
		'Notes',
		'bloom_session_notes_metabox',
		'bloom-session',
		'advanced',
		'default'
	);
}
add_action( 'add_meta_boxes', 'bloom_session_add_meta_boxes' );

/**
 * Session Details metabox.
 * @param $post
 */
function bloom_session_details_metabox( $post ) {
	wp_nonce_field( 'bloom_session_details_metabox', 'bloom_session_details_nonce' );
	$session_diagnosis         = get_post_meta( $post->ID, 'session_diagnosis', true );
	$session_date              = get_post_meta( $post->ID, 'session_date', true );
	$session_fee               = get_post_meta( $post->ID, 'session_fee', true );
	$session_collected         = get_post_meta( $post->ID, 'session_collected', true );
	$session_insurance_payment = get_post_meta( $post->ID, 'session_insurance_payment', true );
	$session_balance           = get_post_meta( $post->ID, 'session_balance', true );

	// @TODO - build a total balance between sessions for a client. It should probably be saved to the client.
	$total_balance = '';
	?>
	<table class="form-table">
		<tr>
			<th scope="row" valign="top"><label for="session_diagnosis">Diagnosis:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="session_diagnosis" value="<?php echo esc_html( $session_diagnosis ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="session_date">Session Date:<br><span style="font-weight:normal;font-style:italic;">Required</span></label></th>
			<td>
				<div>
					<input type="date" class="regular-text js-session-title" name="session_date" id="session_date" value="<?php echo esc_html( $session_date ); ?>" autocomplete="off" required />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="session_fee">Session Fee:</label></th>
			<td>
				<div>
					<input type="number" class="small-text" name="session_fee" value="<?php echo esc_html( $session_fee ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="session_collected">Collected/Copay:</label></th>
			<td>
				<div>
					<input type="number" class="regular-text" name="session_collected" value="<?php echo esc_html( $session_collected ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="session_insurance_payment">Insurance Payment:</label></th>
			<td>
				<div>
					<input type="number" class="regular-text" name="session_insurance_payment" value="<?php echo esc_html( $session_insurance_payment ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="session_balance">Session Balance:</label></th>
			<td>
				<div>
					<input type="number" class="regular-text" name="session_balance" value="<?php echo esc_html( $session_balance ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Bloom Session Notes metabox.
 * @param $post
 */
function bloom_session_notes_metabox( $post ) {
	wp_nonce_field( 'bloom_session_notes_metabox', 'bloom_session_notes_nonce' );
	$session_notes = get_post_meta( $post->ID, 'session_notes', true );
	?>
	<table class="form-table">
		<tr valign="top">
			<td colspan="2">
				<?php wp_editor(
					wp_kses_post( $session_notes ),
					'session_notes',
					array(
						'textarea_rows' => 10,
						'media_buttons' => false,
						'tinymce' => array(
							'toolbar1' => 'bold,italic,underline,link,unlink,bullist,numlist,undo,redo,pastetext,removeformat',
							'toolbar2' => ' ',
						),
						'quicktags' => false,
					)
				); ?>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Save session post meta.
 *
 * @param int    $post_id ID of post.
 */
function bloom_session_save_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$sanitized_inputs = array();

	$nonce = filter_input( INPUT_POST, 'bloom_session_details_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( wp_verify_nonce( $nonce, 'bloom_session_details_metabox' ) ) {
		$sanitized_inputs['session_diagnosis']         = filter_input( INPUT_POST, 'session_diagnosis', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['session_date']              = filter_input( INPUT_POST, 'session_date', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['session_fee']               = filter_input( INPUT_POST, 'session_fee', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['session_collected']         = filter_input( INPUT_POST, 'session_collected', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['session_insurance_payment'] = filter_input( INPUT_POST, 'session_insurance_payment', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['session_balance']           = filter_input( INPUT_POST, 'session_balance', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	}

	$nonce = filter_input( INPUT_POST, 'bloom_session_notes_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( wp_verify_nonce( $nonce, 'bloom_session_notes_metabox' ) ) {
		$sanitized_inputs['session_notes'] = filter_input( INPUT_POST, 'session_notes', FILTER_CALLBACK, array( 'options' => 'wp_kses_post' ) );
	}


	foreach ( $sanitized_inputs as $key => $value ) {
		if ( empty( $value ) ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_bloom-session', 'bloom_session_save_meta' );

/**
 * Add Extra columns: Last Name. In the order we wish.
 * @param $columns
 *
 * @return mixed
 */
function bloom_session_extra_columns( $columns ) {
	$return_columns = array();
	foreach ( $columns as $key => $value ) {
		$return_columns[ $key ] = $value;
		if ( 'title' === $key ) {
			// Rename "title" to "name" because it makes more sense here.
			$return_columns[ $key ] = 'Session Name';
			$return_columns['session_client_last_name'] = 'Last Name';
			$return_columns['session_date'] = 'Session Date';
		}
	}
	return $return_columns;
}
add_filter( 'manage_edit-bloom-session_columns', 'bloom_session_extra_columns' );

/**
 * Fill out extra column content: Last Name, Session Date.
 * @param $column_name
 * @param $post_id
 */
function bloom_session_last_name_column_content( $column_name, $post_id ) {
	// Last Name.
	if ( 'session_client_last_name' === $column_name ) {
		$client_terms = wp_get_object_terms( $post_id, '_bloom-client', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );

		if ( isset( $client_terms[0] ) && isset( $client_terms[0]->name ) ) {
			$last_name = get_post_meta( $client_terms[0]->name, 'client_last_name', true );
			echo esc_html( $last_name );
		}
	} // Session Date.
	elseif ( 'session_date' === $column_name ) {
		$session_date = get_post_meta( $post_id, 'session_date', true );
		echo esc_html( date( 'F j, Y ', strtotime( $session_date ) ) );
	}
}
add_action( 'manage_bloom-session_posts_custom_column', 'bloom_session_last_name_column_content', 10, 2 );

/**
 * Make column sortable: Last Name.
 * @param $columns
 *
 * @return mixed
 */
function bloom_session_last_name_sortable_column( $columns ) {
	$columns['session_client_last_name'] = 'session_client_last_name';
	$columns['session_date'] = 'session_date';
	return $columns;
}
add_filter( 'manage_edit-bloom-session_sortable_columns', 'bloom_session_last_name_sortable_column' );


/**
 * Add quick link.
 * @param         $actions
 * @param WP_Post $post
 *
 * @return mixed
 */
function bloom_session_row_actions( $actions, WP_Post $post ) {
	if ( 'bloom-session' !== $post->post_type ) {
		return $actions;
	}

	// Remove quick edit.
	unset( $actions['inline hide-if-no-js'] );

	$client_terms = wp_get_object_terms( $post->ID, '_bloom-client', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );

	if ( isset( $client_terms[0] ) && isset( $client_terms[0]->name ) ) {
		// Add "View Client" link.
		$actions['bloom_client_link'] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( get_edit_post_link( $client_terms[0]->name, '&' ) ),
			'Edit Client'
		);
	}

	return $actions;
}
add_filter( 'post_row_actions', 'bloom_session_row_actions', 10, 2 );
