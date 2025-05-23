<?php
/**
 * Author info widget.
 *
 * @package ehri-wp-theme
 */

if ( ! function_exists( 'ehri_register_author_info_widget' ) ) {
	/**
	 * Register author info widget.
	 *
	 * @return void
	 */
	function ehri_register_author_info_widget() {
		register_widget( 'Ehri_Author_Info' );
	}
}

add_action( 'widgets_init', 'ehri_register_author_info_widget' );

if ( ! class_exists( 'Ehri_Author_Info' ) ) {
	/**
	 * Author info widget.
	 */
	class Ehri_Author_Info extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'Ehri_Author_Info',
				__( 'Author Info [EHRI]', ' ehri_widget_domain' ),
				array( 'description' => __( 'Displays biographical info about the current authors', 'ehri_widget_domain' ) )
			);
		}

		/**
		 * Initialise author info widget.
		 *
		 * @param array $args widget arguments.
		 * @param array $instance instance settings.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
			$current_author = ehri_get_current_archive_author();
			if ( $current_author ) {
				$title = apply_filters( 'widget_title', __( 'About ', 'ehri' ) . $current_author->display_name );
				echo $args['before_widget'];
				echo $args['before_title'] . $title . $args['after_title'];
				?>
				<div class="author-info">
					<?php if ( ! empty( $current_author->user_description ) ) : ?>
						<p><?php echo esc_html( $current_author->user_description ); ?></p>
					<?php endif; ?>
					<?php if ( ehri_has_gravitar( $current_author ) ) : ?>
						<?php echo get_avatar( $current_author->ID ); ?>
					<?php endif; ?>
					<?php $website = get_the_author_meta( 'user_url', $current_author->ID ); ?>
					<?php if ( ! empty( $website ) ) : ?>
						<p class="author-website">
							<a href="<?php echo esc_url( $website ); ?>">
								<i class="fa-solid fa-globe"></i>
								<?php echo esc_html( $website ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php $orcid = get_the_author_meta( 'orcid', $current_author->ID ); ?>
					<?php if ( ! empty( $orcid ) ) : ?>
						<div class="author-orcid">
							<a target="_blank" href="https://orcid.org/<?php echo esc_attr( $orcid ); ?>"
								title="<?php echo esc_attr__( 'View ORCID record', 'ehri' ); ?>"
								aria-label="<?php echo esc_attr__( 'View ORCID record', 'ehri' ); ?>">
									<img src="<?php echo esc_url( get_theme_file_uri( 'img/ORCID-iD_icon_unauth_vector.svg' ) ); ?>" alt="ORCID ID"/>
									<?php echo esc_html( $orcid ); ?>
							</a>
							<span class="author-orcid-unauth"><?php echo esc_html__( '(unauthenticated)', 'ehri' ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<?php
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
		public function update( $new_instance, $old_instance ) {
			return $new_instance;
		}
	}
}

