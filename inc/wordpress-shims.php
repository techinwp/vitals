<?php
/**
 * WordPress shims.
 *
 * @package storefront
 */

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Function wp_body_open
	 * 
	 * @return void
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
