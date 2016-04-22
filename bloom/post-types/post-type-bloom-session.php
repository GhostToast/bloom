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
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'sessions' ),
			'menu_icon'   => 'dashicons-clock',
			'supports'    => array( 'title' ),
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
			<th scope="row" valign="top"><label for="session_insurance_payment">Insurace Payment:</label></th>
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
					<input type="number" class="regular-text" name="insurance_customer_service_phone" value="<?php echo esc_html( $session_balance ); ?>" autocomplete="off" />
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
					'bloom_session_notes',
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
