<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

$hook = array(
    array('remove_action', 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10),
    array('remove_action', 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20),
    array('remove_action', 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15),
    array('add_action', 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 0),
    array('add_action', 'woocommerce_single_product_summary', 'ecotech_function_shop_loop_item_countdown', 25),
);
ecotech_add_action($hook);

$attachment_ids = $product->get_gallery_image_ids();
$class_wrapper  = array('single-product-wrapper');
if (!empty($attachment_ids) && has_post_thumbnail()) {
    $class_wrapper[] = 'has-gallery';
}

/* DATA CAROUSEL */
$sidebar      = ecotech_get_option('sidebar_product_layout', 'left');
$sidebar_name = ecotech_get_option('product_used_sidebar', 'product-widget-area');
if (!is_active_sidebar($sidebar_name)) {
    $sidebar = 'full';
}
$data_slide = json_encode(array(
    'infinite'     => false,
    'slidesMargin' => 20,
    'slidesToShow' => 3,
    'responsive'   => array(
        array(
            'breakpoint' => 992,
            'settings'   => array(
                'slidesMargin' => 15,
            ),
        ),
        array(
            'breakpoint' => 480,
            'settings'   => array(
                'slidesMargin' => 10,
            ),
        ),
    ),
));

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.

    return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <div class="<?php echo esc_attr(implode(' ', $class_wrapper)); ?>"
         data-slick="<?php echo esc_attr($data_slide); ?>">
        <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action('woocommerce_before_single_product_summary');
        ?>

        <div class="summary entry-summary">
            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action('woocommerce_single_product_summary');
            ?>
        </div>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>

<?php ecotech_add_action($hook, true); ?>
