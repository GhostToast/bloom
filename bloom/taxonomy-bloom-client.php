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
			//'meta_box_cb'  => 'bloom_client_metabox',
		)
	);
}
add_action( 'init', 'bloom_register_client' );

/**
 * Edit client meta fields.
 */
function bloom_client_edit_term_meta_fields() {
	$screen = get_current_screen();

	$term_id = filter_input( INPUT_GET, 'tag_ID', FILTER_CALLBACK, array( 'options' => 'absint' ) );

	if ( ! empty( $screen->taxonomy ) && 'bloom-client' === $screen->taxonomy && ! empty( $term_id ) ) :
		$client_first_name = get_term_meta( $term_id, 'client_first_name', true );
		$client_middle_name = get_term_meta( $term_id, 'client_middle_name', true );
		$client_last_name = get_term_meta( $term_id, 'client_last_name', true );

		$client_address_street_1 = get_term_meta( $term_id, 'client_address_street_1', true );
		$client_address_street_2 = get_term_meta( $term_id, 'client_address_street_2', true );
		$client_address_city = get_term_meta( $term_id, 'client_address_street_city', true );
		$client_address_state = get_term_meta( $term_id, 'client_address_street_state', true );
		if ( empty( $client_address_state ) ) {
			$client_address_state = 'IL';
		}
		$client_address_zip = get_term_meta( $term_id, 'client_address_street_zip', true );

		$client_dob = get_term_meta( $term_id, 'client_dob', true );
		$client_phone_1 = get_term_meta( $term_id, 'client_phone_1', true );
		$client_phone_2 = get_term_meta( $term_id, 'client_phone_2', true );
		$client_email = get_term_meta( $term_id, 'client_email', true );

		$emergency_name = get_term_meta( $term_id, 'emergency_name', true );
		$emergency_phone = get_term_meta( $term_id, 'emergency_phone', true );

		$insurance_provider = get_term_meta( $term_id, 'insurance_provider', true );
		$insurance_group_number = get_term_meta( $term_id, 'insurance_group_number', true );
		$insurance_member_id = get_term_meta( $term_id, 'insurance_member_id', true );
		$insurance_policy_holder_name = get_term_meta( $term_id, 'insurance_policy_holder_name', true );
		$insurance_policy_holder_dob = get_term_meta( $term_id, 'insurance_policy_holder_dob', true );
		$insurance_customer_service_phone = get_term_meta( $term_id, 'insurance_customer_service_phone', true );
		$insurance_benefit_information = get_term_meta( $term_id, 'insurance_benefit_information', true );
		?>

		<!-- Client Name -->
		<tr><td colspan="2"><div><hr /></div></td></tr>
		<tr>
			<th scope="row" valign="top">First Name:</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_first_name" size="36" value="<?php echo esc_html( $client_first_name ); ?>" placeholder="John" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">Middle:</th>
			<td>
				<div>
					<input type="text" class="small-text" name="client_middle_name" size="36" value="<?php echo esc_html( $client_middle_name ); ?>" placeholder="" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">Last Name (required):</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_last_name" size="36" value="<?php echo esc_html( $client_last_name ); ?>" placeholder="Smith" required/>
				</div>
			</td>
		</tr>
		<tr><td colspan="2"><div><hr /></div></td></tr>

		<!-- Address -->
		<tr>
			<th scope="row" valign="top">Address 1:</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_address_street_1" size="36" value="<?php echo esc_html( $client_address_street_1 ); ?>" placeholder="123 Elm Street" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">Address 2:</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_address_street_2" size="36" value="<?php echo esc_html( $client_address_street_2 ); ?>" placeholder="" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">City:</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_address_city" size="36" value="<?php echo esc_html( $client_address_city ); ?>" placeholder="Sycamore" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">State:</th>
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
			<th scope="row" valign="top">Zip:</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_address_zip" value="<?php echo esc_html( $client_address_zip ); ?>" placeholder="60178" />
				</div>
			</td>
		</tr>
		<tr><td colspan="2"><div><hr /></div></td></tr>

		<!-- Phone, DOB -->
		<tr>
			<th scope="row" valign="top">Date of Birth:</th>
			<td>
				<div>
					<input type="date" class="regular-text" name="client_dob" value="<?php echo esc_html( $client_dob ); ?>" placeholder="" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">Phone (required):</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_phone_1" value="<?php echo esc_html( $client_phone_1 ); ?>" placeholder="" required/>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">Alternate Phone:</th>
			<td>
				<div>
					<input type="text" class="regular-text" name="client_phone_2" value="<?php echo esc_html( $client_phone_2 ); ?>" placeholder="" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top">Email:</th>
			<td>
				<div>
					<input type="email" class="regular-text" name="client_email" value="<?php echo esc_html( $client_email ); ?>" placeholder="" />
				</div>
			</td>
		</tr>

		<tr><td colspan="2"><div><hr /></div></td></tr>

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
	$nonce = filter_input( INPUT_POST, '_wpnonce_client', FILTER_CALLBACK, array( 'options' => 'sanitize_key' ) );
	if ( ! wp_verify_nonce( $nonce, 'custom_client_meta' ) ) {
		return;
	}

	$client_icon_id = filter_input( INPUT_POST, 'client_icon_id', FILTER_CALLBACK, array( 'options' => 'absint' ) );
	if ( empty( $client_icon_id ) ) {
		delete_term_meta( $term_id, 'client_icon_id' );
	} else {
		update_term_meta( $term_id, 'client_icon_id', $client_icon_id );
	}

	$client_singular_name = filter_input( INPUT_POST, 'client_singular_name', FILTER_CALLBACK, array( 'options' => 'sanitize_text_field' ) );
	if ( empty( $client_singular_name ) ) {
		delete_term_meta( $term_id, 'client_singular_name' );
	} else {
		update_term_meta( $term_id, 'client_singular_name', $client_singular_name );
	}

	$client_image_id = filter_input( INPUT_POST, 'client_image_id', FILTER_CALLBACK, array( 'options' => 'absint' ) );
	if ( empty( $client_image_id ) ) {
		delete_term_meta( $term_id, 'client_image_id' );
	} else {
		update_term_meta( $term_id, 'client_image_id', $client_image_id );
	}

	$client_experts = sanitize_text_field( filter_input( INPUT_POST, 'client_experts', FILTER_CALLBACK, array( 'options' => 'wp_unslash' ) ) );
	if ( empty( $client_experts ) ) {
		delete_term_meta( $term_id, 'client_experts' );
	} else {
		update_term_meta( $term_id, 'client_experts', $client_experts );
	}
}
add_action( 'created_bloom-client', 'bloom_client_save_meta', 10, 2 );
add_action( 'edit_bloom-client', 'bloom_client_save_meta', 10, 2 );
