<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! is_active_sidebar( 'right-sidebar' ) ) {
	return;
}

?>

<div class="widget-area" id="right-sidebar" role="complementary">

	<?php if ( is_single() ) : ?>

		<?php get_template_part( 'global-templates/share' ); ?>

	<?php endif; ?>

	<?php dynamic_sidebar( 'right-sidebar' ); ?>

</div><!-- #right-sidebar -->
