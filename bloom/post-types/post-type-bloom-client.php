<?php
/**
 * Client Post Type
 * @package bloom
 */

/**
 * Register Client Post Type.
 */
function bloom_register_client_post_type() {
	register_post_type(
		'bloom-client',
		array(
			'labels'      => array(
				'name'               => 'Clients',
				'singular_name'      => 'Client',
				'add_new'            => 'Add Client',
				'search_items'       => 'Search Clients',
				'all_items'          => 'All Clients',
				'edit_item'          => 'Edit Client',
				'view_item'          => 'View Client',
				'update_item'        => 'Update Client',
				'add_new_item'       => 'Add Client',
				'new_item_name'      => 'New Client',
				'not_found'          => 'No clients found',
				'not_found_in_trash' => 'No clients found in Trash',
			),
			'public'             => true,
			'publicly_queryable' => false,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'clients' ),
			'menu_icon'          => 'dashicons-heart',
			'supports'           => array( 'title' ),
		)
	);
}
add_action( 'init', 'bloom_register_client_post_type' );

/**
 * Change "Enter Title Here" to something more appropriate.
 * @param $title
 *
 * @return string
 */
function bloom_client_change_title_text( $title ) {
	$screen = get_current_screen();
	if ( 'bloom-client' === $screen->post_type ) {
		$title = '';
	}
	return $title;
}
add_filter( 'enter_title_here', 'bloom_client_change_title_text' );

/**
 * Adds metabox(es) for Client.
 */
