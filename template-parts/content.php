<?php
/**
 * Template used to display post content.
 *
 * @package vitals
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to vitals_loop_post action.
	 *
	 * @hooked vitals_post_header          - 10
	 * @hooked vitals_post_content         - 30
	 */
	do_action( 'vitals_loop_post' );
	?>

</article><!-- #post-## -->
