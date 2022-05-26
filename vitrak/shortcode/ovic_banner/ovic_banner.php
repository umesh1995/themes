<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Banner"
 * @version 1.0.0
 */
class Shortcode_Ovic_Banner extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_banner';
    public $default   = array(
        'style' => 'style-01',
    );

    public function content($atts, $content = null)
    {
        $css_class           = $this->main_class($atts, array(
            'ovic-banner',
            $atts['style']
        ));
        $image_url           = !empty($atts['image']['id']) ? wp_get_attachment_image_url($atts['image']['id'], 'full') : '';
        $atts['link']['url'] = apply_filters('ovic_shortcode_vc_link', $atts['link']['url']);
        $link                = $this->add_link_attributes($atts['link'], true);

        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <div class="inner <?php echo esc_attr($atts['image_effect']); ?>"
                 data-image="<?php echo esc_url($image_url); ?>">
                <?php if (!empty($atts['image']['id'])) : ?>
                    <div class="background image-effect"
                         style="background-image: url(<?php echo esc_url($image_url); ?>)">
                    </div>
                <?php endif; ?>
                <a class="target" <?php echo esc_attr($link); ?>></a>
                <div class="content">
                    <?php if (!empty($atts['text_01'])): ?>
                        <h3 class="text-01"><?php echo nl2br($atts['text_01']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($atts['text_02'])): ?>
                        <h3 class="text-02"><?php echo nl2br($atts['text_02']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($atts['text_03'])): ?>
                        <h3 class="text-03"><?php echo nl2br($atts['text_03']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($atts['text_button'])) : ?>
                        <div class="button-wrap">
                            <a <?php echo esc_attr($link); ?> class="button">
                                <?php echo esc_html($atts['text_button']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}