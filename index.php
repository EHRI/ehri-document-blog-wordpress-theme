<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="wrapper" id="index-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<div class="content-area" id="primary">

				<main class="site-main" id="main">
					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1>All articles</h1>
						</header>

						<div class="post-list">

							<?php
							while ( have_posts() ) :
								the_post();
								?>

								<?php
								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'loop-templates/content', get_post_format() );
								?>

							<?php endwhile; ?>

						</div>

					<?php else : ?>

						<?php get_template_part( 'loop-templates/content', 'none' ); ?>

					<?php endif; ?>

				</main><!-- #main -->

				<!-- The pagination component -->
				<?php ehri_pagination(); ?>

			</div>

			<!-- Do the right sidebar -->
			<?php get_template_part( 'sidebar' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