function bloom_client_add_meta_boxes() {
	// Information.
	add_meta_box(
		'bloom_client_information_metabox',
		'Information',
		'bloom_client_information_metabox',
		'bloom-client',
		'advanced',
		'default'
	);

	// Address.
	add_meta_box(
		'bloom_client_address_metabox',
		'Address',
		'bloom_client_address_metabox',
		'bloom-client',
		'advanced',
		'default'
	);

	// Emergency.
	add_meta_box(
		'bloom_client_emergency_metabox',
		'Emergency',
		'bloom_client_emergency_metabox',
		'bloom-client',
		'advanced',
		'default'
	);

	// Insurance.
	add_meta_box(
		'bloom_client_insurance_metabox',
		'Insurance',
		'bloom_client_insurance_metabox',
		'bloom-client',
		'advanced',
		'default'
	);

	// Session Quicklinks.
	add_meta_box(
		'bloom_client_session_quicklinks_metabox',
		'Sessions',
		'bloom_client_session_quicklinks_metabox',
		'bloom-client',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'bloom_client_add_meta_boxes' );

/**
 * Client Information metabox.
 * @param $post
 */
function bloom_client_information_metabox( $post ) {
	wp_nonce_field( 'bloom_client_information_metabox', 'bloom_client_information_nonce' );
	$client_first_name  = get_post_meta( $post->ID, 'client_first_name', true );
	$client_middle_name = get_post_meta( $post->ID, 'client_middle_name', true );
	$client_last_name   = get_post_meta( $post->ID, 'client_last_name', true );
	$client_dob         = get_post_meta( $post->ID, 'client_dob', true );
	$client_phone_1     = get_post_meta( $post->ID, 'client_phone_1', true );
	$client_phone_2     = get_post_meta( $post->ID, 'client_phone_2', true );
	$client_email       = get_post_meta( $post->ID, 'client_email', true );
	?>
	<table class="form-table">
		<tr>
			<th scope="row" valign="top"><label for="client_first_name">First Name:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text js-client-title" name="client_first_name" id="client_first_name" size="36" value="<?php echo esc_html( $client_first_name ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="client_middle_name">Middle:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text js-client-title" name="client_middle_name" id="client_middle_name" size="36" value="<?php echo esc_html( $client_middle_name ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="client_last_name">Last Name:<br><span style="font-weight:normal;font-style:italic;">Required</span></label></th>
			<td>
				<div>
					<input type="text" class="regular-text js-client-title" name="client_last_name" id="client_last_name" size="36" value="<?php echo esc_html( $client_last_name ); ?>" autocomplete="off" required/>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="client_phone_1">Phone:<br><span style="font-weight:normal;font-style:italic;">Required</span></label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_phone_1" value="<?php echo esc_html( $client_phone_1 ); ?>" required/>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="client_phone_2">Alternate Phone:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_phone_2" value="<?php echo esc_html( $client_phone_2 ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="client_email">Email:</label></th>
			<td>
				<div>
					<input type="email" class="regular-text" name="client_email" value="<?php echo esc_html( $client_email ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="client_dob">Date of Birth:</label></th>
			<td>
				<div>
					<input type="date" class="regular-text" name="client_dob" value="<?php echo esc_html( $client_dob ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Client Address metabox.
 * @param $post
 */
function bloom_client_address_metabox( $post ) {
	wp_nonce_field( 'bloom_client_address_metabox', 'bloom_client_address_nonce' );
	$client_address_street_1 = get_post_meta( $post->ID, 'client_address_street_1', true );
	$client_address_street_2 = get_post_meta( $post->ID, 'client_address_street_2', true );
	$client_address_city     = get_post_meta( $post->ID, 'client_address_city', true );
	$client_address_state    = get_post_meta( $post->ID, 'client_address_state', true );
	$client_address_zip      = get_post_meta( $post->ID, 'client_address_zip', true );
	if ( empty( $client_address_state ) ) {
		$client_address_state = 'IL';
	} ?>
	<table class="form-table">
	<tr>
		<th scope="row" valign="top"><label for="client_address_street_1">Address 1:</label></th>
		<td>
			<div>
				<input type="text" class="regular-text" name="client_address_street_1" size="36" value="<?php echo esc_html( $client_address_street_1 ); ?>" autocomplete="off" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label for="client_address_street_2">Address 2:</label></th>
		<td>
			<div>
				<input type="text" class="regular-text" name="client_address_street_2" size="36" value="<?php echo esc_html( $client_address_street_2 ); ?>" autocomplete="off" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label for="client_address_city">City:</label></th>
		<td>
			<div>
				<input type="text" class="regular-text" name="client_address_city" size="36" value="<?php echo esc_html( $client_address_city ); ?>" autocomplete="off" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label for="client_address_state">State:</label></th>
		<td>
			<div>
				<select name="client_address_state">
					<option value="AL" <?php selected( $client_address_state, 'AL' ); ?>>Alabama</option>
					<option value="AK" <?php selected( $client_address_state, 'AK' ); ?>>Alaska</option>
					<option value="AZ" <?php selected( $client_address_state, 'AZ' ); ?>>Arizona</option>
					<option value="AR" <?php selected( $client_address_state, 'AR' ); ?>>Arkansas</option>
					<option value="CA" <?php selected( $client_address_state, 'CA' ); ?>>California</option>
					<option value="CO" <?php selected( $client_address_state, 'CO' ); ?>>Colorado</option>
					<option value="CT" <?php selected( $client_address_state, 'CT' ); ?>>Connecticut</option>
					<option value="DE" <?php selected( $client_address_state, 'DE' ); ?>>Delaware</option>
					<option value="DC" <?php selected( $client_address_state, 'DC' ); ?>>District Of Columbia</option>
					<option value="FL" <?php selected( $client_address_state, 'FL' ); ?>>Florida</option>
					<option value="GA" <?php selected( $client_address_state, 'GA' ); ?>>Georgia</option>
					<option value="HI" <?php selected( $client_address_state, 'HI' ); ?>>Hawaii</option>
					<option value="ID" <?php selected( $client_address_state, 'ID' ); ?>>Idaho</option>
					<option value="IL" <?php selected( $client_address_state, 'IL' ); ?>>Illinois</option>
					<option value="IN" <?php selected( $client_address_state, 'IN' ); ?>>Indiana</option>
					<option value="IA" <?php selected( $client_address_state, 'IA' ); ?>>Iowa</option>
					<option value="KS" <?php selected( $client_address_state, 'KS' ); ?>>Kansas</option>
					<option value="KY" <?php selected( $client_address_state, 'KY' ); ?>>Kentucky</option>
					<option value="LA" <?php selected( $client_address_state, 'LA' ); ?>>Louisiana</option>
					<option value="ME" <?php selected( $client_address_state, 'ME' ); ?>>Maine</option>
					<option value="MD" <?php selected( $client_address_state, 'MD' ); ?>>Maryland</option>
					<option value="MA" <?php selected( $client_address_state, 'MA' ); ?>>Massachusetts</option>
					<option value="MI" <?php selected( $client_address_state, 'MI' ); ?>>Michigan</option>
					<option value="MN" <?php selected( $client_address_state, 'MN' ); ?>>Minnesota</option>
					<option value="MS" <?php selected( $client_address_state, 'MS' ); ?>>Mississippi</option>
					<option value="MO" <?php selected( $client_address_state, 'MO' ); ?>>Missouri</option>
					<option value="MT" <?php selected( $client_address_state, 'MT' ); ?>>Montana</option>
					<option value="NE" <?php selected( $client_address_state, 'NE' ); ?>>Nebraska</option>
					<option value="NV" <?php selected( $client_address_state, 'NV' ); ?>>Nevada</option>
					<option value="NH" <?php selected( $client_address_state, 'NH' ); ?>>New Hampshire</option>
					<option value="NJ" <?php selected( $client_address_state, 'NJ' ); ?>>New Jersey</option>
					<option value="NM" <?php selected( $client_address_state, 'NM' ); ?>>New Mexico</option>
					<option value="NY" <?php selected( $client_address_state, 'NY' ); ?>>New York</option>
					<option value="NC" <?php selected( $client_address_state, 'NC' ); ?>>North Carolina</option>
					<option value="ND" <?php selected( $client_address_state, 'ND' ); ?>>North Dakota</option>
					<option value="OH" <?php selected( $client_address_state, 'OH' ); ?>>Ohio</option>
					<option value="OK" <?php selected( $client_address_state, 'OK' ); ?>>Oklahoma</option>
					<option value="OR" <?php selected( $client_address_state, 'OR' ); ?>>Oregon</option>
					<option value="PA" <?php selected( $client_address_state, 'PA' ); ?>>Pennsylvania</option>
					<option value="RI" <?php selected( $client_address_state, 'RI' ); ?>>Rhode Island</option>
					<option value="SC" <?php selected( $client_address_state, 'SC' ); ?>>South Carolina</option>
					<option value="SD" <?php selected( $client_address_state, 'SD' ); ?>>South Dakota</option>
					<option value="TN" <?php selected( $client_address_state, 'TN' ); ?>>Tennessee</option>
					<option value="TX" <?php selected( $client_address_state, 'TX' ); ?>>Texas</option>
					<option value="UT" <?php selected( $client_address_state, 'UT' ); ?>>Utah</option>
					<option value="VT" <?php selected( $client_address_state, 'VT' ); ?>>Vermont</option>
					<option value="VA" <?php selected( $client_address_state, 'VA' ); ?>>Virginia</option>
					<option value="WA" <?php selected( $client_address_state, 'WA' ); ?>>Washington</option>
					<option value="WV" <?php selected( $client_address_state, 'WV' ); ?>>West Virginia</option>
					<option value="WI" <?php selected( $client_address_state, 'WI' ); ?>>Wisconsin</option>
					<option value="WY" <?php selected( $client_address_state, 'WY' ); ?>>Wyoming</option>
				</select>
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label for="client_address_zip">Zip:</label></th>
		<td>
			<div>
				<input type="text" class="regular-text" name="client_address_zip" value="<?php echo esc_html( $client_address_zip ); ?>" autocomplete="off" />
			</div>
		</td>
	</tr>
	</table>
	<?php
}

/**
 * Client Emergency metabox.
 * @param $post
 */
function bloom_client_emergency_metabox( $post ) {
	wp_nonce_field( 'bloom_client_emergency_metabox', 'bloom_client_emergency_nonce' );
	$emergency_name  = get_post_meta( $post->ID, 'emergency_name', true );
	$emergency_phone = get_post_meta( $post->ID, 'emergency_phone', true );
	?>
	<table class="form-table">
		<tr>
			<th scope="row" valign="top"><label for="emergency_name">Emergency Name:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="emergency_name" value="<?php echo esc_html( $emergency_name ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="emergency_phone">Emergency Phone:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="emergency_phone" value="<?php echo esc_html( $emergency_phone ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Client Insurance metabox.
 * @param $post
 */
function bloom_client_insurance_metabox( $post ) {
	wp_nonce_field( 'bloom_client_insurance_metabox', 'bloom_client_insurance_nonce' );
	$insurance_provider               = get_post_meta( $post->ID, 'insurance_provider', true );
	$insurance_group_number           = get_post_meta( $post->ID, 'insurance_group_number', true );
	$insurance_member_id              = get_post_meta( $post->ID, 'insurance_member_id', true );
	$insurance_policy_holder_name     = get_post_meta( $post->ID, 'insurance_policy_holder_name', true );
	$insurance_policy_holder_dob      = get_post_meta( $post->ID, 'insurance_policy_holder_dob', true );
	$insurance_customer_service_phone = get_post_meta( $post->ID, 'insurance_customer_service_phone', true );
	$insurance_benefit_information    = get_post_meta( $post->ID, 'insurance_benefit_information', true );
	?>
	<table class="form-table">
		<tr>
			<th scope="row" valign="top"><label for="insurance_provider">Insurance Provider:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="insurance_provider" value="<?php echo esc_html( $insurance_provider ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="insurance_group_number">Insurance Group #:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="insurance_group_number" value="<?php echo esc_html( $insurance_group_number ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="insurance_member_id">Insurance Member ID:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="insurance_member_id" value="<?php echo esc_html( $insurance_member_id ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="insurance_policy_holder_name">Insurance Policy Holder Name:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="insurance_policy_holder_name" value="<?php echo esc_html( $insurance_policy_holder_name ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="insurance_policy_holder_dob">Insurance Policy Holder Date of Birth:</label></th>
			<td>
				<div>
					<input type="date" class="regular-text" name="insurance_policy_holder_dob" value="<?php echo esc_html( $insurance_policy_holder_dob ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="insurance_customer_service_phone">Insurance Customer Service Phone:</label></th>
			<td>
				<div>
					<input type="text" class="regular-text" name="insurance_customer_service_phone" value="<?php echo esc_html( $insurance_customer_service_phone ); ?>" autocomplete="off" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="insurance_benefit_information">Insurance Benefit Information/Notes:</label></th>
			<td>
				<div>
					<?php wp_editor(
						wp_kses_post( $insurance_benefit_information ),
						'insurance_benefit_information',
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
				</div>
			</td>
		</tr>
	</table>
	<?php
}


/**
 * Client Sessions Quicklinks metabox.
 * @param $post
 */
function bloom_client_session_quicklinks_metabox( $post ) {
	// No nonce needed, this won't contain inputs.
	$client_term = get_term_by( 'name', $post->ID, '_bloom-client' );
	if ( empty( $client_term ) ) {
		echo '<p><em>This client must be saved before Sessions can be associated.</em></p>';
		return;
	}

	$sessions = new WP_Query(
		array(
			'post_type'      => 'bloom-session',
			'post_status'    => 'publish',
			'orderby'        => 'meta_value',
			'meta_key'       => 'session_date',
			'posts_per_page' => 8,
			'no_found_rows'  => true,
			'fields'         => 'ids',
			'tax_query'      => array(
				array(
					'taxonomy' => '_bloom-client',
					'field' => 'name',
					'terms' => $post->ID,
				),
			),
		)
	);

	if ( $sessions->have_posts() ) :
		foreach ( $sessions->posts as $session_id ) :
			$date = get_post_meta( $session_id, 'session_date', true );
			printf(
				'<a href="%1$s">%2$s</a><br>',
				esc_url( get_edit_post_link( $session_id, '&' ) ),
				esc_html( date( 'F j, Y ', strtotime( $date ) ) )
			);
		endforeach;
	else :
		echo '<p><em>No sessions found</em></p>';
	endif;

	printf(
		'<p><a href="%1$s">All sessions</a> | <a href="%2$s">New session</a>',
		esc_url( admin_url( "/edit.php?post_type=bloom-session&_bloom-client={$post->ID}" ) ),
		esc_url( admin_url( "/post-new.php?post_type=bloom-session&bcid={$post->ID}" ) )
	);
}

/**
 * Save client post meta.
 *
 * @param int    $post_id ID of post.
 */
function bloom_client_save_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$sanitized_inputs = array();

	$nonce = filter_input( INPUT_POST, 'bloom_client_information_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( wp_verify_nonce( $nonce, 'bloom_client_information_metabox' ) ) {
		$sanitized_inputs['client_first_name']  = filter_input( INPUT_POST, 'client_first_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_middle_name'] = filter_input( INPUT_POST, 'client_middle_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_last_name']   = filter_input( INPUT_POST, 'client_last_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_dob']         = filter_input( INPUT_POST, 'client_dob', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_phone_1']     = filter_input( INPUT_POST, 'client_phone_1', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_phone_2']     = filter_input( INPUT_POST, 'client_phone_2', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_email']       = filter_input( INPUT_POST, 'client_email', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	}

	$nonce = filter_input( INPUT_POST, 'bloom_client_address_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( wp_verify_nonce( $nonce, 'bloom_client_address_metabox' ) ) {
		$sanitized_inputs['client_address_street_1'] = filter_input( INPUT_POST, 'client_address_street_1', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_address_street_2'] = filter_input( INPUT_POST, 'client_address_street_2', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_address_city']     = filter_input( INPUT_POST, 'client_address_city', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_address_state']    = filter_input( INPUT_POST, 'client_address_state', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['client_address_zip']      = filter_input( INPUT_POST, 'client_address_zip', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	}

	$nonce = filter_input( INPUT_POST, 'bloom_client_emergency_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( wp_verify_nonce( $nonce, 'bloom_client_emergency_metabox' ) ) {
		$sanitized_inputs['emergency_name']  = filter_input( INPUT_POST, 'emergency_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['emergency_phone'] = filter_input( INPUT_POST, 'emergency_phone', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	}

	$nonce = filter_input( INPUT_POST, 'bloom_client_insurance_nonce', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( wp_verify_nonce( $nonce, 'bloom_client_insurance_metabox' ) ) {
		$sanitized_inputs['insurance_provider']               = filter_input( INPUT_POST, 'insurance_provider', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['insurance_group_number']           = filter_input( INPUT_POST, 'insurance_group_number', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['insurance_member_id']              = filter_input( INPUT_POST, 'insurance_member_id', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['insurance_policy_holder_name']     = filter_input( INPUT_POST, 'insurance_policy_holder_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['insurance_policy_holder_dob']      = filter_input( INPUT_POST, 'insurance_policy_holder_dob', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['insurance_customer_service_phone'] = filter_input( INPUT_POST, 'insurance_customer_service_phone', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
		$sanitized_inputs['insurance_benefit_information']    = filter_input( INPUT_POST, 'insurance_benefit_information', FILTER_CALLBACK, array( 'options' => 'wp_kses_post' ) );
	}

	foreach ( $sanitized_inputs as $key => $value ) {
		if ( empty( $value ) ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}

	// If we can't retrieve the client, don't create a term
	$client = get_post( $post_id );
	if ( null === $client || 'Auto Draft' === $client->post_title ) {
		return;
	}

	// If the client term already exists, don't create a term.
	$term = get_term_by( 'name', $post_id, '_bloom-client' );
	if ( false === $term ) {
		// Create the term
		wp_insert_term( $post_id, '_bloom-client' );
	}
}
add_action( 'save_post_bloom-client', 'bloom_client_save_meta' );

/**
 * Remove a term from the shadow taxonomy upon post delete.
 *
 * @uses get_post_type()
 * @uses get_post()
 * @uses get_term_by()
 * @uses wp_delete_term()
 *
 * @const DOING_AUTOSAVE
 *
 * @param int $post_id
 */
function bloom_client_delete_shadow_term( $post_id ) {
	// If we're running an auto-save, don't delete a term
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// If we're not working with a client, don't delete a term
	if ( 'bloom-client' !== get_post_type( $post_id ) ) {
		return;
	}

	// If we can't retrieve the client, don't delete a term
	$client = get_post( $post_id );
	if ( null === $client ) {
		return;
	}

	// If the client term doesn't exist, there's nothing to delete
	$term = get_term_by( 'name', $post_id, '_bloom-client' );
	if ( false !== $term ) {
		// Delete the term
		wp_delete_term( $term->term_id, '_bloom-client' );
	}
}
add_action( 'before_delete_post', 'bloom_client_delete_shadow_term' );

/**
 * Add Extra columns: Last Name. In the order we wish.
 * @param $columns
 *
 * @return mixed
 */
function bloom_client_extra_columns( $columns ) {
	$return_columns = array();
	foreach ( $columns as $key => $value ) {
		$return_columns[ $key ] = $value;
		if ( 'title' === $key ) {
			// Rename "title" to "name" because it makes more sense here.
			$return_columns[ $key ] = 'Name';
			$return_columns['client_last_name'] = 'Last Name';
		}
	}
	return $return_columns;
}
add_filter( 'manage_edit-bloom-client_columns', 'bloom_client_extra_columns' );

/**
 * Fill out extra column content: Last Name.
 * @param $column_name
 * @param $post_id
 */
function bloom_client_last_name_column_content( $column_name, $post_id ) {
	if ( 'client_last_name' !== $column_name ) {
		return;
	}
	$last_name = get_post_meta( $post_id, 'client_last_name', true );
	echo esc_html( $last_name );
}
add_action( 'manage_bloom-client_posts_custom_column', 'bloom_client_last_name_column_content', 10, 2 );

/**
 * Make column sortable: Last Name.
 * @param $columns
 *
 * @return mixed
 */
function bloom_client_last_name_sortable_column( $columns ) {
	$columns['client_last_name'] = 'client_last_name';
	return $columns;
}
add_filter( 'manage_edit-bloom-client_sortable_columns', 'bloom_client_last_name_sortable_column' );

/**
 * Adjust query args to make this column sortable.
 * @param $query
 */
function bloom_client_last_name_sortable_pre_get_post( $query ) {
	if ( ! is_admin() ) {
		return;
	}
	if ( 'client_last_name' === $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', 'client_last_name' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'bloom_client_last_name_sortable_pre_get_post' );

/**
 * Add quick link.
 * @param         $actions
 * @param WP_Post $post
 *
 * @return mixed
 */
function bloom_client_row_actions( $actions, WP_Post $post ) {
	if ( 'bloom-client' !== $post->post_type ) {
		return $actions;
	}

	// Remove quick edit.
	unset( $actions['inline hide-if-no-js'] );

	// Add "Add new Session" link.
	$actions['bloom_client_new_session'] = sprintf(
		'<a href="%1$s">%2$s</a>',
		esc_url( admin_url( "/post-new.php?post_type=bloom-session&bcid={$post->ID}" ) ),
		'New Session'
	);
	return $actions;
}
add_filter( 'post_row_actions', 'bloom_client_row_actions', 10, 2 );
