<?php
/**
 * Name: Blog Grid
 **/
?>
<?php
$page_layout = ecotech_page_layout();
$class_item  = 'post-item style-01 col-ts-12 col-xs-6 col-sm-4';
if ( $page_layout[ 'layout' ] != 'full' ) {
    $class_item .= ' col-lg-4 col-md-6';
} else {
    $class_item .= ' col-lg-3 col-md-4';
}
?>
<div class="blog-content blog-grid response-content row">
    <?php while ( have_posts() ): the_post(); ?>
        <article <?php post_class( $class_item ); ?>>
            <?php get_template_part( 'templates/blog/blog-style/content-blog', 'style-01' ); ?>
        </article>
    <?php endwhile; ?>
</div>
<?php ecotech_post_pagination(); ?>
