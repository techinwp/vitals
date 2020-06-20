<?php
/**
 * Vitals hooks
 *
 * @package vitals
 */

/**
 * Header
 *
 * @see  vitals_header_container()
 * @see  vitals_site_branding()
 * @see  vitals_header_container_close()
 */
add_action( 'vitals_header', 'vitals_open_container', 0 );
add_action( 'vitals_header', 'vitals_site_branding', 5 );
add_action( 'vitals_header', 'vitals_primary_navigation', 10 );
add_action( 'vitals_header', 'vitals_close_container', 21 );

/**
 * Posts
 *
 * @see  vitals_post_header()
 * @see  vitals_post_content()
 * @see  vitals_top_post_meta()
 * @see  vitals_bottom_post_meta()
 */
add_action( 'vitals_loop_post', 'vitals_post_header', 10 );
add_action( 'vitals_loop_post', 'vitals_post_content', 20 );
add_action( 'vitals_post_header_after', 'vitals_top_post_meta', 10 );
add_action( 'vitals_post_content_after', 'vitals_bottom_post_meta', 10 );
