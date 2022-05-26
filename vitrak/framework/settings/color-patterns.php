<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !function_exists( 'ecotech_enqueue_inline_css' ) ) {
    function ecotech_enqueue_inline_css()
    {
        $css          = html_entity_decode( ecotech_get_option( 'ace_style', '' ) );
        $main_color   = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'main_color',
            'metabox_main_color',
            '#f05127'
        );
        $container    = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'main_container',
            'metabox_main_container',
            '1410'
        );
        $visible_item = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'vertical_visible_item'
        );

        $css .= '
        body{
            --main-color: ' . $main_color . ';
            --main-color-bb: ' . $main_color . 'bb;
        }
        ';
        if ( !empty( $container ) && $container != 1140 ) {
            $container_padding = $container + 30;
            $media             = $container_padding < 1200 ? 1200 : ( $container_padding + 30 );
            $css               .= '
            @media (min-width: ' . $media . 'px){
                body{
                    --main-container: ' . $container . ';
                }
                .elementor-section.elementor-section-boxed:not(.elementor-has-width) > .elementor-container{
                    width: ' . $container . 'px;
                }
                .elementor-section-stretched.elementor-section-full_width .elementor-section.elementor-section-boxed:not(.elementor-has-width) > .elementor-container,
                .elementor-section-stretched.elementor-section-boxed:not(.elementor-has-width) > .elementor-container,
                .site > .elementor > .elementor-inner,
                .container{
                    width: ' . $container_padding . 'px;
                }
                body.wcfm-store-page .site #main{
                    width: ' . $container_padding . 'px !important;
                }
            }
            ';
        }
        if ( !empty( $visible_item ) ) {
            $css .= '
            .box-nav-vertical .vertical-menu > .menu-item:nth-child(n+' . ( $visible_item + 1 ) . '){
                display: none;
            }';
        }

        $css = preg_replace( '/\s+/', ' ', $css );

        wp_add_inline_style( 'ecotech-main',
            apply_filters( 'ecotech_custom_inline_css', $css, $main_color, $container )
        );
    }

    add_action( 'wp_enqueue_scripts', 'ecotech_enqueue_inline_css', 999 );
}