<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Price"
 * @version 1.0.0
 */
class Shortcode_Ovic_Price extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode      = 'ovic_price';
    public $is_woocommerce = true;

    public function content($atts, $content = null)
    {
        $css_class = $this->main_class($atts, array(
            'ovic-price',
        ));

        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <?php
            if (!empty($atts['product_id'])) {
                $product_id = $atts['product_id'];
            } elseif (wp_doing_ajax()) {
                $product_id = $_POST['post_id'];
            } else {
                $product_id = get_queried_object_id();
            }

            global $product;

            $product = wc_get_product($product_id);

            if (!empty($product)) {

                wc_get_template('/single-product/price.php');

            }
            ?>
        </div>
        <?php

        return ob_get_clean();
    }
}