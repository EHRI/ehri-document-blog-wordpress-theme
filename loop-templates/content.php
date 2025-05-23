<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-thumbnail" style="background-image:url('<?php echo esc_url( get_the_post_thumbnail_url( $post, 'large' ) ); ?>')" title="<?php echo esc_attr( get_the_title() ); ?>">
		<!-- Nothing here -->
	</a>

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

		<div class="entry-content">

			<?php the_excerpt(); ?>

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

			<?php ehri_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-## -->
