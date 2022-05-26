<?php
/***
 * Core Name: WooCommerce
 * Version: 1.0.0
 * Author: Khanh
 */
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
/**
 *
 * QUICK VIEW
 */
if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
    // Class frontend
    $classes = YITH_WCQV_Frontend::get_instance();
    if ( get_option( 'yith-wcqv-enable' ) == 'yes' ) {
        add_action( 'init', function () use ( $classes ) {
            remove_action( 'woocommerce_after_shop_loop_item', array(
                $classes,
                'yith_add_quick_view_button'
            ), 15 );
        } );
        add_action( 'ecotech_function_shop_loop_item_quickview', array( $classes, 'yith_add_quick_view_button' ), 5 );
    }
}
/**
 *
 * WISHLIST
 */
if ( defined( 'YITH_WCWL' ) ) {
    if ( !function_exists( 'ecotech_function_shop_loop_item_wishlist' ) ) {
        function ecotech_function_shop_loop_item_wishlist()
        {
            echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
        }
    }
    add_action( 'ecotech_function_shop_loop_item_wishlist', 'ecotech_function_shop_loop_item_wishlist', 1 );
    /* Custom icon */
    add_filter( 'yith_wcwl_button_icon', function ( $icon_option ) {
        if ( $icon_option == '' ) {
            $icon_option = 'main-icon-heart ovic-wl-icon';
        }

        return $icon_option;
    } );
    add_filter( 'yith_wcwl_button_added_icon', function ( $added_icon_option ) {
        if ( $added_icon_option == '' ) {
            $added_icon_option = 'main-icon-heart ovic-wl-icon added';
        }

        return $added_icon_option;
    } );
}
/**
 *
 * COMPARE
 */
if ( class_exists( 'YITH_Woocompare' ) && get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) {
    global $yith_woocompare;
    $is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
    if ( $yith_woocompare->is_frontend() || $is_ajax ) {
        if ( $is_ajax ) {
            if ( !class_exists( 'YITH_Woocompare_Frontend' ) && file_exists( YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php' ) ) {
                require_once YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php';
            }
            $yith_woocompare->obj = new YITH_Woocompare_Frontend();
        }
        /* Remove button */
        remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
        /* Add compare button */
        if ( !function_exists( 'ecotech_wc_loop_product_compare_btn' ) ) {
            function ecotech_wc_loop_product_compare_btn()
            {
                global $product;
                if ( shortcode_exists( 'yith_compare_button' ) ) {
                    echo do_shortcode( '[yith_compare_button product_id="' . $product->get_id() . '"]' );
                } else {
                    if ( class_exists( 'YITH_Woocompare_Frontend' ) ) {
                        echo do_shortcode( '[yith_compare_button product_id="' . $product->get_id() . '"]' );
                    }
                }
            }
        }
        add_action( 'ecotech_function_shop_loop_item_compare', 'ecotech_wc_loop_product_compare_btn', 1 );
    }
}
/**
 *
 * WOOCOMMERCE CUSTOM SHOP CONTROL
 */
if ( !function_exists( 'ecotech_loop_shop_per_page' ) ) {
    function ecotech_loop_shop_per_page()
    {
        $products_perpage = ecotech_get_option( 'product_per_page', '12' );

        return $products_perpage;
    }
}
if ( !function_exists( 'ecotech_woof_products_query' ) ) {
    function ecotech_woof_products_query( $wr )
    {
        $products_perpage     = ecotech_get_option( 'product_per_page', '12' );
        $wr['posts_per_page'] = $products_perpage;

        return $wr;
    }
}
if ( !function_exists( 'ecotech_control_before_shop_loop' ) ) {
    function ecotech_control_before_shop_loop()
    {
        $template     = 'default';
        $is_shortcode = wc_get_loop_prop( 'is_shortcode' );
        if ( !$is_shortcode ) {
            wc_get_template( "product-control/{$template}-before-control.php",
                array(
                    'template_type' => $template,
                )
            );
        }
    }
}
if ( !function_exists( 'ecotech_control_after_shop_loop' ) ) {
    function ecotech_control_after_shop_loop()
    {
        $template     = 'default';
        $is_shortcode = wc_get_loop_prop( 'is_shortcode' );
        if ( !$is_shortcode ) {
            wc_get_template( "product-control/{$template}-after-control.php",
                array(
                    'template_type' => $template,
                )
            );
        }
    }
}

if ( !function_exists( 'ecotech_shop_display_per_page' ) ) {
    function ecotech_shop_display_per_page()
    {
        global $wp;
        $total   = wc_get_loop_prop( 'total' );
        $perpage = ecotech_get_option( 'product_per_page', '12' );
        $columns = ecotech_get_option( 'product_loop_columns' );
        $data    = array();
        for ( $i = 2; $i < 7; $i++ ) {
            $data[] = $i * $columns;
        }
        $i = 0;
        if ( '' === get_option( 'permalink_structure' ) ) {
            $form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ),
                add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
        }
        $text = esc_html__( 'Show', 'ecotech' );
        ?>
        <form class="per-page-form" method="GET" action="<?php echo esc_url( $form_action ); ?>">
            <select name="product_per_page" class="option-perpage">
                <?php
                $selected_all = '';
                if ( !in_array( $perpage, $data ) ) {
                    $data[] = $perpage;
                }
                if ( $perpage == $total ) {
                    echo 'selected';
                }
                $data = array_unique( $data );
                sort( $data );
                foreach ( $data as $datum ) {
                    $selected = '';
                    if ( $perpage == $datum ) {
                        $selected = 'selected';
                    }
                    echo '<option value="' . esc_attr( $datum ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $text . ' ' . $datum ) . '</option>';
                }
                ?>
                <option value="<?php echo esc_attr( $total ); ?>" <?php echo esc_attr( $selected_all ); ?>>
                    <?php echo esc_html__( 'Show All', 'ecotech' ); ?>
                </option>
            </select>
            <?php wc_query_string_form_fields( null,
                array( 'product_per_page', 'submit', 'paged', 'product-page' ) ); ?>
        </form>
        <?php
    }
}

