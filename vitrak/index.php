<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Ecotech
 * @since 1.0
 * @version 1.0
 */

get_header();

$page_layout = ecotech_page_layout();
$post_style  = ecotech_get_option( 'blog_list_style', 'standard' );
$sub_class   = 'blog-page';
if ( is_single() ) {
    $post_style = ecotech_get_option( 'single_layout', 'standard' );
    $sub_class  = 'post-page';
    if ( $post_style == 'full' )
        $page_layout[ 'layout' ] = 'full';
}
$main_class = array(
    "container",
    "site-content",
    "sidebar-{$page_layout['layout']}",
    "style-{$post_style} {$sub_class}",
);
?>

    <!-- .site-content-contain -->
    <div id="content" class="<?php echo implode( ' ', $main_class ); ?>">

        <?php
        if ( is_single() ) {
            if ( $post_style != 'full' ) {
                ecotech_head_banner();
            }
        } else {
            ecotech_head_banner();
        }
        ?>

        <div id="primary" class="content-area">

            <main id="main" class="site-main">

                <?php
                if ( have_posts() ) {
                    $path = 'content';
                    if ( is_single() ) {
                        $path = 'single';
                    } else {
                        get_template_part( "templates/blog/blog-content/content", "featured" );
                    }
                    get_template_part( "templates/blog/blog-{$path}/content", "{$post_style}" );
                    wp_reset_postdata();
                } else {
                    get_template_part( 'content', 'none' );
                }
                ?>

            </main><!-- #main -->

        </div><!-- #primary -->

        <?php if ( $page_layout[ 'layout' ] != 'full' ) : ?>
            <aside id="secondary" class="widget-area" role="complementary"
                   aria-label="<?php esc_attr_e( 'Post Sidebar', 'ecotech' ); ?>">
                <?php dynamic_sidebar( $page_layout[ 'sidebar' ] ); ?>
            </aside><!-- #secondary -->
        <?php endif; ?>

    </div><!-- .site-content-contain -->
<?php
get_footer();
