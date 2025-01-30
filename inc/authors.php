<?php

// Add ORCID field to user profile page
add_action( 'show_user_profile', 'add_orcid_field' );
add_action( 'edit_user_profile', 'add_orcid_field' );

if ( ! function_exists( 'add_orcid_field' ) ) {
	function add_orcid_field( $user ) {
		?>
		<h3>Additional Information</h3>
		<table class="form-table">
			<tr>
				<th><label for="orcid">ORCID</label></th>
				<td>
					<input type="text" name="orcid" id="orcid"
						   value="<?php echo esc_attr( get_user_meta( $user->ID, 'orcid', true ) ); ?>"
						   class="regular-text"/>
					<p class="description">Please enter your ORCID identifier</p>
				</td>
			</tr>
		</table>
		<?php
	}
}

// Save the field value
add_action( 'personal_options_update', 'save_orcid_field' );
add_action( 'edit_user_profile_update', 'save_orcid_field' );

if (!function_exists('save_orcid_field')) {
	function save_orcid_field( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}
		update_user_meta( $user_id, 'orcid', $_POST['orcid'] );
	}
}
