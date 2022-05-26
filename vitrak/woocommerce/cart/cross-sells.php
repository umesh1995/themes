<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     4.4.0
 * @var $cross_sells
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = ecotech_generate_carousel_products('woo_crosssell');

if ($cross_sells && !empty($data)) : ?>

    <section class="cross-sells products ovic-products <?php echo esc_attr($data['style']); ?> arrows-02 arrows-top">

        <?php
        $heading = !empty($data['title']) ? $data['title'] : esc_html__('You may be interested in&hellip;', 'ecotech');
        $heading = apply_filters('woocommerce_product_cross_sells_products_heading', $heading);
        ?>
        <h2 class="title"><?php echo esc_html($heading); ?></h2>

        <ul class="owl-slick products product-list-owl" <?php echo esc_attr($data['carousel']); ?>>

            <?php foreach ($cross_sells as $cross_sell) : ?>

                <?php
                $post_object = get_post($cross_sell->get_id());
                $classes     = array('product-item', $data['style']);

                setup_postdata($GLOBALS['post'] =& $post_object);
                ?>
                <li <?php wc_product_class($classes, $cross_sell); ?>>
                    <?php wc_get_template_part('product-style/content-product', $data['style']); ?>
                </li>

            <?php endforeach; ?>

            <?php
            wp_reset_postdata();
            wc_reset_loop();
            ?>

        </ul>

    </section>

<?php endif;
