<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Deal"
 * @version 1.0.0
 */
class Shortcode_Ovic_Deal extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode      = 'ovic_deal';
    public $is_woocommerce = true;
    public $default        = array(
        'style'     => 'style-01',
        'title'     => '',
        'sub_title' => '',
        'date'      => '',
    );

    public function content($atts, $content = null)
    {
        $css_class = $this->main_class($atts, array(
            'ovic-deal',
            $atts['style']
        ));

        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <div class="inner">
                <?php
                $this->get_template("layout/{$atts['style']}.php",
                    array(
                        'atts' => $atts,
                    )
                );
                ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}