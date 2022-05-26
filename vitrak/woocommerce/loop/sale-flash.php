<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product;
$product_style = wc_get_loop_prop( 'style' );
if ( $product_style == 'style-12' ) {
    $class = 'special-font';
} else {
    $class = '';
}

$html = '';

/* LABEL SALE */
if ( $product->is_on_sale() ) {
    $percent = ecotech_sale_percent();
    $html    .= '<span class="onsale product-label">';
    $html    .= '<span class="percent">-' . esc_html( $percent ) . '%</span>';
    $html    .= '<span class="text">' . esc_html__( 'Sale', 'ecotech' ) . '</span>';
    $html    .= '</span>';
}
/* LABEL NEW */
$datestamp = strtotime( get_the_time( 'Y-m-d' ) );
$newness   = ecotech_get_option( 'product_newness', 0 );
if ( $newness > 0 && ( time() - ( 60 * 60 * 24 * (int)$newness ) ) < (int)$datestamp ) {
    $html .= '<span class="onnew product-label"><span class="text">' . esc_html__( 'New',
            'ecotech' ) . '</span></span>';
}
/* LABEL FEATURED */
if ( $product->is_featured() ) {
    $html .= '<span class="featured product-label"><span class="text">' . esc_html__( 'Hot',
            'ecotech' ) . '</span></span>';
}
/* LABEL STOCK */
if ( !$product->is_in_stock() && $product->is_type( 'variable' ) && $product->is_type( 'external' ) ) {
    $html .= '<span class="out-of-stock product-label"><span class="text">' . esc_html__( 'Sold out',
            'ecotech' ) . '</span></span>';
}


/* LABEL WRAPPER */
if ( !empty( $html ) ) {
    echo apply_filters( 'woocommerce_sale_flash',
        '<div class="product-labels ' . $class . '">' . wp_specialchars_decode( $html ) . '</div>', $post, $product
    );
}

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
