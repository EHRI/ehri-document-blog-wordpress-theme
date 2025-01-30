<?php
/**
 * Declaring widgets
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( "ehri_register_post_meta_widget" ) ) {
	function ehri_register_post_meta_widget() {
		register_widget( 'Ehri_Post_Metadata' );
	}
}

add_action( 'widgets_init', 'ehri_register_post_meta_widget' );

class Ehri_Post_Metadata extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Post_Metadata',
			__( 'Post Metadata [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays post author and publication date', 'ehri_widget_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
		if ( $post_id = get_queried_object_id() ) {
			global $post;
			$post = get_post( $post_id );
			setup_postdata( $post );

			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( function_exists( "coauthors_posts_links" ) && function_exists( "get_coauthors" ) ) {
				echo _n( 'Author', 'Authors', sizeof( get_coauthors() ) ) . ': ';
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

	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}


if ( ! function_exists( "ehri_register_comment_info_widget" ) ) {
	function ehri_register_comment_info_widget() {
		register_widget( 'Ehri_Post_Comment_Info' );
	}
}

add_action( 'widgets_init', 'ehri_register_comment_info_widget' );

class Ehri_Post_Comment_Info extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Post_Comment_Info',
			__( 'Post Comment Info [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays comment count and a link to the reply section', 'ehri_widget_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
		if ( $post_id = get_queried_object_id() ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			$number = get_comments_number( $post_id );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			if ( $number > 0 ) {
				echo '<i class="material-icons md-14" aria-hidden="true">mode_comment</i>';
				echo '<span id="post-comment-number">';
				printf( _nx(
					'%1$s Comment',
					'%1$s Comments',
					$number,
					'comments title'
				), number_format_i18n( $number ) );
				echo '</span>';
			}
			echo '<a class="btn btn-primary" href="#respond">Leave a reply</a>';
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}


if ( ! function_exists( "ehri_register_post_categories_widget" ) ) {
	function ehri_register_post_categories_widget() {
		register_widget( 'Ehri_Post_Categories' );
	}
}

add_action( 'widgets_init', 'ehri_register_post_categories_widget' );

class Ehri_Post_Categories extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Post_Categories',
			__( 'Post Categories [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays categories for the current post', 'ehri_widget_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
		if ( $post_id = get_queried_object_id() ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( $cats = trim( get_the_category_list( '', '', $post_id ) ) ) {
				if ( ! empty( $title ) )
					echo $args['before_title'] . $title . $args['after_title'];
				echo $cats;
			}
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		if ( isset( $instance['title'] ) )
			$title = $instance['title'];
		else
			$title = __( 'Categories', 'ehri_widget_domain' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] )) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


if ( ! function_exists( "ehri_register_post_tags_widget" ) ) {
	function ehri_register_post_tags_widget() {
		register_widget( 'Ehri_Post_Tags' );
	}
}

add_action( 'widgets_init', 'ehri_register_post_tags_widget' );

class Ehri_Post_Tags extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Post_Tags',
			__( 'Post Tags [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays tags for the current post', 'ehri_widget_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
		if ( $post_id = get_queried_object_id() ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( $tags = trim( get_the_tag_list( '', '', '', $post_id ) ) ) {
				if ( ! empty( $title ) )
					echo $args['before_title'] . $title . $args['after_title'];
				echo $tags;
			}
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		if ( isset( $instance['title'] ) )
			$title = $instance['title'];
		else
			$title = __( 'Tags', 'ehri_widget_domain' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] )) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


if ( ! function_exists( "ehri_register_authors_list_widget" ) ) {
	function ehri_register_authors_list_widget() {
		register_widget( 'Ehri_Authors_List' );
	}
}

add_action( 'widgets_init', 'ehri_register_authors_list_widget' );

class Ehri_Authors_List extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Authors_List',
			__( 'Authors List [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays a list of authors', 'ehri_widget_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		?>
		<ul class="authors-list">
			<?php echo wp_list_authors( array('style' => 'list', 'orderby' => 'post_count', 'order' => 'DESC') ); ?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance['title'] ) )
			$title = $instance['title'];
		else
			$title = __( 'Authors', 'ehri_widget_domain' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] )) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


if ( ! function_exists( "ehri_register_author_info_widget" ) ) {
	function ehri_register_author_info_widget() {
		register_widget( 'Ehri_Author_Info' );
	}
}

add_action( 'widgets_init', 'ehri_register_author_info_widget' );

class Ehri_Author_Info extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Author_Info',
			__( 'Author Info [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays biographical info about the current authors', 'ehri_widget_domain' ),)
		);
	}

	public function widget( $args, $instance ) {
		if ( $curauth = ehri_get_current_archive_author() ) {
			$title = apply_filters( 'widget_title', "About " . $curauth->display_name );
			echo $args['before_widget'];
			echo $args['before_title'] . $title . $args['after_title'];
			?>
			<div class="author-info">
				<?php if ( ! empty( $curauth->user_description ) ) : ?>
					<p><?php esc_html_e( $curauth->user_description ); ?></p>
				<?php endif; ?>
				<?php if ( ehri_has_gravitar( $curauth ) ) : ?>
					<?php echo get_avatar( $curauth->ID ); ?>
				<?php endif; ?>

				<?php $orcid = get_the_author_meta( 'orcid', $curauth->ID ); ?>
				<?php if ( ! empty( $orcid ) ) : ?>
					<div class="author-orcid">

						<a target="_blank" href="https://orcid.org/<?php echo esc_html( $orcid ); ?>" title="<?php echo __('View ORCID record'); ?>" aria-label="<?php echo __('View ORCID record'); ?>">

							<img src="<?php echo get_theme_file_uri( "img/ORCID-iD_icon_unauth_vector.svg" ); ?>" alt="ORCID iD" />

							<?php echo esc_html( $orcid ); ?>

						</a>

						<span class="author-orcid-unauth"><?php echo __('(unauthenticated)'); ?></span>

					</div>
				<?php endif; ?>
			</div>
			<?php
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}


if ( ! function_exists( "ehri_register_link_list_widget" ) ) {
	function ehri_register_link_list_widget() {
		register_widget( 'Ehri_Link_List' );
	}
}

add_action( 'widgets_init', 'ehri_register_link_list_widget' );

class Ehri_Link_List extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Ehri_Link_List',
			__( 'Link List [EHRI]', ' ehri_widget_domain' ),
			array('description' => __( 'Displays a list of links found in the post content with a matching base URL', 'ehri_widget_domain' ),)
		);
	}

	/**
	 * Get references to external content in this post.
	 * External links are defined in the 'external_links' metadata custom field
	 * and consist of one link per line in a "Link Text=URL" format.
	 *
	 * @param $post_id int the ID of the current Wordpress post
	 * @return array an array of two-element text->url pairs
	 */
	private function getPostExternalRefs( $post_id ) {
		$urls = array();
		foreach ( get_post_meta( $post_id, 'external_links' ) as $field ) {
			if ( $links = preg_split( '/\r\n|\r|\n/', $field ) ) {
				foreach ( $links as $link ) {
					if ( ($name_url = preg_split( '/\s*=\s*/', $link, 2, PREG_SPLIT_NO_EMPTY ))
						&& sizeof( $name_url ) === 2
						&& filter_var( $name_url[1], FILTER_VALIDATE_URL ) ) {
						$urls[] = $name_url;
					}
				}
			}
		}
		return $urls;
	}

	public function widget( $args, $instance ) {
		if ( $urls = $this->getPostExternalRefs( get_queried_object_id() ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			echo $args['before_title'] . $title . $args['after_title'];
			?>
			<ul class="link-list">
				<?php foreach ( $urls as list( $text, $url ) ): ?>
					<li><a target="_blank" rel="noopener" href="<?php echo $url; ?>"><?php echo $text; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php
			echo $args['after_widget'];
		}
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] )
			? $instance['title']
			: __( 'Linked documents', 'ehri_widget_domain' );
		$baseurl = isset( $instance['baseurl'] )
			? $instance['baseurl']
			: "http://www.example.com/";
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'baseurl' ); ?>"><?php _e( 'Base URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'baseurl' ); ?>"
			       name="<?php echo $this->get_field_name( 'baseurl' ); ?>" type="text"
			       value="<?php echo esc_attr( $baseurl ); ?>"/>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] )) ? strip_tags( $new_instance['title'] ) : '';
		$instance['baseurl'] = ( ! empty( $new_instance['baseurl'] )) ? strip_tags( $new_instance['baseurl'] ) : '';
		return $instance;
	}
}


