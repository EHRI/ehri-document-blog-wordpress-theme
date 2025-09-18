<?php
/**
 * Display metadata for blog posts.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_register_post_meta_widget' ) ) {
	/**
	 * Register post metadata widget.
	 *
	 * @return void
	 */
	function ehri_register_post_meta_widget() {
		register_widget( 'Ehri_Post_Metadata' );
	}
}

add_action( 'widgets_init', 'ehri_register_post_meta_widget' );

if ( ! class_exists( 'Ehri_Post_Metadata' ) ) {
	/**
	 * Post metadata widget.
	 */
	class Ehri_Post_Metadata extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'Ehri_Post_Metadata',
				__( 'Post Metadata [EHRI]', ' ehri_widget_domain' ),
				array( 'description' => __( 'Displays post author and publication date', 'ehri_widget_domain' ) )
			);
		}

		/**
		 * Post metadata widget.
		 *
		 * @param array $args display position arguments.
		 * @param array $instance widget settings.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
			$post_id = get_queried_object_id();
			if ( $post_id ) {
				$title = apply_filters( 'widget_title', $instance['title'] ?? '' );
				echo $args['before_widget'];
				if ( ! empty( $title ) ) {
					echo $args['before_title'] . $title . $args['after_title'];
				}

				if ( function_exists( 'coauthors_posts_links' ) && function_exists( 'get_coauthors' ) ) {
					echo _n( 'Author', 'Authors', count( get_coauthors() ) ) . ': ';
					coauthors_posts_links();
				} else {
					echo __( 'Author' ) . ': ';
					the_author_posts_link();
				}
				echo '<br/>';
				echo __( 'Published' ) . ': ' . get_the_date();
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


