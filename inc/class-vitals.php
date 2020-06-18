<?php
/**
 * Vitals Class
 *
 * @since    1.0.0
 * @package  vitals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Vitals' ) ) :

	/**
	 * Vitals Class
	 * 
	 * @version  1.0
	 */
	class Vitals {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 * 
		 * @since  1.0
		 * @return void
		 */
		public function setup() {
			/**
			 * Load Localisation files.
			 */
			load_theme_textdomain( 'vitals', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/**
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo', 
				apply_filters(
					'vitals_custom_logo_args', 
					array(
						'height'      => 110,
						'width'       => 470,
						'flex-width'  => true,
						'flex-height' => true,
					)
				)
			);

			/**
			 * Register menu locations.
			 */
			register_nav_menus(
				apply_filters(
					'vitals_register_nav_menus', 
					array(
						'primary' => __( 'Primary Menu', 'vitals' ),
						'footer'  => __( 'Footer Menu', 'vitals' ),
					)
				)
			);

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5', 
				apply_filters(
					'vitals_html5_args', 
					array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
						'style',
						'script',
					)
				)
			);

			/**
			 * Setup the WordPress core custom background feature.
			 */
			add_theme_support(
				'custom-background', 
				apply_filters(
					'vitals_custom_background_args', 
					array(
						'default-color' => apply_filters( 'vitals_default_background_color', 'ffffff' ),
						'default-image' => '',
					)
				)
			);
			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for responsive embedded content.
			 */
			add_theme_support( 'responsive-embeds' );

		}

		/**
		 * Register widget area.
		 * 
		 * @since  1.0
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 * @return  void
		 */
		public function widgets_init() {
			$sidebar_args['sidebar'] = array(
				'name'        => __( 'Sidebar', 'vitals' ),
				'id'          => 'sidebar-1',
				'description' => '',
			);

			$sidebar_args['header'] = array(
				'name'        => __( 'Below Header', 'vitals' ),
				'id'          => 'header-1',
				'description' => __( 'Widgets added to this region will appear beneath the header and above the main content.', 'vitals' ),
			);

			$rows    = intval( apply_filters( 'vitals_footer_widget_rows', 1 ) );
			$regions = intval( apply_filters( 'vitals_footer_widget_columns', 4 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $regions; $region++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer   = sprintf( 'footer_%d', $footer_n );

					if ( 1 === $rows ) {
						/* translators: 1: column number */
						$footer_region_name = sprintf( __( 'Footer Column %1$d', 'vitals' ), $region );

						/* translators: 1: column number */
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'vitals' ), $region );
					} else {
						/* translators: 1: row number, 2: column number */
						$footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'vitals' ), $row, $region );

						/* translators: 1: column number, 2: row number */
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'vitals' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'        => $footer_region_name,
						'id'          => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				}
			}

			$sidebar_args = apply_filters( 'vitals_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<span class="gamma widget-title">',
					'after_title'   => '</span>',
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'vitals_header_widget_tags'
				 * 'vitals_sidebar_widget_tags'
				 *
				 * 'vitals_footer_1_widget_tags'
				 * 'vitals_footer_2_widget_tags'
				 * 'vitals_footer_3_widget_tags'
				 * 'vitals_footer_4_widget_tags'
				 */
				$filter_hook = sprintf( 'vitals_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function scripts() {
			global $vitals_version;
			/**
			 * Styles
			 */
			wp_enqueue_style( 'vitals-style', get_template_directory_uri() . '/style.css', '', $vitals_version );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function body_classes( $classes ) {
			// Adds a class to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			return $classes;
		}
	}
endif;

return new Vitals();
