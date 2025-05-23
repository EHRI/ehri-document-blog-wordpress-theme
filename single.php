<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();


?>

<div class="wrapper" id="single-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<div class="content-area" id="primary">

				<main class="site-main" id="main">

					<?php
					while ( have_posts() ) :
						the_post();
						?>

						<?php get_template_part( 'loop-templates/content', 'single' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

						<?php get_template_part( 'global-templates/crp-related' ); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div>

			<!-- Do the right sidebar -->
			<?php get_template_part( 'sidebar' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
