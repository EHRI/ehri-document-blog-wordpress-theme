<?php
/**
 * Template Name: Homepage
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

<?php if ( $img = get_the_post_thumbnail_url( get_option( 'page_on_front' ), 'full' ) ): ?>
	<style>
		body.home #wrapper-navbar {
			background-image: url(<?php echo $img;?>);
		}
	</style>
<?php endif; ?>


<div class="wrapper" id="index-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<div class="content-area" id="primary">

				<main class="site-main" id="main">

					<header class="page-header">
						<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
					</header>

					<div class="post-list">

						<?php $the_query = new WP_Query( 'posts_per_page=4' ); ?>

						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>


							<?php
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'loop-templates/content', get_post_format() );
							?>

						<?php
						endwhile;
						wp_reset_postdata();
						?>

					</div>

					<a class="all-articles btn btn-lg btn-outline-primary" href="/all-articles/">All articles</a>

				</main><!-- #main -->

			</div>

			<!-- Do the right sidebar -->
			<?php get_template_part( 'sidebar' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
