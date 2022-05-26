<?php
/**
 * Template Before
 *
 * @return string
 *
 * @var $atts
 * @var $ovic_products
 */
?>
<?php
$width  = 300;
$height = 300;
if ($atts['product_image_size']) {
    if ($atts['product_image_size'] == 'custom') {
        $thumb_width  = $atts['product_custom_thumb_width'];
        $thumb_height = $atts['product_custom_thumb_height'];
    } else {
        list($size_width, $size_height) = explode('x', $atts['product_image_size']);
        $thumb_width  = $size_width;
        $thumb_height = $size_height;
    }
    if ($thumb_width > 0) {
        $width = $thumb_width;
    }
    if ($thumb_height > 0) {
        $height = $thumb_height;
    }
}
$product_item_class = array();
$product_list_class = array(
    'products',
    $atts['target'],
    'equal-container',
    'better-height',
);
$owl_settings = '';
if ($atts['list_style'] == 'grid') {
    $product_list_class[] = 'product-list-grid row';
    $product_item_class[] = $ovic_products->generate_boostrap($atts);
} elseif ($atts['list_style'] == 'owl') {
    $product_list_class[] = 'product-list-owl owl-slick ';
    $product_list_class[] = $atts['slides_rows_space'];
    $owl_settings         = $ovic_products->generate_carousel($atts);
}
$product_list_class = implode(' ', $product_list_class);
$setup_loop         = array(
    'width'  => $width,
    'height' => $height,
    'class'  => $product_item_class,
    'style'  => $atts['product_style'],
);
/**
 * SETUP LOOP
 */
$functions_loop_start = function () use ($product_list_class, $owl_settings, $atts, $setup_loop) {

    ecotech_woocommerce_setup_loop($setup_loop);

    if (isset($atts['is_editor'])) {
        $product_list_class .= ' shop-page';
    }

    if (isset($atts['columns'])) {
        $product_list_class .= ' columns-'.$atts['columns'];
    }

    $attr               = array(
        'class' => $product_list_class,
    );
    $attr['data-limit'] = $atts['limit'];
    if ($atts['pagination'] == 'load_more' || $atts['pagination'] == 'infinite') {
        $attr['data-next_page']  = '2';
        $attr['data-total_page'] = wc_get_loop_prop('total_pages');
    }
    $attr = apply_filters('ovic_wrapper_shortcode_product_attributes', $attr, $atts);
    $attr = array_map('esc_attr', $attr);

    $wrapper = rtrim("<ul");
    foreach ($attr as $name => $value) {
        $wrapper .= " $name=".'"'.$value.'"';
    }
    if ($atts['list_style'] == 'owl') {
        $wrapper .= " $owl_settings";
    }
    $wrapper .= '>';

    return $wrapper;
};
$functions_loop_end   = function () {
    return '</ul>';
};
/**
 * ACTIONS FUNCTIONS
 */
add_filter('woocommerce_product_loop_start', $functions_loop_start, 30);
add_filter('woocommerce_product_loop_end', $functions_loop_end, 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
/**
 * ACTION BEFORE SHORTCODE
 */
do_action('ovic_before_shortcode_products', $atts, $ovic_products);
