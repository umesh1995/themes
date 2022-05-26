<?php
/**
 * Name: Blog Standard
 **/
?>
<div class="blog-content blog-standard response-content">
    <?php while ( have_posts() ): the_post(); ?>
        <article <?php post_class( 'post-item style-01' ); ?>>
            <?php get_template_part( 'templates/blog/blog-style/content-blog', 'style-01' ); ?>
        </article>
    <?php endwhile; ?>
</div>
<?php ecotech_post_pagination(); ?>
