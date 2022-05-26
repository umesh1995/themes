<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<?php echo woocommerce_maybe_show_product_subcategories(); ?>
<div class="shop-control shop-before-control">
    <h1 class="woocommerce-products-header__title page-title">
        <span><?php woocommerce_page_title(); ?></span>
    </h1>
    <div class="control-right">
        <?php ecotech_shop_display_mode(); ?>
        <div class="ordering-wrap">
            <p class="ordering-title"><?php echo esc_html__( 'Sort by', 'ecotech' ); ?></p>
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>
</div>
