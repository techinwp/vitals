<?php
/**
 * Vitals functions
 *
 * @package vitals
 */

/**
 * Reder post meta
 *
 * @param  int   $post_id Post ID.
 * @param  array $post_meta Post metadata.
 * @return void
 */
function vitals_post_meta( $post_id, $post_meta = array() ) {
	if ( empty( $post_meta ) || ! $post_id ) {
		return;
	}

	foreach ( $post_meta as $meta ) {
		echo vitals_render_post_meta( $post_id, $meta );
	}
}

/**
 * Render post meta 
 * 
 * @param  integer $post_id   Post ID.
 * @param  string  $post_meta Post meta name.
 * @return void
 */
function vitals_render_post_meta( $post_id, $post_meta ) {
	if ( ! $post_id || '' === $post_meta ) {
		return;
	}

	global $post;
	$the_post = get_post( $post_id );
	setup_postdata( $the_post );

	// Make sure we don't output an empty container.
	$has_meta = false;

	ob_start();

	// Author.
	if ( post_type_supports( get_post_type( $post_id ), 'author' ) && 'author' === $post_meta ) :

		$has_meta = true;
		?>
		<li class="post-author meta-wrapper">
			<span class="meta-text">
			<?php
				printf(
					/* translators: %s: Author name. */
					__( 'By %s', 'vitals' ),
					'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>'
				);
			?>
			</span>
		</li>
		<?php

	endif;

	// Post date.
	if ( 'date' === $post_meta ) :

		$has_meta = true;
		?>
		<li class="post-date meta-wrapper">
			<span class="meta-text">
				<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
			</span>
		</li>
		<?php

	endif;

	// Categories.
	if ( 'category' === $post_meta && has_category() ) :

		$has_meta = true;
		?>
		<li class="post-categories meta-wrapper">
			<span class="meta-text">
				<?php _ex( 'Category:', 'A string that is output before one or more categories', 'vitals' ); ?> <?php the_category( ', ' ); ?>
			</span>
		</li>
		<?php

	endif;

	// Tags.
	if ( 'tag' === $post_meta && has_tag() ) :

		$has_meta = true;
		?>
		<li class="post-tags meta-wrapper">
			<span class="meta-text">
				<?php _ex( 'Tag:', 'A string that is output before one or more tags', 'vitals' ); ?> <?php the_tags( '', ', ', '' ); ?>
			</span>
		</li>
		<?php

	endif;

	// Comments link.
	if ( 'comment' === $post_meta && ! post_password_required() && ( comments_open() || get_comments_number() ) ) :

		$has_meta = true;
		?>
		<li class="post-comment-link meta-wrapper">
			<span class="meta-text">
				<?php comments_popup_link(); ?>
			</span>
		</li>
		<?php

	endif;
		// Sticky.
	if ( 'sticky' === $post_meta && is_sticky() ) :
		$has_meta = true;
		?>
		<li class="post-sticky meta-wrapper">
			<span class="meta-text">
				<?php esc_html_e( 'Sticky post', 'vitals' ); ?>
			</span>
		</li>
		<?php

	endif;
	
	wp_reset_postdata();

	$meta_output = ob_get_clean();

	return $meta_output;
}
