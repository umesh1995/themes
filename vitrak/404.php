<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Ecotech
 * @since 1.0
 * @version 1.0
 */

get_header();
?>
    <div id="content" class="container site-content">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <section class="error-404 not-found">
                    <h1 class="title"><?php echo esc_html__( 'We are sorry.', 'ecotech' ); ?></h1>
                    <h3 class="subtitle"><?php echo esc_html__( 'The page you\'ve requested is not available.', 'ecotech' ); ?></h3>
                    <figure>
                        <img src="<?php echo get_theme_file_uri( '/assets/images/404.png' ); ?>" alt="404">
                    </figure>
                    <a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php echo esc_html__( 'Return to home', 'ecotech' ); ?>
                    </a>
                </section><!-- .error-404 -->
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->
<?php
get_footer();
