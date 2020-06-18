<?php
/**
 * Vitals Class
 *
 * @since    1.0.0
 * @version  1.0
 * @package  vitals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Vitals' ) ) :
	class Vitals {
		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
		}

	}
endif;

return new Vitals();