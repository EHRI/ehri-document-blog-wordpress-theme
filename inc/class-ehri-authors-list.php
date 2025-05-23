<?php
/**
 * Authors list widget.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_register_authors_list_widget' ) ) {
	/**
	 * Register widget.
	 *
	 * @return void
	 */
	function ehri_register_authors_list_widget() {
		register_widget( 'Ehri_Authors_List' );
	}
}

add_action( 'widgets_init', 'ehri_register_authors_list_widget' );

if ( ! class_exists( 'Ehri_Authors_List' ) ) {
	/**
	 * Author list widget.
	 */
	class Ehri_Authors_List extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'Ehri_Authors_List',
				__( 'Authors List [EHRI]', ' ehri_widget_domain' ),
				array( 'description' => __( 'Displays a list of authors', 'ehri_widget_domain' ) )
			);
		}

		/**
		 * Initialise author list widget.
		 *
		 * @param array $args widget arguments.
		 * @param array $instance instance settings.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			echo $args['before_title'] . $title . $args['after_title'];
			?>
			<ul class="authors-list">
				<?php
				echo wp_list_authors(
					array(
						'style'   => 'list',
						'orderby' => 'post_count',
						'order'   => 'DESC',
					)
				);
				?>
			</ul>
			<?php
			echo $args['after_widget'];
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
				$title = __( 'Authors', 'ehri_widget_domain' );
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
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


