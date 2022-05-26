<?php
/**
 * Name: Blog Creative
 **/
?>
<?php
wp_enqueue_script('ecotech-isotope');
$page_layout = ecotech_page_layout();
$data_cols   = 3;
if ($page_layout['layout'] != 'full') {
    $data_cols = 2;
}
?>
<div class="blog-content blog-creative response-content ovic-isotope"
     data-layout="packery"
     data-cols="<?php echo esc_attr($data_cols); ?>">
    <?php while (have_posts()): the_post(); ?>
        <article <?php post_class('post-item isotope-item style-01'); ?>>
            <?php get_template_part('templates/blog/blog-style/content-blog', 'style-01'); ?>
        </article>
    <?php endwhile; ?>
</div>
<?php ecotech_post_pagination(); ?>
