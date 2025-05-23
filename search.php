<?php
/**
 * The template for displaying search results pages.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();



?>

<div class="wrapper" id="search-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<div class="content-area" id="primary">

				<main class="site-main" id="main">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">

							<h1 class="page-title">Search Results</h1>

							<?php $q = trim( get_search_query() ); ?>
							<?php if ( $q ) : ?>
								<h2 class="text-muted"><?php echo esc_html( sprintf( '"%s"', $q ) ); ?></h2>
							<?php endif; ?>

						</header><!-- .page-header -->

						<div class="post-list">

							<?php /* Start the Loop */ ?>
							<?php
							while ( have_posts() ) :
								the_post();
								?>

								<?php
								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'loop-templates/content', 'search' );
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

</div><!-- #search-wrapper -->

<?php get_footer(); ?>
