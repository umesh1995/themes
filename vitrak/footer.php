<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Ecotech
 * @since 1.0
 * @version 1.2
 */
?>
<?php if ( ecotech_get_option( 'enable_backtotop' ) == 1 ): ?>
    <a href="#" class="action-to-top backtotop"></a>
<?php endif; ?>
<?php
/* FOOTER */
do_action( 'ovic_footer_content' );
/* NEWSLETTER */
ecotech_popup_newsletter();
?>
</div><!-- #page -->
<div id="ecotech-modal-popup" class="modal fade"></div>
<?php
/* WP FOOTER */
wp_footer();
?>
</body>
</html>
