<?php
/**
 * Vitals hooks
 * 
 * @package vitals
 */

if ( ! function_exists( 'vitals_open_container' ) ) {
	/**
	 * Header opens containter
	 * 
	 * @return void
	 */
	function vitals_open_container() {
		echo '<div class="container">';
	}
}

if ( ! function_exists( 'vitals_close_container' ) ) {
	/**
	 * Header closes container
	 * 
	 * @return void
	 */
	function vitals_close_container() {
		echo '</div><!-- .container -->';
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

if ( ! function_exists( 'vitals_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function vitals_post_header() {
		?>
		<header class="entry-header">
		<?php
		do_action( 'vitals_post_header_before' );

		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( sprintf( '<h2 class="entry-title heading-size-1"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}
		/**
		 * Functions hooked in to vitals_post_header_before action.
		 *
		 * @hooked vitals_post_meta - 10
		 */
		do_action( 'vitals_post_header_after' );
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'vitals_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function vitals_post_content() {
		?>
		<div class="entry-content">
		<?php

		/**
		 * Functions hooked in to vitals_post_content_before action.
		 *
		 * @hooked vitals_post_thumbnail - 10
		 */
		do_action( 'vitals_post_content_before' );

		the_content(
			sprintf(
				/* translators: %s: post title */
				__( 'Continue reading %s', 'vitals' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		do_action( 'vitals_post_content_after' );

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'vitals' ),
				'after'  => '</div>',
			)
		);
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'vitals_top_post_meta' ) ) {
	/**
	 * Render post meta before content
	 * 
	 * @return void
	 */
	function vitals_top_post_meta() {
		global $post;
		$post_meta = apply_filters( 'vitals_post_meta_top', array( 'author', 'date', 'comment', 'sticky' ) );
		if ( ! empty( $post_meta ) ) {
			?>
			<div class="post-meta-wrapper post-meta-top">
				<ul class="post-meta">
				<?php
					vitals_post_meta( $post->ID, $post_meta );
				?>
				</ul>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'vitals_bottom_post_meta' ) ) {
	/**
	 * Render post meta after content
	 * 
	 * @return void
	 */
	function vitals_bottom_post_meta() {
		global $post;
		$post_meta = apply_filters( 'vitals_post_meta_bottom', array( 'category', 'tag' ) );

		if ( ! empty( $post_meta ) ) {
			?>
			<div class="post-meta-wrapper post-meta-bottom">
				<ul class="post-meta">
				<?php
					vitals_post_meta( $post->ID, $post_meta );
				?>
				</ul>
				<?php edit_post_link( __( 'Edit', 'vitals' ) ); ?>
			</div>
			<?php
		}
	}
}
