<?php
/**
 * Widget to display a list of links under a post.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_register_link_list_widget' ) ) {
	/**
	 * Register link list widget.
	 *
	 * @return void
	 */
	function ehri_register_link_list_widget() {
		register_widget( 'Ehri_Link_List' );
	}
}

add_action( 'widgets_init', 'ehri_register_link_list_widget' );

if ( ! class_exists( 'Ehri_Link_List' ) ) {
	/**
	 * Widget which displays a link of links found within a posts in a list.
	 */
	class Ehri_Link_List extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'Ehri_Link_List',
				__( 'Link List [EHRI]', ' ehri_widget_domain' ),
				array( 'description' => __( 'Displays a list of links found in the post content with a matching base URL', 'ehri_widget_domain' ) )
			);
		}

		/**
		 * Get references to external content in this post.
		 * External links are defined in the 'external_links' metadata custom field
		 * and consist of one link per line in a "Link Text=URL" format.
		 *
		 * @param int $post_id the ID of the current WordPress post.
		 *
		 * @return array an array of two-element text->url pairs.
		 */
		private function get_post_external_refs( int $post_id ): array {
			$urls      = array();
			$ext_links = get_post_meta( $post_id, 'external_links' );
			if ( $ext_links ) {
				foreach ( $ext_links as $field ) {
					$links = preg_split( '/\r\n|\r|\n/', $field );
					if ( $links ) {
						foreach ( $links as $link ) {
							$name_url = preg_split( '/\s*=\s*/', $link, 2, PREG_SPLIT_NO_EMPTY );
							if ( ( $name_url ) && count( $name_url ) === 2 && filter_var( $name_url[1], FILTER_VALIDATE_URL ) ) {
								$urls[] = $name_url;
							}
						}
					}
				}
			}

			return $urls;
		}

		/**
		 * Render the widget.
		 *
		 * @param array $args widget arguments.
		 * @param array $instance instance settings.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
			$urls = $this->get_post_external_refs( get_queried_object_id() );
			if ( $urls ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
				echo $args['before_widget'];
				echo $args['before_title'] . $title . $args['after_title'];
				?>
				<ul class="link-list">
					<?php foreach ( $urls as list( $text, $url ) ) : ?>
						<li><a target="_blank" rel="noopener" href="<?php echo $url; ?>"><?php echo $text; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<?php
				echo $args['after_widget'];
			}
		}

		/**
		 * Render widget form.
		 *
		 * @param array $instance instance settings.
		 *
		 * @return void
		 */
		public function form( $instance ) {
			$title   = isset( $instance['title'] )
				? $instance['title']
				: __( 'Linked documents', 'ehri_widget_domain' );
			$baseurl = isset( $instance['baseurl'] )
				? $instance['baseurl']
				: 'http://www.example.com/';
			?>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ehri' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'baseurl' ) ); ?>"><?php esc_html_e( 'Base URL:', 'ehri' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'baseurl' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'baseurl' ) ); ?>" type="text"
					value="<?php echo esc_attr( $baseurl ); ?>"/>
			</p>
			<?php
		}

		/**
		 * Update the widget.
		 *
		 * @param array $new_instance new settings.
		 * @param array $old_instance old settings.
		 *
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance            = array();
			$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
			$instance['baseurl'] = ( ! empty( $new_instance['baseurl'] ) ) ? wp_strip_all_tags( $new_instance['baseurl'] ) : '';

			return $instance;
		}
	}
}


