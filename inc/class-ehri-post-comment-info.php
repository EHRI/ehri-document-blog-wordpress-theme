<?php
/**
 * EHRI post comment info widget.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_register_comment_info_widget' ) ) {
	/**
	 * Register the post comment widget.
	 *
	 * @return void
	 */
	function ehri_register_comment_info_widget() {
		register_widget( 'Ehri_Post_Comment_Info' );
	}
}

add_action( 'widgets_init', 'ehri_register_comment_info_widget' );

if ( ! class_exists( 'Ehri_Post_Comment_Info' ) ) {
	/**
	 * Post comment info widget.
	 */
	class Ehri_Post_Comment_Info extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'Ehri_Post_Comment_Info',
				__( 'Post Comment Info [EHRI]', ' ehri_widget_domain' ),
				array( 'description' => __( 'Displays comment count and a link to the reply section', 'ehri_widget_domain' ) )
			);
		}

		/**
		 * Set up post comment info widget.
		 *
		 * @param array $args widget arguments.
		 * @param array $instance widget instance parameters.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
			$post_id = get_queried_object_id();
			if ( $post_id ) {
				$title  = apply_filters( 'widget_title', $instance['title'] ?? '' );
				$number = get_comments_number( $post_id );
				echo $args['before_widget'];
				if ( ! empty( $title ) ) {
					echo $args['before_title'] . $title . $args['after_title'];
				}
				if ( $number > 0 ) {
					echo '<i class="material-icons md-14" aria-hidden="true">mode_comment</i>';
					echo '<span id="post-comment-number">';
					printf(
					// translators: the placeholder here are for the 1) a single comment and 2) zero or multiple comments.
						_nx(
							'%1$s Comment',
							'%1$s Comments',
							$number,
							'comments title'
						),
						number_format_i18n( $number )
					);
					echo '</span>';
				}
				echo '<a class="btn btn-primary" href="#respond">Leave a reply</a>';
				echo $args['after_widget'];
			}
		}

		/**
		 * The default form (no form).
		 *
		 * @param array $instance widget settings.
		 *
		 * @return string the default string.
		 */
		public function form( $instance ): string {
			return 'noform';
		}

		/**
		 * Update this widget.
		 *
		 * @param array $new_instance new settings.
		 * @param array $old_instance old settings.
		 *
		 * @return array the new settings (unchanged).
		 */
		public function update( $new_instance, $old_instance ): array {
			return $new_instance;
		}
	}
}

