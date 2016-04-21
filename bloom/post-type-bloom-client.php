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
		'_bloom-client',
		array(
			'labels'      => array(
				'name'               => 'Clients',
				'singular_name'      => 'Client',
				'add_new'            => 'Add Client',
				'search_items'       => 'Search Clients',
				'all_items'          => 'All Clients',
				'edit_item'          => 'Edit Client',
				'update_item'        => 'Update Client',
				'add_new_item'       => 'Add Client',
				'new_item_name'      => 'New Client',
				'not_found'          => 'No clients found',
				'not_found_in_trash' => 'No clients found in Trash',
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'clients' ),
			'menu_icon'   => 'dashicons-heart',
			'supports'    => array( 'title', 'editor' ),
		)
	);
}
add_action( 'init', 'bloom_register_client_post_type' );

/**
 * Adds metabox(es) for Post.
 */
function bloom_client_add_meta_boxes() {
	// Thumbnail Image. Goes in Sidebar.
	add_meta_box(
		'slc_thumbnail_metabox',
		'',
		'bloom_client_render_metabox',
		'bloom-client'
	);
}
add_action( 'add_meta_boxes', 'bloom_client_add_meta_boxes' );

function bloom_client_render_metabox( $post_id ) {
	$client_first_name  = get_post_meta( $post_id, 'client_first_name', true );
	$client_middle_name = get_post_meta( $post_id, 'client_middle_name', true );
	$client_last_name   = get_post_meta( $post_id, 'client_last_name', true );

	$client_address_street_1 = get_post_meta( $post_id, 'client_address_street_1', true );
	$client_address_street_2 = get_post_meta( $post_id, 'client_address_street_2', true );
	$client_address_city     = get_post_meta( $post_id, 'client_address_city', true );
	$client_address_state    = get_post_meta( $post_id, 'client_address_state', true );
	$client_address_zip      = get_post_meta( $post_id, 'client_address_zip', true );
	if ( empty( $client_address_state ) ) {
		$client_address_state = 'IL';
	}

	$client_dob     = get_post_meta( $post_id, 'client_dob', true );
	$client_phone_1 = get_post_meta( $post_id, 'client_phone_1', true );
	$client_phone_2 = get_post_meta( $post_id, 'client_phone_2', true );
	$client_email   = get_post_meta( $post_id, 'client_email', true );

	$emergency_name  = get_post_meta( $post_id, 'emergency_name', true );
	$emergency_phone = get_post_meta( $post_id, 'emergency_phone', true );

	$insurance_provider               = get_post_meta( $post_id, 'insurance_provider', true );
	$insurance_group_number           = get_post_meta( $post_id, 'insurance_group_number', true );
	$insurance_member_id              = get_post_meta( $post_id, 'insurance_member_id', true );
	$insurance_policy_holder_name     = get_post_meta( $post_id, 'insurance_policy_holder_name', true );
	$insurance_policy_holder_dob      = get_post_meta( $post_id, 'insurance_policy_holder_dob', true );
	$insurance_customer_service_phone = get_post_meta( $post_id, 'insurance_customer_service_phone', true );
	$insurance_benefit_information    = get_post_meta( $post_id, 'insurance_benefit_information', true );
	?>

	<tr><td colspan="2"><div><hr /></div></td></tr>

	<!-- Information -->
	<tr><th scope="row" valign="top" colspan="2"><div><h2>Information</h2></div></th></tr>
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

	<!-- Address -->
	<tr><th scope="row" valign="top" colspan="2"><div><h2>Address</h2></div></th></tr>
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

	<!-- Emergency -->
	<tr><th scope="row" valign="top" colspan="2"><div><h2>Emergency</h2></div></th></tr>
	<tr>
		<th scope="row" valign="top">Emergency Name:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="emergency_name" value="<?php echo esc_html( $emergency_name ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Emergency Phone:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="emergency_phone" value="<?php echo esc_html( $emergency_phone ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr><td colspan="2"><div><hr /></div></td></tr>

	<!-- Insurance -->
	<tr><th scope="row" valign="top" colspan="2"><div><h2>Insurance</h2></div></th></tr>
	<tr>
		<th scope="row" valign="top">Insurance Provider:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="insurance_provider" value="<?php echo esc_html( $insurance_provider ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Insurance Group #:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="insurance_group_number" value="<?php echo esc_html( $insurance_group_number ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Insurance Member ID:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="insurance_member_id" value="<?php echo esc_html( $insurance_member_id ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Insurance Policy Holder Name:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="insurance_policy_holder_name" value="<?php echo esc_html( $insurance_policy_holder_name ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Insurance Policy Holder Date of Birth:</th>
		<td>
			<div>
				<input type="date" class="regular-text" name="insurance_policy_holder_dob" value="<?php echo esc_html( $insurance_policy_holder_dob ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Insurance Customer Service Phone:</th>
		<td>
			<div>
				<input type="text" class="regular-text" name="insurance_customer_service_phone" value="<?php echo esc_html( $insurance_customer_service_phone ); ?>" placeholder="" />
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">Insurance Benefit Information:</th>
		<td>
			<div>
				<textarea cols="80" rows="10" name="insurance_benefit_information"><?php echo esc_html( $insurance_benefit_information ); ?></textarea>
			</div>
		</td>
	</tr>
	<tr><td colspan="2"><div><hr /></div></td></tr>
	<?php
}
