<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="copyright" content="EHRI Consortium <?php echo date("Y"); ?>">
	<meta name="description" content="The European Holocaust Research Infrastructure Document Blog">
	<meta name="keywords" content="EHRI,Blog,Holocaust,Research,Shoah,Archives,History,Deportations,Camps,Ghettos">

	<?php if (is_single()): ?>
		<meta property="og:title" content="<?php esc_attr_e( get_the_title() ); ?>"/>
		<meta property="og:description" content="<?php esc_attr_e( wp_filter_nohtml_kses( get_the_excerpt() ) ); ?>"/>
		<meta property="og:image" content="<?php echo esc_url(  get_the_post_thumbnail_url() ); ?>"/>
		<meta property="og:url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
		<meta property="og:type" content="article"/>
		<meta property="article:published_time" content="<?php echo get_the_date('c'); ?>"/>
		<meta property="article:modified_time" content="<?php echo get_the_modified_date('c'); ?>"/>
	<?php else : ?>
		<meta property="og:title" content="<?php esc_attr_e( get_bloginfo('name') ); ?>"/>
		<meta property="og:description" content="<?php esc_attr_e( get_bloginfo('description') ); ?>"/>
		<meta property="og:image" content="<?php echo esc_url( get_theme_file_uri('img/ehri-logo@2x.png') ); ?>"/>
		<meta property="og:url" content="<?php esc_attr_e( get_home_url() ); ?>"/>
		<meta property="og:type" content="website"/>
	<?php endif; ?>

	<!-- FIXME: load this via the theme code? -->
<!--	<script async src=""></script>-->

	<?php wp_head(); ?>

	<?php if ($plausible_domain = get_theme_mod('ehri_plausible_domain')): ?>

		<script defer data-domain="<?php echo $plausible_domain; ?>" src="https://plausible.io/js/script.js"></script>

	<?php endif; ?>
</head>

<body <?php body_class(); ?>>

<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">
		<div id="wrapper-navbar-overlay">

			<a class="skip-link sr-only sr-only-focusable"
			   href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

			<nav id="primary-nav">
				<div id="primary-nav-container">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img id="header-logo" class="img-fluid"
						     src="<?php echo esc_url( get_theme_file_uri( "img/ehri-logo@2x.png" ) ); ?>"
						     alt="EHRI Logo"/></a>

					<h1 id="site-title">
						<a rel="home"
						   href="<?php echo esc_url( home_url( '/' ) ); ?>"
						   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
						   itemprop="url"><?php bloginfo( 'name' ); ?>
						</a>
					</h1>

					<button class="navbar-toggler" type="button" data-toggle="collapse"
					        data-target="#navbar-nav-dropdown"
					        aria-controls="navbarNavDropdown" aria-expanded="false"
					        aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- The WordPress Menu goes here -->
					<div class="collapse navbar-collapse" id="navbar-nav-dropdown">
						<ul id="navbar-nav-pages">
							<?php $active_articles = is_archive() || is_single(); ?>
							<li class="dropdown <?php if ( $active_articles ) echo "active"; ?>">
								<a class="dropdown-toggle" id="navbar-cat-dropdown" data-toggle="dropdown"
								   href="#">Articles</a>
								<div class="dropdown-menu" id="categories-dropdown"
								     aria-labelledby="navbar-cat-dropdown">
									<div class="dropdown-menu-tab"></div>
									<?php the_widget( 'WP_Widget_Categories' ); ?>

									<a class="all-articles-menu"
									   href="<?php echo esc_url( home_url( '/all-articles/' ) ); ?>">
										<?php _e( "List all articles" ); ?>
									</a>
								</div>
							</li>

							<?php foreach ( wp_get_nav_menu_items( 'main' ) as $item ): ?>
								<li class="<?php if ( $item->object_id == get_the_ID() ) echo "active"; ?>">
									<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
						<form action="/" class="form-inline" id="navbar-nav-search">
							<div class="input-group" id="search-controls">
								<label class="sr-only" for="search-input">Search</label>
								<input class="form-control" type="search" name="s" placeholder="Search"
								       id="search-input" value="<?php echo get_query_var( 's' ); ?>"/>
								<span class="input-group-append">
									<button class="btn btn-outline-secondary" aria-label="Submit Search" type="submit">
										<i class="material-icons" aria-hidden="true">search</i>
									</button>
								</span>
							</div>
						</form>
						<!--				--><?php //wp_nav_menu(
						//					array(
						//						'theme_location' => 'primary',
						//						'container_class' => 'collapse navbar-collapse',
						//						'container_id' => 'navbarNavDropdown',
						//						'menu_class' => 'navbar-nav ml-auto',
						//						'fallback_cb' => '',
						//						'menu_id' => 'main-menu',
						//						'depth' => 2,
						//						'walker' => new Understrap_WP_Bootstrap_Navwalker(),
						//					)
						//				); ?>
					</div><!-- .container -->

			</nav><!-- .site-navigation -->

			<?php if ( is_front_page() ) : ?>
				<?php get_template_part( 'global-templates/hero' ); ?>
			<?php endif; ?>

		</div>
	</div><!-- #wrapper-navbar end -->

	<!-- Floating follow buttons -->
	<aside id="follow-buttons">

		<header><?php _e( "Follow" ); ?></header>

		<a class="follow-button" href="https://facebook.com/EHRIproject" title="Follow EHRI on Facebook">

			<i class="fa-brands fa-facebook-f" aria-hidden="true"></i>

			<span class="sr-only">Facebook</span>

		</a>

		<a class="follow-button" href="https://bsky.app/profile/ehri-project.eu" title="Follow EHRI on Bluesky">

			<i class="fa-brands fa-bluesky" aria-hidden="true"></i>

			<span class="sr-only">Bluesky</span>

		</a>

	</aside>

