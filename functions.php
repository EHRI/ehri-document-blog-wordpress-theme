<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$understrap_includes = array(
	'/theme-settings.php',                          // Initialize theme default settings.
	'/setup.php',                                   // Theme setup and custom theme supports.
	'/widgets.php',                                 // Register widget area.
	'/enqueue.php',                                 // Enqueue scripts and styles.
	'/template-tags.php',                           // Custom template tags for this theme.
	'/pagination.php',                              // Custom pagination for this theme.
	'/hooks.php',                                   // Custom hooks.
	'/extras.php',                                  // Custom functions that act independently of the theme templates.
	'/customizer.php',                              // Customizer additions.
	'/custom-comments.php',                         // Custom Comments file.
	'/class-ehri-post-metadata.php',                // Load post metadata widget.
	'/class-ehri-post-comment-info.php',            // Load post comment info widget.
	'/class-ehri-post-categories.php',              // Load post categories widget.
	'/class-ehri-post-tags.php',                     // Load post tags widget.
	'/class-ehri-author-info.php',                  // Load author info widget.
	'/class-ehri-authors-list.php',                 // Load authors list widget.
	'/class-ehri-link-list.php',                    // Load link list widget.
	'/class-ehri-walker-comment.php',               // Load custom WordPress nav walker.
	'/class-understrap-wp-bootstrap-navwalker.php', // Load custom WordPress nav walker.
	'/editor.php',                                  // Load Editor functions.
	'/authors.php',                                 // Customisation of author information.
	'/actions.php',                                 // Custom ajax actions.
);

foreach ( $understrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
