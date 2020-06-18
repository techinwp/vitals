<?php
/**
 * Vitals hooks
 *
 * @package vitals
 */

/**
 * Header
 */
add_action( 'vitals_header', 'vitals_header_container', 0 );
add_action( 'vitals_header', 'vitals_site_branding', 5 );
add_action( 'vitals_header', 'vitals_header_container_close', 21);
