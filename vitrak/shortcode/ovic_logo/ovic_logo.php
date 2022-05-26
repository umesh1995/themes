<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Logo"
 * @version 1.0.0
 */
class Shortcode_Ovic_Logo extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_logo';
    public $default   = array(
        'style' => 'style-01',
    );

    public function content($atts, $content = null)
    {
        $attribute = '';
        $link      = array('href' => home_url('/'));
        $css_class = $this->main_class(
            $atts,
            array('ovic-logo')
        );

        if (!empty($atts['link']['url'])) {
            $link = $this->add_link_attributes($atts['link']);
        }
        $link['href'] = apply_filters('ovic_get_link_logo', $link['href']);
        $logo_url     = get_theme_file_uri('/assets/images/logo.png');
        $logo         = ecotech_theme_option_meta('_custom_metabox_theme_options', 'logo');
        if (ecotech_is_mobile()) {
            $logo = ecotech_get_option('logo_mobile');
        }
        if (!empty($logo)) {
            $logo_url = wp_get_attachment_image_url($logo, 'full');
        }
        if (!empty($atts['logo']['url'])) {
            $logo_url = $atts['logo']['url'];
        }

        foreach ($link as $key => $value) {
            $attribute .= " {$key}={$value} ";
        }

        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <h2 class="logo">
                <a <?php echo esc_attr($attribute); ?>>
                    <span>
                        <img alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                             src="<?php echo esc_url($logo_url); ?>"
                             class="_rw"/>
                    </span>
                </a>
            </h2>
        </div>
        <?php
        return ob_get_clean();
    }
}