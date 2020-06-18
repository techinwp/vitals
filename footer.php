<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package vitals
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'vitals_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to vitals_footer action
			 *
			 * @hooked vitals_footer_widgets - 10
			 * @hooked vitals_credit         - 20
			 */
			do_action( 'vitals_footer' );
			?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'vitals_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
