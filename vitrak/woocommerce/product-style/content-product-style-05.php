<?php
/**
 *
 * Name: Product Style 05
 * Shortcode: true
 * Theme Option: false
 **/
?>
<?php
global $product;

$metabox   = get_post_meta( $product->get_id(), '_custom_metabox_product_options', true );
$functions = array(
    array( 'remove_action', 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ),
    array( 'add_action', 'woocommerce_shop_loop_item_title', 'ecotech_product_list_brands', 5 ),
);
ecotech_add_action( $functions );
?>
    <div class="product-inner tooltip-left">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @removed woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );
        ?>
        <div class="product-thumb">
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>
            <?php if ( !ecotech_is_mobile( true ) ) : ?>
                <div class="group-button style-01">
                    <?php
                    /**
                     * woocommerce_after_shop_loop_item hook.
                     *
                     * @removed woocommerce_template_loop_product_link_close - 5
                     * @hooked woocommerce_template_loop_add_to_cart - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item' );
                    do_action( 'ecotech_function_shop_loop_item_wishlist' );
                    do_action( 'ecotech_function_shop_loop_item_quickview' );
//                    do_action( 'ecotech_function_shop_loop_item_compare' );
                    ?>
                </div>
            <?php endif; ?>
            <div class="product-info">
                <span class="shape" style="background-color: <?php if ( !empty( $metabox[ 'color' ] ) ) { echo esc_attr( $metabox[ 'color' ] ); } else { echo esc_attr( 'var(--main-color)' ); } ?>;"></span>
                <?php
                /**
                 * woocommerce_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_product_title - 10
                 */
                do_action( 'woocommerce_shop_loop_item_title' );
                if ( !empty( $metabox[ 'subtitle' ] ) ) {
                    echo '<div class="subtitle">' . esc_html( $metabox[ 'subtitle' ] ) . '</div>';
                }
                ?>
                <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );
                ?>
            </div>
        </div>
        <?php ecotech_function_shop_loop_item_countdown(); ?>
    </div>
<?php
ecotech_add_action( $functions, true );