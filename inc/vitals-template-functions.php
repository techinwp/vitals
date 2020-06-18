<?php
/**
 * Vitals hooks
 * 
 * @package vitals
 */

if ( ! function_exists( 'vitals_header_container' ) ) {
	function vitals_header_container() {
		echo '<div class="container">';
	}
}

if ( ! function_exists( 'vitals_header_container_close' ) ) {
	function vitals_header_container_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'vitals_site_branding' ) ) {
	/**
	 * Site branding design
	 * 
	 * @return void
	 */
	function vitals_site_branding() {
		?>
		<div class="site-branding">
			<?php vitals_site_title_or_logo(); ?>
		</div>
		<?php

	}
}

if ( ! function_exists( 'vitals_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @since 2.1.0
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function vitals_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
		} else {
			$tag = is_home() ? 'h1' : 'div';

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) . '>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}
		}

		if ( ! $echo ) {
			return $html;
		}
		// WPCS: XSS ok.
		echo $html; 
	}
}
