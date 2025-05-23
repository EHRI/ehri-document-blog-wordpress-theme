<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


?>

<div class="wrapper" id="wrapper-footer-full">

	<div class="container" id="footer-full-content" tabindex="-1">

		<div class="footer-full-sections">

			<div class="footer-full-section-social">

				<?php $mailinglist_url = get_theme_mod( 'ehri_mailinglist_url', false ); ?>
				<?php if ( $mailinglist_url ) : ?>

				<div class="newsletter">

					<h3>Don't miss new articles</h3>

					<a href="<?php echo esc_url( $mailinglist_url ); ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener" id="subscribe-to-newsletter">
						<?php esc_html_e( 'Subscribe to our mailing list', 'ehri' ); ?>
					</a>

				</div>

				<?php endif; ?>

				<div class="social-links">
					<a href="https://facebook.com/EHRIproject" title="Follow EHRI on Facebook">
						<i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
						Facebook
					</a>
					<a href="https://bsky.app/profile/ehri-project.eu" title="Follow EHRI on Bluesky">
						<i class="fa-brands fa-bluesky" aria-hidden="true"></i>
						Bluesky
					</a>
					<a href="/feed/" title="RSS Feed">
						<i class="fa-solid fa-rss" aria-hidden="true"></i>
						RSS
					</a>
				</div>

				<p id="copyright">
					<span class="text-capitalize">© 2015-<?php echo gmdate( 'Y' ); ?> EHRI Consortium </span>
					&nbsp;
					&nbsp;
					<a href="https://ehri-project.eu/content/privacy-statement">Privacy policy</a>
				</p>

			</div>

			<div class="footer-full-section-menu">

				<div class="footer-full-menus">

					<div class="footer-full-menu">
						<?php foreach ( wp_get_nav_menu_items( 'footer1' ) as $item ) : ?>
							<p class="
							<?php
							if ( get_the_ID() === $item->object_id ) {
								echo 'active';}
							?>
							">
								<a href="<?php echo esc_url( $item->url ); ?>"><?php echo esc_html( $item->title ); ?></a>
							</p>
						<?php endforeach; ?>
					</div>

					<div class="footer-full-menu">

						<p>
							<a href="<?php echo esc_url( home_url( '/all-articles/' ) ); ?>">
								Categories
							</a>
						</p>
						<ul class="footer-categories">
							<?php foreach ( get_categories() as $category ) : ?>
								<li>
									<a href="<?php echo get_category_link( $category ); ?>">
										<?php echo esc_html( $category->name ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>

					</div>

					<div class="footer-full-menu" id="footer-attributions">
						<img src="<?php echo esc_url( get_theme_file_uri( 'img/eu_logo.gif' ) ); ?>" alt="EU Logo" width="68" height="45"/>
						<p>
							<?php esc_html_e( 'The EHRI Project is supported by the European Commission', 'ehri' ); ?>
						</p>
					</div>

				</div>

			</div>

		</div>

	</div>

</div><!-- #wrapper-footer-full -->



</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