if ( !function_exists( 'ecotech_shop_display_mode' ) ) {
    function ecotech_shop_display_mode()
    {
        global $wp;
        if ( '' === get_option( 'permalink_structure' ) ) {
            $form_action = remove_query_arg( array(
                'page',
                'paged',
                'product-page'
            ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
        }
        $list_style = ecotech_get_option( 'shop_list_style', 'grid' );
        ?>
        <div class="display-mode-control">
            <form class="display-mode" method="get" action="<?php echo esc_attr( $form_action ); ?>">
                <button type="submit" value="grid" name="shop_list_style"
                        class="mode-button mode-grid <?php if ( $list_style == 'grid' ) {
                            echo ' active';
                        } ?>">
                    <span class="icon fa fa-th"></span>
                </button>
                <button type="submit" value="list" name="shop_list_style"
                        class="mode-button mode-list <?php if ( $list_style == 'list' ) {
                            echo ' active';
                        } ?>">
                    <span class="icon fa fa-th-list"></span>
                </button>
                <?php wc_query_string_form_fields( null, array(
                    'shop_list_style',
                    'submit',
                    'paged',
                    'product-page'
                ) ); ?>
            </form>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_generate_carousel_products' ) ) {
    function ecotech_generate_carousel_products( $prefix )
    {
        $enable_product = ecotech_get_option( $prefix . '_enable', 'enable' );
        if ( $enable_product == 'disable' ) {
            return array();
        }
        $style_product = ecotech_get_option( $prefix . '_style', 'style-01' );
        $title_product = ecotech_get_option( $prefix . '_title', '' );
        $desktop       = ecotech_get_option( $prefix . '_desktop', 4 );
        $laptop        = ecotech_get_option( $prefix . '_laptop', 4 );
        $ipad          = ecotech_get_option( $prefix . '_ipad', 3 );
        $landscape     = ecotech_get_option( $prefix . '_landscape', 3 );
        $portrait      = ecotech_get_option( $prefix . '_portrait', 3 );
        $mobile        = ecotech_get_option( $prefix . '_mobile', 2 );
        $margin        = array( 30, 20, 10 );
        $data_slick    = apply_filters( 'ecotech_generate_carousel_' . $prefix . '_products', array(
                'infinite'     => false,
                'slidesMargin' => $margin[0],
                'slidesToShow' => (int)$desktop,
                'responsive'   => array(
                    array(
                        'breakpoint' => 1500,
                        'settings'   => array(
                            'slidesToShow' => (int)$laptop,
                        ),
                    ),
                    array(
                        'breakpoint' => 1200,
                        'settings'   => array(
                            'slidesToShow' => (int)$ipad,
                        ),
                    ),
                    array(
                        'breakpoint' => 992,
                        'settings'   => array(
                            'slidesToShow' => (int)$landscape,
                        ),
                    ),
                    array(
                        'breakpoint' => 768,
                        'settings'   => array(
                            'slidesMargin' => $margin[1],
                            'slidesToShow' => (int)$portrait,
                        ),
                    ),
                    array(
                        'breakpoint' => 480,
                        'settings'   => array(
                            'slidesMargin' => $margin[2],
                            'slidesToShow' => (int)$mobile,
                        ),
                    ),
                ),
            )
        );
        $generate      = ' data-slick=' . json_encode( $data_slick ) . ' ';

        return array(
            'title'    => $title_product,
            'style'    => $style_product,
            'carousel' => $generate,
        );
    }
}
if ( !function_exists( 'ecotech_woocommerce_setup_loop' ) ) {
    function ecotech_woocommerce_setup_loop( $args = array() )
    {
        $is_shortcode  = wc_get_loop_prop( 'is_shortcode' );
        $list_style    = ecotech_get_option( 'shop_list_style', 'grid' );
        $product_style = ecotech_get_option( 'shop_product_style', 'style-01' );
        $columns       = ecotech_get_option( 'product_loop_columns', 4 );
        $short_title   = ecotech_get_option( 'enable_short_title' );

        $classes = array();

        if ( $list_style == 'list' ) {
            $columns = 1;
        }

        $default = array(
            'width'      => '',
            'height'     => '',
            'class'      => $classes,
            'title'      => $short_title,
            'style'      => $product_style,
            'list_style' => $list_style,
            'columns'    => $columns,
        );

        $args = wp_parse_args( $args, $default );

        if ( $is_shortcode == true || !class_exists( 'Ovic_Addon_Toolkit' ) ) {
            unset( $args['columns'] );
            unset( $args['list_style'] );
        }

        foreach ( $args as $key => $value ) {
            wc_set_loop_prop( $key, $value );
        }
    }
}
if ( !function_exists( 'ecotech_get_size_image' ) ) {
    function ecotech_get_size_image()
    {
        global $product;
        // GET SIZE IMAGE SETTING
        $width  = 300;
        $height = 300;
        $size   = wc_get_image_size( 'shop_catalog' );
        if ( $size ) {
            $width  = $size['width'];
            $height = $size['height'];
        }
        $width  = wc_get_loop_prop( 'width' ) ? wc_get_loop_prop( 'width' ) : $width;
        $height = wc_get_loop_prop( 'height' ) ? wc_get_loop_prop( 'height' ) : $height;

        return apply_filters( 'ecotech_get_size_image_product',
            array(
                'width'  => $width,
                'height' => $height,
            )
        );
    }
}
/**
 *
 * COMMENT PAGINATION
 */
add_filter( 'woocommerce_comment_pagination_args', function () {
    return array(
        'prev_text' => esc_html__( 'Prev', 'ecotech' ),
        'next_text' => esc_html__( 'Next', 'ecotech' ),
        'type'      => 'list',
        'end_size'  => 1,
        'mid_size'  => 1,
    );
} );
/**
 *
 * PRODUCT THUMBNAIL
 */
if ( !function_exists( 'ecotech_template_loop_product_thumbnail' ) ) {
    function ecotech_template_loop_product_thumbnail()
    {
        global $product;

        $image_second       = '';
        $size_image         = ecotech_get_size_image();
        $crop               = true;
        $lazy_load          = true;
        $thumbnail_id       = $product->get_image_id();
        $gallery_ids        = $product->get_gallery_image_ids();
        $default_attributes = $product->get_default_attributes();
        $product_hover      = ecotech_get_option( 'product_hover', 'zoom' );
        $link               = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        if ( !empty( $default_attributes ) ) {
            $lazy_load = false;
        }
        $class       = '';
        $class_thumb = array(
            'thumb-link',
            'hover-' . $product_hover,
            'woocommerce-product-gallery__image',
        );
        if ( $product_hover == 'change' && !ecotech_is_mobile() && !empty( $gallery_ids[0] ) ) {
            $second_thumb = ecotech_resize_image( $gallery_ids[0], $size_image['width'], $size_image['height'], $crop,
                $lazy_load, true, 'wp-post-image' );
            $image_second = '<figure class="second-thumb">' . $second_thumb['img'] . '</figure>';
        } else {
            $class = 'wp-post-image';
        }
        $primary_thumb = ecotech_resize_image( $thumbnail_id, $size_image['width'], $size_image['height'], $crop,
            $lazy_load, true, $class );
        $image_thumb   = '<figure class="primary-thumb">' . $primary_thumb['img'] . '</figure>';
        ?>
        <div class="thumb-wrapper">
            <a class="<?php echo esc_attr( implode( ' ', $class_thumb ) ); ?>"
               href="<?php echo esc_url( $link ); ?>">
                <?php echo wp_specialchars_decode( $image_thumb . $image_second ); ?>
            </a>
        </div>
        <?php
    }
}
/**
 *
 * HEADER WISHLIST
 */
if ( !function_exists( 'ecotech_header_wishlist' ) ) {
    function ecotech_header_wishlist()
    {
        if ( class_exists( 'YITH_WCWL' ) ) : ?>
            <?php
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            $count        = YITH_WCWL()->count_products();
            if ( !empty( $wishlist_url ) ) : ?>
                <div class="block-wishlist block-woo">
                    <a class="woo-wishlist-link icon-link"
                       href="<?php echo esc_url( $wishlist_url ); ?>">
                        <span class="icon main-icon-heart">
                            <span class="count"><?php echo esc_html( $count ); ?></span>
                        </span>
                        <span class="text"><?php echo esc_html__( 'Wishlist', 'ecotech' ) ?></span>
                    </a>
                </div>
            <?php endif;
        endif;
    }
}
/**
 *
 * HEADER COMPARE
 */
if ( !function_exists( 'ecotech_header_compare' ) ) {
    function ecotech_header_compare()
    {
        if ( class_exists( 'YITH_Woocompare' ) ) :
            global $yith_woocompare; ?>
            <div class="block-compare yith-woocompare-widget">
                <a href="<?php echo esc_url( $yith_woocompare->obj->view_table_url() ); ?>"
                   class="compare added" rel="nofollow">
                    <span class="icon main-icon-reload"></span>
                    <span class="text"><?php echo esc_html__( 'Compare', 'ecotech' ) ?></span>
                </a>
            </div>
        <?php endif;
    }
}
if ( !function_exists( 'ecotech_header_cart_link' ) ) {
    function ecotech_header_cart_link( $layout = 'default' )
    {
        $count    = WC()->cart->get_cart_contents_count();
        $subtotal = WC()->cart->get_cart_subtotal();
        $title    = esc_html__( 'Cart', 'ecotech' );
        $header   = ecotech_get_header();
        if ( $header == 'style-04' || $header == 'style-05' || $header == 'style-08' || $header == 'style-09' || $header == 'style-10' )
            $title = esc_html__( 'Cart:', 'ecotech' );
        if ( $header == 'style-07' )
            $title = esc_html__( 'My Cart', 'ecotech' );
        ?>
        <a class="woo-cart-link icon-link"
           href="<?php echo wc_get_cart_url(); ?>"
           data-ecotech="<?php if ( $layout == 'default' ) {
               echo esc_attr( 'ecotech-dropdown' );
           } ?>">
            <span class="icon main-icon-basket">
                <span class="count"><?php echo esc_html( $count ); ?></span>
            </span>
            <span class="text"><?php echo esc_html( $title ); ?></span>
            <span class="total"><?php echo wp_specialchars_decode( $subtotal ); ?></span>
        </a>
        <?php
    }
}
if ( !function_exists( 'ecotech_header_mini_cart' ) ) {
    function ecotech_header_mini_cart( $layout = 'default' )
    {
        if ( $layout == 'popup' ) : ?>
            <div class="block-minicart popup">
                <?php
                ecotech_header_cart_link( $layout );
                ?>
            </div>
        <?php else : ?>
            <div class="block-minicart ecotech-dropdown">
                <?php
                ecotech_header_cart_link();
                the_widget( 'WC_Widget_Cart', 'title=' );
                ?>
            </div>
        <?php endif;
    }
}
if ( !function_exists( 'ecotech_header_mini_cart_popup' ) ) {
    function ecotech_header_mini_cart_popup()
    {
        ?>
        <div class="block-minicart-popup">
            <div class="minicart-head">
                <span class="title"><?php echo esc_html__( 'Shopping Cart', 'ecotech' ); ?></span>
                <a href="#" class="close-minicart"><span class="main-icon-close"></span></a>
            </div>
            <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_cart_link_fragment' ) ) {
    function ecotech_cart_link_fragment( $fragments )
    {
        $count    = WC()->cart->get_cart_contents_count();
        $subtotal = WC()->cart->get_cart_subtotal();

        $fragments['a.woo-cart-link .count'] = '<span class="count">' . esc_html( $count ) . '</span>';
        $fragments['a.woo-cart-link .total'] = '<span class="total">' . wp_specialchars_decode( $subtotal ) . '</span>';

        return $fragments;
    }
}
if ( !function_exists( 'ecotech_template_loop_product_title' ) ) {
    function ecotech_template_loop_product_title()
    {
        global $product;

        $link  = apply_filters( 'woocommerce_loop_product_link', $product->get_permalink(), $product );
        $class = apply_filters( 'woocommerce_product_loop_title_classes', 'product-title' );

        echo '<h2 class="' . esc_attr( $class ) . '"><a href="' . esc_url( $link ) . '">' . get_the_title() . '</a></h2>';
    }
}
if ( !function_exists( 'ecotech_function_shop_loop_item_countdown' ) ) {
    function ecotech_function_shop_loop_item_countdown()
    {
        global $product;

        $style         = 'style-01';
        $product_style = wc_get_loop_prop( 'style' );
        $date          = ecotech_get_max_date_sale( $product );
        $enable        = ecotech_get_option( 'enable_countdown_product' );

        if ( is_product() && $enable == 0 ) {
            return;
        }

        if ( $product->is_on_sale() ) {
            $date = apply_filters( 'ovic_change_datetime_countdown', $date, $product->get_id() );
        }

        if ( $date > 0 ) {

            if ( is_product() && $enable == 1 ) {
                $style = 'style-03';
            }

            if ( $product_style == 'style-07' ) {
                $style = 'style-03';
            }

            if ( $product_style == 'style-19' ) {
                $style = 'style-06';
                echo '<h3 class="countdown-title">' . esc_html__( 'Hurry Up! Offer End In:', 'ecotech' ) . '</h3>';
            }

            echo ecotech_do_shortcode( 'ovic_countdown', array(
                'style' => $style,
                'date'  => wp_date( 'm/j/Y g:i:s', $date ),
            ) );
        }
    }
}
if ( !function_exists( 'ecotech_get_max_date_sale' ) ) {
    function ecotech_get_max_date_sale( $product )
    {
        $sale_to = $product->get_date_on_sale_to();
        // Loop through variations
        if ( !empty( $product->get_children() ) ) {
            $timestamp = array();
            foreach ( $product->get_children() as $key => $variation_id ) {
                $variations = wc_get_product( $variation_id );
                if ( !empty( $variations ) && $variations->is_on_sale() && $variations->get_date_on_sale_to() != '' ) {
                    $sale_to     = $variations->get_date_on_sale_to();
                    $timestamp[] = $sale_to->getTimestamp();
                }
            }
            if ( !empty( $timestamp ) ) {
                return max( $timestamp );
            }
        }
        // Loop through simple
        if ( $product->is_on_sale() && $sale_to != '' ) {
            return $sale_to->getTimestamp();
        }

        return 0;
    }
}
if ( !function_exists( 'ecotech_sale_percent' ) ) {
    function ecotech_sale_percent()
    {
        global $product;

        $percent = '';
        if ( $product->get_type() == 'variable' ) {
            $available_variations = $product->get_variation_prices();
            $max_percent          = 0;
            if ( !empty( $available_variations['regular_price'] ) ) {
                foreach ( $available_variations['regular_price'] as $key => $regular_price ) {
                    $sale_price = $available_variations['sale_price'][ $key ];
                    if ( $sale_price < $regular_price ) {
                        $percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                        if ( $percent > $max_percent ) {
                            $max_percent = $percent;
                        }
                    }
                }
            }
            $percent = $max_percent;
        } elseif ( ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) ) {
            $percent = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
        }

        return $percent;
    }
}
if ( !function_exists( 'ecotech_get_stock_status' ) ) {
    function ecotech_get_stock_status()
    {
        global $product;

        $class        = 'in-stock';
        $text         = 'in stock';
        $availability = $product->get_availability();

        if ( !empty( $availability['availability'] ) ) {
            $class = $availability['class'];
            $text  = $availability['availability'];
        }
        wc_get_template(
            'single-product/stock.php',
            array(
                'product'      => $product,
                'class'        => $class,
                'availability' => $text,
            )
        );
    }
}
if ( !function_exists( 'ecotech_loop_sale_flash_percent' ) ) {
    function ecotech_loop_sale_flash_percent()
    {
        global $product;

        if ( $product->is_on_sale() ) {
            $percent = ecotech_sale_percent();
            ?>
            <div class="product-sale-off">
                <span class="percent">(<?php echo '-' . esc_html( $percent ) . '%'; ?>)</span>
            </div>
            <?php
        }
    }
}

