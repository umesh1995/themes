<?php
/**
 * Template Popup Newsletter
 *
 * @return string
 */
?>
<?php
$page_id = ecotech_get_option('popup_content');
$delay   = ecotech_get_option('popup_delay');
$effect  = ecotech_get_option('popup_effect');
?>
<div id="ecotech-popup-newsletter"
     class="ecotech-popup-newsletter white-popup mfp-with-anim mfp-hide"
     data-effect="<?php echo esc_attr($effect); ?>"
     data-delay="<?php echo esc_attr($delay); ?>">
    <div class="popup-inner">
        <div class="popup-content">
            <?php
            if (class_exists('\Elementor\Plugin')) {
                echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($page_id);
            } else {
                $post_id = get_post($page_id);
                $content = $post_id->post_content;
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]>', $content);
                echo wp_specialchars_decode($content);
            }
            ?>
        </div>
        <label for="ecotech_disabled_popup_by_user" class="ecotech_disabled_popup_by_user">
            <input id="ecotech_disabled_popup_by_user" name="ecotech_disabled_popup_by_user" type="checkbox">
            <span><?php echo esc_html__('PREVENT THIS POP-UP', 'ecotech'); ?></span>
        </label>
    </div>
</div>