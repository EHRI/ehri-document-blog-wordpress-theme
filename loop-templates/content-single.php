<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php do_action( 'after_post_title' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-body">

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php ehri_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

		<div class="entry-content">

			<?php ehri_post_translations( $post->ID ); ?>

			<?php the_content(); ?>

			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
					'after'  => '</div>',
				)
			);
			?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php get_template_part( 'global-templates/share' ); ?>

		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-## -->