if ( !function_exists( 'ecotech_ratting_single_product' ) ) {
    function ecotech_ratting_single_product()
    {
        global $product;
        if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
            return;
        }
        $rating_count = $product->get_rating_count();
        $average      = $product->get_average_rating();
        if ( $rating_count > 0 ) : ?>
            <div class="woocommerce-product-rating">
                <?php echo wc_get_rating_html( $average, $rating_count ); ?>
                <?php if ( comments_open() ) : ?>
                    <a href="#reviews" class="woocommerce-review-link" rel="nofollow">
                        <?php
                        printf( _n( '%s review', '%s reviews', $rating_count, 'ecotech' ), '<span class="count">' . esc_html( $rating_count ) . '</span>' );
                        ?>
                    </a>
                <?php endif ?>
            </div>
        <?php endif;
    }
}
if ( !function_exists( 'ecotech_get_star_rating_html' ) ) {
    function ecotech_get_star_rating_html( $html, $rating, $count )
    {
        global $product;

        if ( method_exists( $product, 'get_review_count' ) ) {

            $product_style = wc_get_loop_prop( 'style' );
            $review_count  = $product->get_review_count();
            $review_count  = zeroise( $review_count, 2 );
            $match         = array(
                'style-02',
                'style-03',
                'style-04',
                'style-06',
                'style-10',
            );

            if ( in_array( $product_style, $match ) ) {
                if ( $review_count <= 0 ) {
                    $html .= '<div class="star-rating"><span style="width:0"></span></div>';
                }
                $html .= '<strong class="rating-count">(' . $review_count . ')</strong>';
            }

            if ( $review_count > 0 || in_array( $product_style, $match ) ) {
                return '<div class="star-rating-wrap">' . $html . '</div>';
            }

        }

        return '';
    }
}
if ( !function_exists( 'ecotech_sale_process_availability' ) ) {
    function ecotech_sale_process_availability()
    {
        global $product;

        $units_sold   = get_post_meta( $product->get_id(), 'total_sales', true );
        $availability = $product->get_stock_quantity();
        if ( $availability ) {
            $total_percent = $availability + $units_sold;
            $percent       = 100 - round( ( ( $units_sold / $total_percent ) * 100 ), 0 );
        } else {
            $percent = 0;
        }
        ?>
        <div class="process-availability">
            <div class="availability-text">
                <span class="text available">
                <?php
                $stock = esc_html__( 'Unlimit', 'ecotech' );
                if ( !empty( $availability ) && $availability > 0 ) {
                    $stock = $availability;
                }
                echo sprintf( '%s <strong>%s</strong>', esc_html__( 'Available:', 'ecotech' ), $stock );
                ?>
                </span>
                <span class="text sold"><?php echo sprintf( '%s <strong>%s</strong>',
                        esc_html__( 'Sold:', 'ecotech' ), $units_sold ); ?></span>
            </div>
            <div class="availability-total total">
                <span class="process" style="width: <?php echo esc_attr( $percent ) . '%' ?>"></span>
            </div>
        </div>
        <?php
    }
}
/**
 * Retrieves the previous product.
 *
 * @param  bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
 * @param  array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
 * @param  string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
 *
 * @return WC_Product|false Product object if successful. False if no valid product is found.
 * @since 2.4.3
 *
 */
