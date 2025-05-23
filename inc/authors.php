<?php
/**
 * Additional functionality for post authors.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_validate_orcid' ) ) {
	/**
	 * Validate the format of an ORCID string.
	 *
	 * @param string $orcid the ORCID.
	 *
	 * @return bool whether the ORCID has a valid format.
	 */
	function ehri_validate_orcid( string $orcid ): bool {
		return preg_match( '/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/', $orcid );
	}
}

if ( ! function_exists( 'ehri_add_orcid_field' ) ) {
	/**
	 * Display a form for the user's ORCID.
	 *
	 * @param WP_User $user the user object.
	 */
	function ehri_add_orcid_field( $user ) {
		?>
		<h3><?php esc_html_e( 'Additional Information', 'ehri' ); ?></h3>
		<table class="form-table user-orcid-info">
			<tr>
				<th><label for="orcid">ORCID</label></th>
				<td>
					<input type="text" name="orcid" id="orcid"
						placeholder="0000-0000-0000-0000"
						pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}"
						title="<?php esc_attr_e( 'Please enter a valid ORCID identifier, e.g. 1234-5678-9012-3456', 'ehri' ); ?>"
						value="<?php echo esc_attr( get_user_meta( $user->ID, 'orcid', true ) ); ?>"
						class="regular-text"/>
					<p class="description">
						<?php esc_html_e( 'Please enter an ORCID identifier', 'ehri' ); ?>
					</p>
				</td>
			</tr>
		</table>
		<?php
		// Generate the nonce field.
		wp_nonce_field( 'ehri_user_profile_update', 'ehri_user_profile_nonce_field' );
	}
}

// Add ORCID field to user profile page.
add_action( 'show_user_profile', 'ehri_add_orcid_field' );
add_action( 'edit_user_profile', 'ehri_add_orcid_field' );

if ( ! function_exists( 'ehri_plugin_user_settings_errors' ) ) {
	/**
	 * Filter function to check the format of a user's ORCID.
	 *
	 * @param WP_Error $errors form errors.
	 * @return WP_Error additional form errors.
	 */
	function ehri_plugin_user_settings_errors( WP_Error $errors ): WP_Error {
		if ( ! isset( $_POST['ehri_user_profile_nonce_field'] ) || ! check_admin_referer( 'ehri_user_profile_update', 'ehri_user_profile_nonce_field' ) ) {
			// Nonce verification failed. Die or handle the error gracefully.
			wp_die( 'Security check failed. Please try again.' );
		}

		if ( ! empty( $_POST['orcid'] ) ) {
			$orcid = sanitize_text_field( wp_unslash( $_POST['orcid'] ) );
			if ( ! ehri_validate_orcid( $orcid ) ) {
				$errors->add(
					'ehri-orcid-error',
					'<strong>'
					. esc_html__( 'Error', 'ehri' )
					. ': </strong>'
					. esc_html__( 'ORCID must be in the format 0000-0000-0000-0000', 'ehri' )
				);
			}
		}

		return $errors;
	}
}
add_filter( 'user_profile_update_errors', 'ehri_plugin_user_settings_errors' );

if ( ! function_exists( 'save_orcid_field' ) ) {
	/**
	 * Filter function to save a user's ORCID info.
	 *
	 * @param int $user_id the user's ID.
	 * @return bool on success or failure.
	 */
	function save_orcid_field( int $user_id ): bool {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		if ( ! isset( $_POST['ehri_user_profile_nonce_field'] ) || ! check_admin_referer( 'ehri_user_profile_update', 'ehri_user_profile_nonce_field' ) ) {
			// Nonce verification failed. Die or handle the error gracefully.
			wp_die( 'Security check failed. Please try again.' );
		}

		if ( ! empty( $_POST['orcid'] ) ) {
			$orcid = sanitize_text_field( wp_unslash( $_POST['orcid'] ) );
			// Validate the ORCID.
			if ( ! ehri_validate_orcid( $orcid ) ) {
				// Show an error.
				return false;
			}
			update_user_meta( $user_id, 'orcid', $orcid );
		} else {
			delete_user_meta( $user_id, 'orcid' );
		}

		return true;
	}
}

add_action( 'personal_options_update', 'save_orcid_field' );
add_action( 'edit_user_profile_update', 'save_orcid_field' );
