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

/**
 * Edit client meta fields.
 */
function bloom_client_edit_term_meta_fields() {
	$screen = get_current_screen();

	$term_id = filter_input( INPUT_GET, 'tag_ID', FILTER_CALLBACK, array( 'options' => 'absint' ) );

	wp_nonce_field( 'custom_bloom-client_meta', '_wpnonce_bloom-client' );

	if ( ! empty( $screen->taxonomy ) && 'bloom-client' === $screen->taxonomy && ! empty( $term_id ) ) :
		
		?>
		

	<?php endif;
}
add_action( 'bloom-client_edit_form_fields', 'bloom_client_edit_term_meta_fields', 10, 2 );

/**
 * Save client term meta.
 *
 * @param int    $term_id ID of term.
 * @param string $tt_id   TT id.
 */
function bloom_client_save_meta( $term_id, $tt_id ) {
	$nonce = filter_input( INPUT_POST, '_wpnonce_bloom-client', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( ! wp_verify_nonce( $nonce, 'custom_bloom-client_meta' ) ) {
		return;
	}

	$sanitized_inputs['client_first_name']  = filter_input( INPUT_POST, 'client_first_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_middle_name'] = filter_input( INPUT_POST, 'client_middle_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_last_name']   = filter_input( INPUT_POST, 'client_last_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );

	$sanitized_inputs['client_address_street_1'] = filter_input( INPUT_POST, 'client_address_street_1', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_address_street_2'] = filter_input( INPUT_POST, 'client_address_street_2', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_address_city']     = filter_input( INPUT_POST, 'client_address_city', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_address_state']    = filter_input( INPUT_POST, 'client_address_state', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_address_zip']      = filter_input( INPUT_POST, 'client_address_zip', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );

	$sanitized_inputs['client_dob']     = filter_input( INPUT_POST, 'client_dob', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_phone_1'] = filter_input( INPUT_POST, 'client_phone_1', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_phone_2'] = filter_input( INPUT_POST, 'client_phone_2', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['client_email']   = filter_input( INPUT_POST, 'client_email', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );

	$sanitized_inputs['emergency_name']  = filter_input( INPUT_POST, 'emergency_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['emergency_phone'] = filter_input( INPUT_POST, 'emergency_phone', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );

	$sanitized_inputs['insurance_provider']               = filter_input( INPUT_POST, 'insurance_provider', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['insurance_group_number']           = filter_input( INPUT_POST, 'insurance_group_number', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['insurance_member_id']              = filter_input( INPUT_POST, 'insurance_member_id', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['insurance_policy_holder_name']     = filter_input( INPUT_POST, 'insurance_policy_holder_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['insurance_policy_holder_dob']      = filter_input( INPUT_POST, 'insurance_policy_holder_dob', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['insurance_customer_service_phone'] = filter_input( INPUT_POST, 'insurance_customer_service_phone', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	$sanitized_inputs['insurance_benefit_information']    = filter_input( INPUT_POST, 'insurance_benefit_information', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );

	foreach ( $sanitized_inputs as $key => $value ) {
		if ( empty( $value ) ) {
			delete_term_meta( $term_id, $key );
		} else {
			update_term_meta( $term_id, $key, $value );
		}
	}
}
add_action( 'created_bloom-client', 'bloom_client_save_meta', 10, 2 );
add_action( 'edit_bloom-client', 'bloom_client_save_meta', 10, 2 );
