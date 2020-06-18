<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package vitals
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'vitals_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'vitals_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php vitals_header_styles(); ?>">

		<?php
		/**
		 * Functions hooked into vitals_header action
		 *
		 * @hooked vitals_header_container                 - 0
		 */
		do_action( 'vitals_header' );
		?>

	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to vitals_before_content
	 *
	 * @hooked vitals_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'vitals_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

		<?php
		do_action( 'vitals_content_top' );
		