if ( !function_exists( 'ecotech_get_previous_product' ) ) {
    function ecotech_get_previous_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' )
    {
        if ( !class_exists( 'Ovic_WooCommerce_Adjacent_Products' ) ) {
            return false;
        }
        $product = new Ovic_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy, true );

        return $product->get_product();
    }
}

/**
 * Retrieves the next product.
 *
 * @param  bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
 * @param  array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
 * @param  string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
 *
 * @return WC_Product|false Product object if successful. False if no valid product is found.
 * @since 2.4.3
 *
 */
if ( !function_exists( 'ecotech_get_next_product' ) ) {
    function ecotech_get_next_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' )
    {
        if ( !class_exists( 'Ovic_WooCommerce_Adjacent_Products' ) ) {
            return false;
        }
        $product = new Ovic_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );

        return $product->get_product();
    }
}

if ( !function_exists( 'ecotech_single_product_pagination' ) ) {
    function ecotech_single_product_pagination()
    {
        // Show only products in the same category?
        $in_same_term   = apply_filters( 'ecotech_single_product_pagination_same_category', true );
        $excluded_terms = apply_filters( 'ecotech_single_product_pagination_excluded_terms', '' );
        $taxonomy       = apply_filters( 'ecotech_single_product_pagination_taxonomy', 'product_cat' );
        // Get previous and next products.
        $previous_product = ecotech_get_previous_product( $in_same_term, $excluded_terms, $taxonomy );
        $next_product     = ecotech_get_next_product( $in_same_term, $excluded_terms, $taxonomy );

        if ( !$previous_product && !$next_product ) {
            return;
        }
        ?>
        <nav class="ecotech-product-pagination">
            <?php if ( $previous_product ):
                $previous_permalink = apply_filters( 'woocommerce_loop_product_link',
                    $previous_product->get_permalink(),
                    $previous_product
                );
                ?>
                <a class="other-post prev" href="<?php echo esc_url( $previous_permalink ); ?>"
                   title="<?php echo esc_attr( $previous_product->get_name() ); ?>">
                    <span class="icon fa fa-angle-left"></span>
                    <figure>
                        <?php echo wp_specialchars_decode( $previous_product->get_image( array( 100, 100 ) ) ); ?>
                    </figure>
                </a>
            <?php endif; ?>
            <?php if ( $next_product ):
                $next_permalink = apply_filters( 'woocommerce_loop_product_link',
                    $next_product->get_permalink(),
                    $next_product
                );
                ?>
                <a class="other-post next" href="<?php echo esc_url( $next_permalink ); ?>"
                   title="<?php echo esc_attr( $next_product->get_name() ); ?>">
                    <span class="icon fa fa-angle-right"></span>
                    <figure>
                        <?php echo wp_specialchars_decode( $next_product->get_image( array( 100, 100 ) ) ); ?>
                    </figure>
                </a>
            <?php endif; ?>
        </nav>
        <?php
    }
}
if ( !function_exists( 'ecotech_product_excerpt_content' ) ) {
    function ecotech_product_excerpt_content( $count = 10 )
    {
        global $product;
        if ( !empty( $product->get_short_description() ) ):
            ?>
            <div class="excerpt-content">
                <?php
                if ( $count == null ) {
                    echo esc_html( $product->get_short_description() );
                } else {
                    echo wp_trim_words(
                        $product->get_short_description(), $count,
                        esc_html__( '...', 'ecotech' )
                    );
                }
                ?>
            </div>
        <?php
        endif;
    }
}
if ( !function_exists( 'ecotech_product_list_categories' ) ) {
    function ecotech_product_list_categories()
    {
        echo get_the_term_list( get_the_ID(),
            'product_cat',
            '<div class="cat-list">',
            ', ',
            '</div>'
        );
    }
}
if ( !function_exists( 'ecotech_product_list_brands' ) ) {
    function ecotech_product_list_brands()
    {
        global $product;

        $terms = get_the_terms( $product->get_id(), 'product_brand' );

        if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
            echo '<div class="brand-list">';

            foreach ( $terms as $term ) : ?>
                <?php
                $term_url = get_term_link( $term->term_id, 'product_brand' );
                $logo     = get_term_meta( $term->term_id, 'logo_id', true );
                ?>
                <div class="item">
                    <a href="<?php echo esc_url( $term_url ); ?>" class="link">
                        <figure><?php echo wp_get_attachment_image( $logo, 'full' ); ?></figure>
                    </a>
                </div>
            <?php endforeach;

            echo '</div>';
        }
    }
}
if ( !function_exists( 'ecotech_product_query' ) ) {
    function ecotech_product_query( $my_query )
    {
        if ( is_shop() || is_product_taxonomy() ) {
            $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( (string)wp_unslash( $_GET['orderby'] ) ) : wc_clean( get_query_var( 'orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.
            switch ( $orderby_value ) {
                case 'sale':
                    $my_query->set( 'meta_key', 'total_sales' );
                    $my_query->set( 'orderby', 'meta_value_num' );

                    break;

                case 'on-sale':
                    $product_ids_on_sale   = wc_get_product_ids_on_sale();
                    $product_ids_on_sale[] = 0;
                    $my_query->set( 'post__in', $product_ids_on_sale );
                    $my_query->set( 'orderby', 'post__in' );

                    break;

                case 'feature':
                    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                    $my_query->set( 'tax_query', array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'term_taxonomy_id',
                                'terms'    => $product_visibility_term_ids['featured'],
                            ),
                        )
                    );
                    $my_query->set( 'order', 'desc' );

                    break;
            };
        }
    }
}
/**
 *
 * SINGLE SHARE
 */
