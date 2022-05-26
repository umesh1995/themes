<?php
$blog_featured_posts = ecotech_get_option( 'blog_featured_posts' );
if ( empty( $blog_featured_posts ) ) {
    return;
}
$data_slick   = array(
    'infinite'      => true,
    'slidesToShow'  => 1,
    'speed'         => 1500,
    'autoplay'      => true,
    'autoplaySpeed' => 5000,
);
$args         = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'post__in'            => $blog_featured_posts,
    'ignore_sticky_posts' => 1,
    'posts_per_page'      => -1,
    'orderby'             => 'post__in',
);
$query = new WP_Query( $args );
if ( !$query->have_posts() ) {
    return;
}
?>
<div class="blog-featured-posts owl-slick" data-slick="<?php echo esc_attr( json_encode( $data_slick ) ); ?>">
    <?php while ( $query->have_posts() ): $query->the_post(); ?>
        <article <?php post_class( 'post-item style-02' ); ?>>
            <?php get_template_part( 'templates/blog/blog-style/content-blog', 'style-03' ); ?>
        </article>
    <?php endwhile; ?>
    <?php wp_reset_postdata() ?>
</div>
