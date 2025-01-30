<?php

if ( ! function_exists( 'ehri_add_orcid_field' ) ) {
	function ehri_add_orcid_field( $user ) {
		?>
		<h3>Additional Information</h3>
		<table class="form-table user-orcid-info">
			<tr>
				<th><label for="orcid">ORCID</label></th>
				<td>
					<input type="text" name="orcid" id="orcid"
						   placeholder="0000-0000-0000-0000"
						   pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}"
						   title="Please enter a valid ORCID identifier, e.g. 1234-5678-9012-3456"
						   value="<?php echo esc_attr( get_user_meta( $user->ID, 'orcid', true ) ); ?>"
						   class="regular-text"/>
					<p class="description">Please enter an ORCID identifier</p>
				</td>
			</tr>
		</table>
		<?php
	}
}

// Add ORCID field to user profile page
add_action( 'show_user_profile', 'ehri_add_orcid_field' );
add_action( 'edit_user_profile', 'ehri_add_orcid_field' );

// User Settings Errors
if ( ! function_exists( 'ehri_plugin_user_settings_errors' ) ) {
	function ehri_plugin_user_settings_errors( $errors ) {
		$orcid = $_POST['orcid'];
		if ( ! empty( $orcid ) && ! preg_match( '/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/', $orcid ) ) {
			$errors->add( 'ehri-orcid-error', '<strong>ERROR:</strong> ORCID must be in the format 0000-0000-0000-0000' );
		}
		return $errors;
	}
}
add_filter( 'user_profile_update_errors', 'ehri_plugin_user_settings_errors' );

if ( ! function_exists( 'save_orcid_field' ) ) {
	function save_orcid_field( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		$orcid = $_POST['orcid'];
		// Validate the ORCID
		if ( ! empty( $orcid ) && ! preg_match( '/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/', $orcid ) ) {
			// Show an error
			return false;
		}
		update_user_meta( $user_id, 'orcid', $orcid );
	}
}

// Save the field value
add_action( 'personal_options_update', 'save_orcid_field' );
add_action( 'edit_user_profile_update', 'save_orcid_field' );
