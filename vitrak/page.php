<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Ecotech
 * @since 1.0
 * @version 1.0
 */

get_header();

$page_layout      = ecotech_page_layout();
$meta_class       = ecotech_theme_option_meta( '_custom_page_side_options', null, 'page_extra_class' );
if ( class_exists( 'WooCommerce' ) ) {
	if ( is_checkout() || is_account_page() || is_cart() ) {
		$page_layout['layout'] = 'full';
	}
}
/* CLASS */
$main_class = array(
	"container",
	"site-content",
	"sidebar-{$page_layout['layout']}",
);
if ( ! empty( $meta_class ) ) {
	$main_class[] = $meta_class;
}
?>

    <!-- .site-content-contain -->
    <div id="content" class="<?php echo implode( ' ', $main_class ); ?>">

        <?php ecotech_head_banner(); ?>

        <div id="primary" class="content-area">

            <main id="main" class="site-main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
							<?php
							the_content();
							wp_link_pages( array(
									'before'      => '<div class="post-pagination"><span class="title">' . esc_html__( 'Pages:', 'ecotech' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								)
							);
							?>
                        </div><!-- .entry-content -->
                    </article><!-- #post-## -->
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				?>

            </main><!-- #main -->

        </div><!-- #primary -->

		<?php if ( $page_layout['layout'] != 'full' ) : ?>
            <aside id="secondary" class="widget-area" role="complementary"
                   aria-label="<?php esc_attr_e( 'Page Sidebar', 'ecotech' ); ?>">
				<?php dynamic_sidebar( $page_layout['sidebar'] ); ?>
            </aside><!-- #secondary -->
		<?php endif; ?>

    </div><!-- .site-content-contain -->

<?php
get_footer();
