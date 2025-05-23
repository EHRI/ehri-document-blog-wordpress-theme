<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

?>

<div class="wrapper" id="author-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<div class="content-area" id="primary">

				<main class="site-main" id="main">

					<header class="page-header author-header">

						<?php $curauth = ehri_get_current_archive_author() ?>

						<h1><?php esc_html_e( 'Articles by', 'ehri' ) . ' ' . esc_html( $curauth->display_name ); ?></h1>


					</header><!-- .page-header -->

					<div class="post-list">

						<?php while (have_posts()) : the_post(); ?>

							<?php get_template_part( 'loop-templates/content', get_post_format() ); ?>

						<?php
						endwhile;
						wp_reset_postdata();
						?>

					</div>

				</main><!-- #main -->

				<!-- The pagination component -->
				<?php ehri_pagination(); ?>

			</div>

			<!-- Do the right sidebar -->
			<?php get_template_part( 'sidebar' ); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

</div><!-- #author-wrapper -->

<?php get_footer(); ?>
