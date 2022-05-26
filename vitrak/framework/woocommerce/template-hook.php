<?php
/***
 * Core Name: WooCommerce
 * Version: 1.0.0
 * Author: Khanh
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
include_once dirname(__FILE__).'/template-functions.php';
/**
 *
 * GLOBAL PRODUCTS QUERY
 */
add_action('woocommerce_product_query', 'ecotech_product_query');
/**
 *
 * REMOVE CSS
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
/**
 *
 * RATTING
 */
add_filter('woocommerce_product_get_rating_html', 'ecotech_get_star_rating_html', 10, 3);
/**
 *
 * REMOVE PAGE TITLE
 */
add_filter('woocommerce_show_page_title', '__return_false');
/**
 *
 * REMOVE BREADCRUMB
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
/**
 *
 * REMOVE SUB CATEGORIES
 */
add_filter('woocommerce_before_output_product_categories',
    function () {
        return '<ul class="shop-page columns-'.esc_attr(wc_get_loop_prop('columns')).'">';
    }
);
add_filter('woocommerce_after_output_product_categories',
    function () {
        return '</ul>';
    }
);
call_user_func('remove'.'_'.'filter', 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');
/**
 *
 * REMOVE "woocommerce_template_loop_product_link_open"
 */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
/**
 *
 * REMOVE DESCRIPTION HEADING, INFOMATION HEADING
 */
add_filter('woocommerce_product_description_heading', function () {
    return '';
});
add_filter('woocommerce_product_additional_information_heading', function () {
    return '';
});
/**
 *
 * CUSTOM CATALOG ORDERING
 */
add_filter('woocommerce_catalog_orderby',
    function ($options) {
        $options            = array(
            'menu_order' => __('Default Sorting', 'ecotech'),
            'popularity' => __('Popularity', 'ecotech'),
            'rating'     => __('Average Rating', 'ecotech'),
            'date'       => __('Latest', 'ecotech'),
            'price'      => __('Price: Low To High', 'ecotech'),
            'price-desc' => __('Price: High To Low', 'ecotech'),
        );
        $options['sale']    = esc_html__('Sale', 'ecotech');
        $options['on-sale'] = esc_html__('On-Sale', 'ecotech');
        $options['feature'] = esc_html__('Feature', 'ecotech');

        return $options;
    }
);
/**
 *
 * CUSTOM PRODUCT POST PER PAGE
 */
add_filter('loop_shop_per_page', 'ecotech_loop_shop_per_page', 20);
add_filter('woof_products_query', 'ecotech_woof_products_query', 20);
/**
 *
 * CUSTOM SHOP CONTROL
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
/**
 *
 * PRODUCT THUMBNAIL
 */
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'ecotech_template_loop_product_thumbnail', 10);
/**
 *
 * CUSTOM PRODUCT NAME
 */
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'ecotech_template_loop_product_title', 10);
/**
 *
 * WOOCOMMERCE PAGE TITLE
 */
add_filter('woocommerce_show_page_title', '__return_false');
/**
 *
 * HOOK RELATED ITEMS
 */
add_filter('woocommerce_output_related_products_args',
    function ($args) {
        $args['posts_per_page'] = ecotech_get_option('woo_related_perpage', '6');

        return $args;
    }
);
/**
 *
 * HOOK CROSS SELL
 */
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');
/**
 *
 * HOOK MINI CART
 */
add_filter('woocommerce_add_to_cart_fragments', 'ecotech_cart_link_fragment');
/**
 *
 * HOOK MY ACCOUNT
 */
remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 4);
/**
 *
 * FILTER MINI CART THUMBNAIL
 */
add_filter('woocommerce_cart_item_thumbnail',
    function ($thumbnail, $cart_item, $cart_item_key) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

        return $_product->get_image(120);
    }, 10, 3
);
/**
 *
 * FILTER PRODUCT THUMBNAIL
 */
add_filter('woocommerce_get_image_size_gallery_thumbnail',
    function () {
        $size = array(
            'width'  => 90,
            'height' => 90,
            'crop'   => 1,
        );

        return $size;
    }
);
/**
 *
 * CUSTOM RATING SINGLE
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'ecotech_ratting_single_product', 9);
/**
 *
 * VENDOR HOOK
 */
// Dokan
if (class_exists('WeDevs_Dokan')) {
//    add_filter( 'dokan_product_variations_per_page', function (){ return 12; } );
    add_action('dokan_dashboard_wrap_before', 'woocommerce_output_content_wrapper');
    add_action('dokan_dashboard_wrap_after', 'woocommerce_output_content_wrapper_end');
    add_action('woocommerce_shop_loop_item_title', 'ecotech_dokan_sold_by_text', 6);
    add_action('woocommerce_single_product_summary', 'ecotech_dokan_sold_by_text', 6);
    if (!function_exists('ecotech_dokan_sold_by_text')) {
        function ecotech_dokan_sold_by_text()
        {
            global $product;
            if ($product) {
                $author_id = get_post_field('post_author', $product->get_id());
                $author    = get_user_by('id', $author_id);
                echo apply_filters( 'ovic_dokan_sold_by_text',
                    sprintf( '<a class="by-vendor-name-link" href="%s"><span class="text">%s</span> %s</a>',
                        esc_url( dokan_get_store_url( $author->ID ) ),
                        esc_html__( 'Sold By', 'ecotech' ),
                        esc_html( $author->display_name )
                    ), $author );
            }
        }
    }
}
// WCFM
// ...
if (class_exists('WC_Vendors')) {
    remove_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
    add_action('woocommerce_shop_loop_item_title', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
}
// WC Marketplace
if (class_exists('WCMp')) {
    add_filter('wcmp_sold_by_text', function ($text, $id) {
        return '<span class="text">'.$text.'</span>';
    }, 10, 2);
    if (!function_exists('ecotech_wcmp_sold_by_text')) {
        function ecotech_wcmp_sold_by_text()
        {
            global $WCMp;
            remove_action('woocommerce_after_shop_loop_item', array(
                $WCMp->vendor_caps,
                'wcmp_after_add_to_cart_form'
            ), 6);
            remove_action('woocommerce_product_meta_start', array(
                $WCMp->vendor_caps,
                'wcmp_after_add_to_cart_form'
            ), 25);
            add_action('woocommerce_shop_loop_item_title', array($WCMp->vendor_caps, 'wcmp_after_add_to_cart_form'), 6);
            add_action('woocommerce_single_product_summary', array(
                $WCMp->vendor_caps,
                'wcmp_after_add_to_cart_form'
            ), 6);
        }
    }
    add_action('init', 'ecotech_wcmp_sold_by_text');
}
/**
 *
 * QUANTITY ARROWS
 */
add_action('woocommerce_before_quantity_input_field', function () {
    echo '<a onclick="this.parentNode.querySelector(\'input[type=number]\').stepDown()"  class="arrow minus quantity-minus"></a>';
}, 10);
add_action('woocommerce_after_quantity_input_field', function () {
    echo '<a onclick="this.parentNode.querySelector(\'input[type=number]\').stepUp()" class="arrow plus quantity-plus"></a>';
}, 10);