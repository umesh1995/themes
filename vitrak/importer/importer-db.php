<?php
// Prevent direct access to this file
defined( 'ABSPATH' ) || die( 'Direct access to this file is not allowed.' );
/**
 * Core class.
 *
 * @package  Ovic
 * @since    1.0
 */
if ( !class_exists( 'Ovic_Import_Database_Content' ) ) {
    class Ovic_Import_Database_Content
    {
        public function __construct()
        {
            // Filter Sample Data Menu
            add_filter( 'import_sample_data_packages', array( $this, 'sample_data_packages' ) );
            add_filter( 'import_sample_data_required_plugins', array( $this, 'required_plugins' ) );
            add_filter( 'import_sample_data_demo_site_pattern', array( $this, 'site_pattern' ) );
            add_filter( 'import_sample_data_theme_option_key', array( $this, 'theme_option_key' ) );

            add_action( 'import_sample_data_after_install_sample_data', array( $this, 'after_install_data' ), 10, 1 );
        }

        public function site_pattern( $demo_site_pattern )
        {
            return 'https?(%3A|:)[%2F\\/]+(rc|demo|ecotech)\.kutethemes\.net';
        }

        public function theme_option_key( $theme_option_key )
        {
            return '_ovic_customize_options';
        }

        public function required_plugins( $plugins )
        {
            return array(
                array(
                    'name'        => 'Revolution Slider',
                    'slug'        => 'revslider',
                    'source'      => 'https://plugins.kutethemes.net/revslider.zip',
                    'source_type' => 'external',
                    'file_path'   => 'revslider/revslider.php',
                ),
                array(
                    'name'        => 'Ovic Addon Toolkit',
                    'slug'        => 'ovic-addon-toolkit',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'ovic-addon-toolkit/plugin-toolkit.php',
                ),
                array(
                    'name'        => 'Elementor',
                    'slug'        => 'elementor',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'elementor/elementor.php',
                ),
                array(
                    'name'        => 'WooCommerce',
                    'slug'        => 'woocommerce',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'woocommerce/woocommerce.php',
                ),
                array(
                    'name'        => 'Ovic: Product Bundle',
                    'slug'        => 'ovic-product-bundle',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'ovic-product-bundle/addon.php',
                ),
                array(
                    'name'        => 'Mailchimp for WordPress',
                    'slug'        => 'mailchimp-for-wp',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'mailchimp-for-wp/mailchimp-for-wp.php',
                ),
                array(
                    'name'        => 'AJAX Search for WooCommerce',
                    'slug'        => 'ajax-search-for-woocommerce',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'ajax-search-for-woocommerce/ajax-search-for-woocommerce.php',
                ),
                array(
                    'name'        => 'WooCommerce Variation Swatches',
                    'slug'        => 'woo-product-variation-swatches',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'woo-product-variation-swatches/woo-product-variation-swatches.php',
                ),
                array(
                    'name'        => 'YITH WooCommerce Wishlist',
                    'slug'        => 'yith-woocommerce-wishlist',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'yith-woocommerce-wishlist/init.php',
                ),
                array(
                    'name'        => 'YITH WooCommerce Quick View',
                    'slug'        => 'yith-woocommerce-quick-view',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'yith-woocommerce-quick-view/init.php',
                ),
                array(
                    'name'        => 'Child Theme Configurator',
                    'slug'        => 'child-theme-configurator',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'child-theme-configurator/child-theme-configurator.php',
                ),
                array(
                    'name'        => 'WordPress Importer',
                    'slug'        => 'wordpress-importer',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'wordpress-importer/wordpress-importer.php',
                ),
                array(
                    'name'        => 'Contact Form 7',
                    'slug'        => 'contact-form-7',
                    'source'      => 'repo',
                    'source_type' => 'repo',
                    'file_path'   => 'contact-form-7/wp-contact-form-7.php',
                ),
            );
        }

        public function sample_data_packages( $packages )
        {
            return array(
                'main' => array(
                    'id'        => 'main',
                    'name'      => 'Main Demo',
                    'thumbnail' => wp_get_theme()->get_screenshot(),
                    'demo'      => 'https://ecotech.kutethemes.net',
                    'download'  => get_theme_file_path( 'importer/data/sample-data.zip' ),
                    'tags'      => array( 'all', 'simple' ),
                    'main'      => true,
                ),
            );
        }

        public function after_install_data( $package )
        {
            $menus    = get_terms(
                'nav_menu',
                array(
                    'hide_empty' => true,
                )
            );
            $home_url = get_home_url();
            if ( !empty( $menus ) ) {
                foreach ( $menus as $menu ) {
                    $items = wp_get_nav_menu_items( $menu->term_id );
                    if ( !empty( $items ) ) {
                        foreach ( $items as $item ) {
                            $_menu_item_url = get_post_meta( $item->ID, '_menu_item_url', true );
                            if ( !empty( $_menu_item_url ) ) {
                                $_menu_item_url = str_replace( 'https://ecotech.kutethemes.net', $home_url, $_menu_item_url );
                                $_menu_item_url = str_replace( 'http://ecotech.kutethemes.net', $home_url, $_menu_item_url );
                                update_post_meta( $item->ID, '_menu_item_url', $_menu_item_url );
                            }
                        }
                    }
                }
            }
        }
    }

    new Ovic_Import_Database_Content();
}
