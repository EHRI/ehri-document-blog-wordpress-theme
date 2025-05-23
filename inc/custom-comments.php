<?php
/**
 * Comment layout.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Comments form.
add_filter( 'comment_form_default_fields', 'ehri_bootstrap_comment_form_default_fields' );

/**
 * Creates the comments form.
 *
 * @param string $fields Form fields.
 *
 * @return array
 */

if ( ! function_exists( 'ehri_bootstrap_comment_form_default_fields' ) ) {

	/**
	 * Creates a form field for a comment.
	 *
	 * @param array $fields an array of fields.
	 * @return string[] an array of HTML strings.
	 */
	function ehri_bootstrap_comment_form_default_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true' placeholder='required' required" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
		return array(
			'author'  => '<div class="comment-form-meta row"><div class="form-group col-md-4 comment-form-author"><label for="author">' . __(
				'Name:',
				'understrap'
			) . '</label> ' .
						'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . '></div>',
			'email'   => '<div class="form-group col-md-4 comment-form-email"><label for="email">' . __(
				'Email:',
				'understrap'
			) . '</label> ' .
						'<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . '></div>',
			'url'     => '<div class="form-group col-md-4 comment-form-url"><label for="url">' . __(
				'Website:',
				'understrap'
			) . '</label> ' .
						'<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30"></div></div>',
			'cookies' => '<div class="form-group form-check comment-form-cookies-consent"><input class="form-check-input" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
				'<label class="form-check-label" for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment', 'understrap' ) . '</label></div>',
		);
	}
}

add_filter( 'comment_form_defaults', 'ehri_bootstrap_comment_form' );

/**
 * Builds the form.
 *
 * @param string $args Arguments for form's fields.
 *
 * @return mixed
 */

if ( ! function_exists( 'ehri_bootstrap_comment_form' ) ) {

	/**
	 * A filter function returning the comment form textarea.
	 *
	 * @param array $args filter args.
	 * @return mixed
	 */
	function ehri_bootstrap_comment_form( $args ) {
		$args['comment_field'] = '<div class="form-group comment-form-comment">
			<label for="comment">' . _x( 'Message:', 'noun', 'understrap' ) . '</label>
			<textarea class="form-control" placeholder="required" id="comment" name="comment" aria-required="true" cols="45" rows="8"></textarea>
	    </div>';
		return $args;
	}
}

add_filter( 'comment_form_fields', 'ehri_bootstrap_comment_form_fields' );

if ( ! function_exists( 'ehri_bootstrap_comment_form_fields' ) ) {

	/**
	 * Filter for returning the fields required in the comments form.
	 *
	 * @param array $args filter args.
	 * @return array an array of fields.
	 */
	function ehri_bootstrap_comment_form_fields( $args ) {
		return array(
			'author'  => $args['author'],
			'email'   => $args['email'],
			'url'     => $args['url'],
			'comment' => $args['comment'],
			'cookies' => $args['cookies'],
		);
	}
}