if ( !function_exists( 'ecotech_share_single_product' ) ) {
    function ecotech_share_single_product()
    {
        if ( ecotech_get_option( 'enable_share_product' ) == 1 ) : ?>
            <div class="share">
                <span class="title"><?php echo esc_html__( 'Share on:', 'ecotech' ); ?></span>
                <?php ecotech_share_social(); ?>
            </div>
        <?php endif;
    }
}
add_action( 'woocommerce_product_meta_end', 'ecotech_share_single_product', 10 );
/**
 *
 * END SUMMARY
 */
if ( !function_exists( 'ecotech_end_single_product_summary' ) ) {
    function ecotech_end_single_product_summary()
    {
        global $product;

        $metabox = get_post_meta( $product->get_id(), '_custom_metabox_product_options', true );
        ?>
        <div class="entry-summary-end">
            <div class="entry-inner">
                <?php if ( !empty( $metabox['size_chart'] ) ): ?>
                    <div class="size-guide ecotech-dropdown overlay">
                        <a href="#" data-ecotech="ecotech-dropdown">
                            <?php echo esc_html__( 'Size Guide', 'ecotech' ); ?>
                        </a>
                        <div class="content-guide">
                            <a href="#" class="close-entry" rel="nofollow"></a>
                            <h3 class="title-guide">
                                <?php echo esc_html__( 'Size Guide', 'ecotech' ); ?>
                            </h3>
                            <?php echo wpautop( $metabox['size_chart'] ); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ( !empty( $metabox['delivery'] ) ): ?>
                    <div class="delivery-return ecotech-dropdown overlay">
                        <a href="#" data-ecotech="ecotech-dropdown">
                            <?php echo esc_html__( 'Delivery & Return', 'ecotech' ); ?>
                        </a>
                        <div class="content-delivery">
                            <a href="#" class="close-entry" rel="nofollow"></a>
                            <h3 class="title-delivery">
                                <?php echo esc_html__( 'Delivery & Return', 'ecotech' ); ?>
                            </h3>
                            <?php echo wpautop( $metabox['delivery'] ); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php echo ecotech_do_shortcode( 'ovic_question', array(
                    'text_btn' => esc_html__( 'Ask a Question', 'ecotech' )
                ) ) ?>
                <?php
                if ( !empty( $metabox['other_info'] ) ) {
                    echo '<div class="other-info">' . wpautop( $metabox['other_info'] ) . '</div>';
                }
                ?>
            </div>
        </div>
        <?php
    }
}
add_action( 'woocommerce_single_product_summary', 'ecotech_end_single_product_summary', 100 );
/**
 *
 * HIDE COUNT WIDGET OVIC ATTRIBUTE
 */
