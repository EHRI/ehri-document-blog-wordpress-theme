<?php
/**
 * Auxilliary functions for contextual related posts (CRP) plugin.
 *
 * @package ehri-wp-theme
 */

if ( class_exists( 'CRP_Query' ) ) {
	global $post;
	$args = array(
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => 1,
	);

	$related_query = new CRP_Query( $args );
	?>

	<?php if ( $related_query->have_posts() ) : ?>

		<div class="related-posts">

			<h3><?php esc_html_e( 'Related Posts', 'ehri' ); ?></h3>

			<div class="related-post-items">

			<?php
			while ( $related_query->have_posts() ) :
				$related_query->the_post();
				?>

				<div class="related-post-item">

					<article class="related-post">

						<img alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid" src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>"/>

						<h3>
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
						</h3>

						<div class="related-post-meta">

							<?php ehri_posted_on(); ?>

						</div>

						<?php echo get_the_excerpt(); ?>

					</article>

				</div>

			<?php endwhile; ?>

			</div>

		</div>

	<?php endif; ?>

	<?php
	wp_reset_postdata();
}

