<?php
/**
 * vitals functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vitals
 */

$theme              = wp_get_theme( 'vitals' );
$vitals_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$vitals = (object) array(
	'version'    => $vitals_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-vitals.php',
	'customizer' => require 'inc/customizer/class-vitals-customizer.php',
);

require 'inc/vitals-functions.php';
require 'inc/vitals-template-hooks.php';
require 'inc/vitals-template-functions.php';
require 'inc/wordpress-shims.php';

if ( is_admin() ) {
	$vitals->admin = require 'inc/admin/class-vitals-admin.php';
}