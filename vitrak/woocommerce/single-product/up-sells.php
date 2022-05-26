<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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
 * @version     3.0.0
 * @var $upsells
 */

if ( ! defined('ABSPATH')) {
    exit;
}

$data = ecotech_generate_carousel_products('woo_upsell');

if ($upsells && ! empty($data)) : ?>

    <section class="up-sells upsells products ovic-products <?php echo esc_attr($data['style']); ?> arrows-02 arrows-top">

        <?php
        $heading = ! empty($data['title']) ? $data['title'] : esc_html__('Up Sells Products', 'ecotech');
        ?>
        <h2 class="title"><?php echo esc_html($heading); ?></h2>

        <ul class="owl-slick products product-list-owl" <?php echo esc_attr($data['carousel']); ?>>

            <?php foreach ($upsells as $upsell) : ?>

                <?php
                $post_object = get_post($upsell->get_id());
                $classes     = array('product-item', $data['style']);

                setup_postdata($GLOBALS['post'] =& $post_object);
                ?>
                <li <?php wc_product_class($classes, $upsell); ?>>
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
