<?php
/**
 * Declaring widgets
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
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
	 * @param array $params widget parameters.
	 *
	 * @type array $args An array of widget display arguments.
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
	 * @global array $sidebars_widgets
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
			$sidebar_id   = $params[0]['id'];
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
}

add_action( 'widgets_init', 'understrap_widgets_init' );

if ( ! function_exists( 'understrap_widgets_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function understrap_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Right Sidebar', 'understrap' ),
				'id'            => 'right-sidebar',
				'description'   => __( 'Right sidebar widget area', 'understrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'After Post Title', 'understrap' ),
				'id'            => 'post-title-widgets',
				'description'   => __( 'Widgets placed here will appear directly underneath the post title on single post pages', 'understrap' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);
	}
}

add_action( 'after_post_title', 'ehri_display_post_title_widget_area' );

// To display the widget area in your theme's single.php.
if ( ! function_exists( 'ehri_display_post_title_widget_area' ) ) {
	/**
	 * Register a widget area under the post title.
	 *
	 * @return void
	 */
	function ehri_display_post_title_widget_area() {
		if ( is_single() ) {
			dynamic_sidebar( 'post-title-widgets' );
		}
	}
}
