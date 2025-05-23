<?php
/**
 * Post tags widget.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_register_post_tags_widget' ) ) {
	/**
	 * Register post tags widget.
	 *
	 * @return void
	 */
	function ehri_register_post_tags_widget() {
		register_widget( 'Ehri_Post_Tags' );
	}
}

add_action( 'widgets_init', 'ehri_register_post_tags_widget' );

if ( ! class_exists( 'Ehri_Post_Tags' ) ) {
	/**
	 * Widget that displays a list of post tags.
	 */
	class Ehri_Post_Tags extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'Ehri_Post_Tags',
				__( 'Post Tags [EHRI]', ' ehri_widget_domain' ),
				array( 'description' => __( 'Displays tags for the current post', 'ehri_widget_domain' ) )
			);
		}

		/**
		 * Initialise post tags.
		 *
		 * @param array $args widget arguments.
		 * @param array $instance instance settings.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
			$post_id = get_queried_object_id();
			if ( $post_id ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
				echo $args['before_widget'];
				$tags = trim( get_the_tag_list( '', '', '', $post_id ) );
				if ( $tags ) {
					if ( ! empty( $title ) ) {
						echo $args['before_title'] . $title . $args['after_title'];
					}
					echo $tags;
				}
				echo $args['after_widget'];
			}
		}

		/**
		 * Display the widget form.
		 *
		 * @param array $instance instance settings.
		 *
		 * @return void
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = __( 'Tags', 'ehri_widget_domain' );
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ehri' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<?php
		}

		/**
		 * Update this widget.
		 *
		 * @param array $new_instance new settings.
		 * @param array $old_instance old settings.
		 *
		 * @return array the new settings (unchanged).
		 */
		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';

			return $instance;
		}
	}
}

