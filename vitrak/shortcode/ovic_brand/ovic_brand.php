<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Brand"
 * @version 1.0.0
 */
class Shortcode_Ovic_Brand extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode      = 'ovic_brand';
    public $is_woocommerce = true;
    public $default        = array(
        'style' => 'style-01',
    );

    public function content($atts, $content = null)
    {
        $css_class = $this->main_class($atts, array(
            'ovic-brand',
            $atts['style']
        ));

        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <?php
            $this->get_template("layout/{$atts['style']}.php",
                array(
                    'atts'       => $atts,
                    'ovic_brand' => $this,
                )
            );
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}