<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Products"
 * @version 1.0.0
 */
class Shortcode_Ovic_Products extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode      = 'ovic_products';
    public $is_woocommerce = true;
    public $default        = array(
        'product_style'               => 'style-01',
        'pagination'                  => 'none',
        'target'                      => 'recent_products',
        'list_style'                  => 'none',
        'product_image_size'          => '300x300',
        'product_custom_thumb_width'  => '300',
        'product_custom_thumb_height' => '300',
        'slides_rows_space'           => '',
        'attribute'                   => '',
        'filter'                      => '',
        'ids'                         => '',
        'skus'                        => '',
        'limit'                       => '6',
        'order'                       => '',
        'orderby'                     => '',
        'category'                    => '',
        'category_brand'              => '',
        'disable_labels'              => '',
        'disable_rating'              => '',
        'short_text'                  => '',
        'slide_nav'                   => '',
        'slide_dot'                   => '',
    );

    public function content($atts, $content = null)
    {
        $html      = '';
        $classes   = array('ovic-products', $atts['product_style']);
        $classes[] = $atts['slide_nav'];
        $classes[] = $atts['slide_dot'];
        if ($atts['disable_labels'] == 'yes') {
            $classes[] = 'no-labels';
        }
        if ($atts['disable_rating'] == 'yes') {
            $classes[] = 'no-rating';
        }
        if ($atts['short_text'] == 'yes') {
            $classes[] = 'short-text';
        }
        if ($atts['product_style'] == 'style-05') {
            $classes[] = 'arrows-02';
        }
        $css_class = $this->main_class($atts, $classes);
        /**
         * BEFORE SHORTCODE
         */
        $this->get_template('loop/shortcode_before.php',
            array(
                'atts'          => $atts,
                'ovic_products' => $this,
            )
        );
        /**
         * CONTENT PRODUCTS
         */
        $html .= '<div class="'.esc_attr($css_class).'">';
        if ($atts['target'] == 'products' && $atts['ids'] == '') {
            $atts['target'] = '';
        }
        if (!empty($atts['title'])) {
            $html .= '<div class="head">';
            $html .= '<h3 class="title">'.esc_html($atts['title']).'</h3>';
            if (!empty($atts['desc'])) {
                $html .= '<p class="desc">'.esc_html($atts['desc']).'</p>';
            }
            $html .= '</div>';
        }
        if ($atts['target'] != '') {
            $html .= ovic_do_shortcode($atts['target'], ecotech_shortcode_products_query($atts));
        } else {
            $html .= '<span>'.esc_html__('No Product', 'ecotech').'</span>';
        }
        $html .= '</div>';
        /**
         * AFTER SHORTCODE
         */
        $this->get_template('loop/shortcode_after.php',
            array(
                'atts'          => $atts,
                'ovic_products' => $this,
            )
        );

        return $html;
    }
}