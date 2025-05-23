<?php
/**
 * Search results partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-thumbnail" style="background-image:url('<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>')">
		<!-- Nothing here. -->
	</div>

	<div class="entry-body">

		<header class="entry-header">

			<?php
			the_title(
				sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
			?>

		</header><!-- .entry-header -->

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php ehri_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

		<div class="entry-summary">

			<?php the_excerpt(); ?>

		</div><!-- .entry-summary -->

		<footer class="entry-footer">

			<?php ehri_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</div>


</article><!-- #post-## -->
