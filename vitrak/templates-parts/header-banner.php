<?php
/**
 * Template Header Banner
 *
 * @return string
 * @var $banner_id
 *
 */
?>
<div class="header-banner">
    <div class="container">
        <?php
        if (class_exists('\Elementor\Plugin')) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($banner_id);
        } else {
            $post_id = get_post($banner_id);
            $content = $post_id->post_content;
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]>', $content);
            echo wp_specialchars_decode($content);
        }
        ?>
    </div>
</div>