/**
 * Add filter to the parameters passed to a widget's display callback.
 * The filter is evaluated on both the front and the back end!
 *
 * @link https://developer.wordpress.org/reference/hooks/dynamic_sidebar_params/
 */
add_filter( 'dynamic_sidebar_params', 'understrap_widget_classes' );

if ( ! function_exists( 'understrap_widget_classes' ) ) {
	/**
	 * Count number of visible widgets in a sidebar and add classes to widgets accordingly,
	 * so widgets can be displayed one, two, three or four per row.
	 *
	 * @global array $sidebars_widgets
	 *
	 * @param array $params {
	 * @type array $args {
	 *         An array of widget display arguments.
	 *
	 * @type string $name Name of the sidebar the widget is assigned to.
	 * @type string $id ID of the sidebar the widget is assigned to.
	 * @type string $description The sidebar description.
	 * @type string $class CSS class applied to the sidebar container.
	 * @type string $before_widget HTML markup to prepend to each widget in the sidebar.
	 * @type string $after_widget HTML markup to append to each widget in the sidebar.
	 * @type string $before_title HTML markup to prepend to the widget title when displayed.
	 * @type string $after_title HTML markup to append to the widget title when displayed.
	 * @type string $widget_id ID of the widget.
	 * @type string $widget_name Name of the widget.
	 *     }
	 * @type array $widget_args {
	 *         An array of multi-widget arguments.
	 *
	 * @type int $number Number increment used for multiples of the same widget.
	 *     }
	 * }
	 * @return array $params
	 */
	function understrap_widget_classes( $params ) {

		global $sidebars_widgets;

		/*
		 * When the corresponding filter is evaluated on the front end
		 * this takes into account that there might have been made other changes.
		 */
		$sidebars_widgets_count = apply_filters( 'sidebars_widgets', $sidebars_widgets );

		// Only apply changes if sidebar ID is set and the widget's classes depend on the number of widgets in the sidebar.
		if ( isset( $params[0]['id'] ) && strpos( $params[0]['before_widget'], 'dynamic-classes' ) ) {
			$sidebar_id = $params[0]['id'];
			$widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );

			$widget_classes = 'widget-count-' . $widget_count;
			if ( 0 === $widget_count % 4 || $widget_count > 6 ) {
				// Four widgets per row if there are exactly four or more than six.
				$widget_classes .= ' col-md-3';
			} elseif ( 6 === $widget_count ) {
				// If two widgets are published.
				$widget_classes .= ' col-md-2';
			} elseif ( $widget_count >= 3 ) {
				// Three widgets per row if there's three or more widgets.
				$widget_classes .= ' col-md-4';
			} elseif ( 2 === $widget_count ) {
				// If two widgets are published.
				$widget_classes .= ' col-md-6';
			} elseif ( 1 === $widget_count ) {
				// If just on widget is active.
				$widget_classes .= ' col-md-12';
			}

			// Replace the placeholder class 'dynamic-classes' with the classes stored in $widget_classes.
			$params[0]['before_widget'] = str_replace( 'dynamic-classes', $widget_classes, $params[0]['before_widget'] );
		}

		return $params;

	}
} // endif function_exists( 'understrap_widget_classes' ).

add_action( 'widgets_init', 'understrap_widgets_init' );

if ( ! function_exists( 'understrap_widgets_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function understrap_widgets_init() {
		register_sidebar(
			array(
				'name' => __( 'Right Sidebar', 'understrap' ),
				'id' => 'right-sidebar',
				'description' => __( 'Right sidebar widget area', 'understrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			)
		);
	}
} // endif function_exists( 'understrap_widgets_init' ).


