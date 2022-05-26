<?php
/**
 *
 * Name: Product Style 08
 * Shortcode: true
 * Theme Option: false
 **/
?>
<?php
$functions = array(
    array('remove_action', 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10),
    array('add_action', 'woocommerce_shop_loop_item_title', 'ecotech_product_list_categories', 5),
);
ecotech_add_action($functions);
?>
    <div class="product-inner">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @removed woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>
        <div class="product-thumb">
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
        </div>
        <div class="product-info">
            <?php
            /**
             * woocommerce_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */
            do_action('woocommerce_shop_loop_item_title');
            /**
             * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
        </div>
    </div>
<?php
ecotech_add_action($functions, true);