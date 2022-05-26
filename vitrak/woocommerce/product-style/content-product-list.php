<?php
/**
 *
 * Name: Product Style List
 * Shortcode: false
 * Theme Option: false
 **/
?>
<?php
$functions = array(
    array( 'add_action', 'woocommerce_shop_loop_item_title', 'ecotech_product_list_categories', 5 ),
);
ecotech_add_action( $functions );
?>

    <div class="product-inner tooltip-top">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );
        ?>
        <div class="product-thumb images">
            <?php
            /**
             * Hook: woocommerce_before_shop_loop_item_title.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>
        </div>
        <div class="product-info">
            <div class="box-info">
                <div class="group-title">
                    <?php
                    /**
                     * Hook: woocommerce_shop_loop_item_title.
                     *
                     * @hooked woocommerce_template_loop_product_title - 10
                     */
                    do_action( 'woocommerce_shop_loop_item_title' );
                    /**
                     * Hook: woocommerce_after_shop_loop_item_title.
                     *
                     * @hooked woocommerce_template_loop_rating - 5
                     * @hooked woocommerce_template_loop_price - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item_title' );
                    ?>
                </div>
                <div class="group-button style-01">
                    <?php
                    do_action( 'ecotech_function_shop_loop_item_compare' );
                    do_action( 'ecotech_function_shop_loop_item_quickview' );
                    /**
                     * Hook: woocommerce_after_shop_loop_item.
                     *
                     * @hooked woocommerce_template_loop_product_link_close - 5
                     * @hooked woocommerce_template_loop_add_to_cart - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item' );
                    do_action( 'ecotech_function_shop_loop_item_wishlist' );
                    ?>
                </div>
            </div>
            <?php woocommerce_template_single_excerpt(); ?>
            <?php ecotech_template_loop_variable(); ?>
        </div>
    </div>
<?php
ecotech_add_action( $functions, true );
