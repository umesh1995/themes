<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     3.3.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * SETUP SHOP LOOP
 */
ecotech_woocommerce_setup_loop();

$columns       = wc_get_loop_prop( 'columns' );
$product_style = ecotech_get_option( 'shop_product_style', 'style-01' );
$list_style    = ecotech_get_option( 'shop_list_style', 'grid' );
if ( $list_style == 'list' )
{
    $product_style = 'style-01';
}
$class         = array(
	"products",
	"shop-page",
	"response-content",
	"columns-{$columns}",
	"ovic-products {$product_style}",
	"equal-container better-height",
);

/**
 *
 * SHOP CONTROL
 */
ecotech_control_before_shop_loop();
?>
<ul class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