add_filter( 'woocommerce_layered_nav_count', function ( $count, $term ) {
    $count_widget_attribute = ecotech_get_option( 'count_widget_attribute' );
    if ( $count_widget_attribute == 1 ) {
        return $count;
    } else {
        return '';
    }
}, 10, 2 );
/**
 *
 * PRODUCT ITEM LOOP VARIABLE
 */
if ( !function_exists( 'ecotech_template_loop_variable' ) ) {
    function ecotech_template_loop_variable()
    {
        global $product;

        if ( $product->get_type() == 'variable' ) : ?>
            <?php
            $attributes = $product->get_variation_attributes();
            $size_image = ecotech_get_size_image();
            if ( !empty( $attributes ) ) : ?>
                <form class="variations_form cart" method="post" enctype='multipart/form-data'
                      data-product_id="<?php echo absint( $product->get_id() ); ?>"
                      data-product_variations="false"
                      data-price="<?php echo esc_attr( $product->get_price_html() ); ?>"
                      data-custom_data="<?php echo absint( $size_image['width'] ); ?>x<?php echo absint( $size_image['height'] ); ?>">
                    <table class="variations">
                        <tbody>
                        <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                            <tr>
                                <td class="label"><label
                                            for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label>
                                </td>
                                <td class="value">
                                    <?php
                                    $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
                                    wc_dropdown_variation_attribute_options(
                                        array(
                                            'options'   => $options,
                                            'attribute' => $attribute_name,
                                            'product'   => $product,
                                            'selected'  => $selected,
                                        )
                                    );
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            <?php
            endif;
        endif;
    }
}