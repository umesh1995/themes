<?php

/**
 * Handle frontend scripts
 *
 * @package Ecotech/Classes
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
/**
 * Frontend scripts class.
 */
if (!class_exists('Ecotech_Assets')) {
    class Ecotech_Assets
    {
        /**
         * Contains an array of script handles registered by Ecotech.
         *
         * @var array
         */
        private static $scripts = array();
        /**
         * Contains an array of script handles registered by Ecotech.
         *
         * @var array
         */
        private static $styles = array();
        /**
         * Contains an array of script handles localized by Ecotech.
         *
         * @var array
         */
        private static $suffix              = '';
        private static $wp_localize_scripts = array();

        /**
         * Hook in methods.
         */
        public static function init()
        {
            /* check for developer mode */
            self::$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
            self::$suffix = '';

            add_action('wp_enqueue_scripts', array(__CLASS__, 'load_scripts'), 999);
            add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
            add_action('wp_print_scripts', array(__CLASS__, 'localize_printed_scripts'), 5);
            add_action('wp_print_footer_scripts', array(__CLASS__, 'localize_printed_scripts'), 5);
        }

        /**
         * Get google fonts.
         *
         * @return string
         */
        public static function fonts_url()
        {
            $subsets         = [
                'ru_RU' => 'cyrillic',
                'bg_BG' => 'cyrillic',
                'he_IL' => 'hebrew',
                'el'    => 'greek',
                'vi'    => 'vietnamese',
                'uk'    => 'cyrillic',
                'cs_CZ' => 'latin-ext',
                'ro_RO' => 'latin-ext',
                'pl_PL' => 'latin-ext',
                'hr_HR' => 'latin-ext',
                'hu_HU' => 'latin-ext',
                'sk_SK' => 'latin-ext',
                'tr_TR' => 'latin-ext',
                'lt_LT' => 'latin-ext',
            ];
            $subsets         = apply_filters('ecotech_frontend_google_font_subsets', $subsets);
            $font_families   = array();
            $font_families[] = 'Poppins:300,400,500,600,700';
            $query_args      = array(
                'family'  => implode('%7C', $font_families),
                'display' => 'swap',
            );
            $fonts_url       = add_query_arg($query_args, '//fonts.googleapis.com/css');

            $locale = get_locale();

            if (isset($subsets[$locale])) {
                $fonts_url .= '&subset=' . $subsets[$locale];
            }

            return esc_url($fonts_url);
        }

        /**
         * Get styles for the frontend.
         *
         * @return array
         */
        public static function get_styles()
        {
            $styles = array(
                'animate-css' => array(
                    'src'     => get_theme_file_uri('/assets/css/animate.min.css'),
                    'deps'    => array(),
                    'version' => '3.7.0',
                    'media'   => 'all',
                    'has_rtl' => false,
                ),
                'chosen'      => array(
                    'src'     => get_theme_file_uri('/assets/vendor/chosen/chosen.min.css'),
                    'deps'    => array(),
                    'version' => '1.8.7',
                    'media'   => 'all',
                    'has_rtl' => false,
                ),
                'bootstrap'   => array(
                    'src'     => get_theme_file_uri('/assets/css/bootstrap.min.css'),
                    'deps'    => array(),
                    'version' => '3.4.1',
                    'media'   => 'all',
                    'has_rtl' => false,
                ),
                'slick'       => array(
                    'src'     => get_theme_file_uri('/assets/vendor/slick/slick.min.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'media'   => 'all',
                    'has_rtl' => false,
                ),
            );
            /* STYLE MAIN */
            $styles['ecotech']      = array(
                'src'     => get_theme_file_uri('/assets/css/style' . self::$suffix . '.css'),
                'deps'    => array(),
                'version' => ECOTECH,
                'media'   => 'all',
                'has_rtl' => true,
            );
            $styles['ecotech-main'] = array(
                'src'     => get_stylesheet_uri(),
                'deps'    => array('font-awesome', 'main-icon', 'ecotech-fonts'),
                'version' => ECOTECH,
                'media'   => 'all',
                'has_rtl' => false,
            );
            $styles['vitrak-style'] = array(
                'src'     => get_theme_file_uri('/assets/css/style-vitrak.css'),
                'deps'    => array(),
                'version' => ECOTECH,
                'media'   => 'all',
                'has_rtl' => false,
            );
            if (class_exists('WeDevs_Dokan')) {
                $styles['ecotech-dokan'] = array(
                    'src'     => get_theme_file_uri('/assets/css/vendors/dokan' . self::$suffix . '.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'media'   => 'all',
                    'has_rtl' => false,
                );
            }
            if (class_exists('WCFM')) {
                $styles['ecotech-wcfm'] = array(
                    'src'     => get_theme_file_uri('/assets/css/vendors/wcfm' . self::$suffix . '.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'media'   => 'all',
                    'has_rtl' => false,
                );
            }
            if (class_exists('WCMp')) {
                $styles['ecotech-marketplace'] = array(
                    'src'     => get_theme_file_uri('/assets/css/vendors/marketplace' . self::$suffix . '.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'media'   => 'all',
                    'has_rtl' => false,
                );
            }
            if (ecotech_is_mobile()) {
                $styles['ecotech_mobile_version'] = array(
                    'src'     => get_theme_file_uri('/assets/css/style-mobile' . self::$suffix . '.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'media'   => 'all',
                    'has_rtl' => false,
                );
            }


            return apply_filters('ecotech_enqueue_styles', $styles);
        }

        /**
         * Register a script for use.
         *
         * @param  string $handle Name of the script. Should be unique.
         * @param  string $path Full URL of the script, or path of the script relative to the WordPress root directory.
         * @param  string[] $deps An array of registered script handles this script depends on.
         * @param  array|false|string $version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
         * @param  boolean $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
         *
         * @uses   wp_register_script()
         */
        private static function register_script($handle, $path, $deps = array('jquery'), $version = ECOTECH, $in_footer = true)
        {
            self::$scripts[] = $handle;
            wp_register_script($handle, $path, $deps, $version, $in_footer);
        }

        /**
         * Register and enqueue a script for use.
         *
         * @param  string $handle Name of the script. Should be unique.
         * @param  string $path Full URL of the script, or path of the script relative to the WordPress root directory.
         * @param  string[] $deps An array of registered script handles this script depends on.
         * @param  array|false|string $version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
         * @param  boolean $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
         *
         * @uses   wp_enqueue_script()
         */
        private static function enqueue_script($handle, $path = '', $deps = array('jquery'), $version = ECOTECH, $in_footer = true)
        {
            if (!in_array($handle, self::$scripts, true) && $path) {
                self::register_script($handle, $path, $deps, $version, $in_footer);
            }
            wp_enqueue_script($handle);
        }

        /**
         * Register a style for use.
         *
         * @param  string $handle Name of the stylesheet. Should be unique.
         * @param  string $path Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
         * @param  string[] $deps An array of registered stylesheet handles this stylesheet depends on.
         * @param  array|false|string $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
         * @param  string $media The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
         * @param  boolean $has_rtl If has RTL version to load too.
         *
         * @uses   wp_register_style()
         */
        private static function register_style($handle, $path, $deps = array(), $version = ECOTECH, $media = 'all', $has_rtl = false)
        {
            self::$styles[] = $handle;
            wp_register_style($handle, $path, $deps, $version, $media);
            if ($has_rtl) {
                wp_style_add_data($handle, 'rtl', 'replace');
                if (self::$suffix != '') {
                    wp_style_add_data($handle, 'suffix', self::$suffix);
                }
            }
        }

        /**
         * Register and enqueue a styles for use.
         *
         * @param  string $handle Name of the stylesheet. Should be unique.
         * @param  string $path Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
         * @param  string[] $deps An array of registered stylesheet handles this stylesheet depends on.
         * @param  array|false|string $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
         * @param  string $media The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
         * @param  boolean $has_rtl If has RTL version to load too.
         *
         * @uses   wp_enqueue_style()
         */
        private static function enqueue_style($handle, $path = '', $deps = array(), $version = ECOTECH, $media = 'all', $has_rtl = false)
        {
            if (!in_array($handle, self::$styles, true) && $path) {
                self::register_style($handle, $path, $deps, $version, $media, $has_rtl);
            }
            wp_enqueue_style($handle);
        }

        /**
         * Register all Ecotech scripts.
         */
        private static function register_scripts()
        {
            $deps = array(
                'jquery',
                'bootstrap',
                'chosen',
                'slick'
            );
            if (class_exists('Elementor\Plugin') && Elementor\Plugin::$instance->preview->is_preview_mode()) {
                $deps[] = 'ecotech-countdown';
            }
            $register_scripts = array(
                'ecotech'           => array(
                    'src'     => get_theme_file_uri('/assets/js/frontend' . self::$suffix . '.js'),
                    'deps'    => $deps,
                    'version' => ECOTECH,
                ),
                'ecotech-sticky'    => array(
                    'src'     => get_theme_file_uri('/assets/js/sticky' . self::$suffix . '.js'),
                    'deps'    => array('jquery'),
                    'version' => ECOTECH,
                ),
                'mobile-menu'       => array(
                    'src'     => get_theme_file_uri('/assets/vendor/mobile-menu/mobile-menu.min.js'),
                    'deps'    => array('jquery'),
                    'version' => ECOTECH,
                ),
                'ecotech-admin'     => array(
                    'src'     => get_theme_file_uri('/assets/js/admin.min.js'),
                    'deps'    => array('jquery'),
                    'version' => ECOTECH,
                ),
                /* https://harvesthq.github.io/chosen/ */
                'chosen'            => array(
                    'src'     => get_theme_file_uri('/assets/vendor/chosen/chosen.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '1.8.7',
                ),
                /* http://hilios.github.io/jQuery.countdown/documentation.html */
                'countdown'         => array(
                    'src'     => get_theme_file_uri('/assets/vendor/countdown/countdown.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '2.2.0',
                ),
                'ecotech-countdown' => array(
                    'src'     => get_theme_file_uri('/assets/js/countdown' . self::$suffix . '.js'),
                    'deps'    => array('countdown'),
                    'version' => ECOTECH,
                ),
                /* https://getbootstrap.com/ */
                'bootstrap'         => array(
                    'src'     => get_theme_file_uri('/assets/js/bootstrap.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '3.4.1',
                ),
                /* http://kenwheeler.github.io/slick/ */
                'slick'             => array(
                    'src'     => get_theme_file_uri('/assets/vendor/slick/slick.min.js'),
                    'deps'    => array('jquery'),
                    'version' => ECOTECH,
                ),
                /* https://github.com/gromo/jquery.scrollbar/ */
                'scrollbar'         => array(
                    'src'     => get_theme_file_uri('/assets/vendor/scrollbar/scrollbar.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '0.2.10',
                ),
                /* http://dimsemenov.com/plugins/magnific-popup/ */
                'magnific-popup'    => array(
                    'src'     => get_theme_file_uri('/assets/vendor/magnific-popup/magnific-popup.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '1.1.0',
                ),
                /* https://isotope.metafizzy.co/ */
                'isotope-pkgd'      => array(
                    'src'     => get_theme_file_uri('/assets/vendor/isotope/isotope.pkgd.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '3.0.6',
                ),
                'packery-mode-pkgd' => array(
                    'src'     => get_theme_file_uri('/assets/vendor/isotope/packery-mode.pkgd.min.js'),
                    'deps'    => array('jquery'),
                    'version' => '2.0.1',
                ),
                'ecotech-isotope'   => array(
                    'src'     => get_theme_file_uri('/assets/js/isotope' . self::$suffix . '.js'),
                    'deps'    => array('imagesloaded', 'isotope-pkgd', 'packery-mode-pkgd'),
                    'version' => ECOTECH,
                ),
            );
            foreach ($register_scripts as $name => $props) {
                self::register_script($name, $props['src'], $props['deps'], $props['version']);
            }
        }

        /**
         * Register all Ecotech styles.
         */
        private static function register_styles()
        {
            $register_styles = array(
                'ecotech-admin'     => array(
                    'src'     => get_theme_file_uri('/assets/css/admin.min.css'),
                    'deps'    => array('font-awesome', 'main-icon'),
                    'version' => ECOTECH,
                    'has_rtl' => false,
                ),
                'ecotech-fonts'     => array(
                    'src'     => self::fonts_url(),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'media'   => 'all',
                    'has_rtl' => false,
                ),
                'ecotech-edit-post' => array(
                    'src'     => get_theme_file_uri('/assets/css/edit-post.min.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'has_rtl' => false,
                ),
                'font-awesome'      => array(
                    'src'     => get_theme_file_uri('/assets/css/fontawesome.min.css'),
                    'deps'    => array(),
                    'version' => '4.7.0',
                    'has_rtl' => false,
                ),
                'main-icon'         => array(
                    'src'     => get_theme_file_uri('/assets/vendor/main-icon/style' . self::$suffix . '.css'),
                    'deps'    => array(),
                    'version' => '1.0.0',
                    'has_rtl' => false,
                ),
                'scrollbar'         => array(
                    'src'     => get_theme_file_uri('/assets/vendor/scrollbar/scrollbar.min.css'),
                    'deps'    => array(),
                    'version' => '0.2.10',
                    'has_rtl' => false,
                ),
                'magnific-effect'   => array(
                    'src'     => get_theme_file_uri('/assets/vendor/magnific-popup/magnific-effect.css'),
                    'deps'    => array(),
                    'version' => '1.1.0',
                    'has_rtl' => false,
                ),
                'magnific-popup'    => array(
                    'src'     => get_theme_file_uri('/assets/vendor/magnific-popup/magnific-popup.min.css'),
                    'deps'    => array('magnific-effect'),
                    'version' => '1.1.0',
                    'has_rtl' => false,
                ),
                'mobile-menu'       => array(
                    'src'     => get_theme_file_uri('/assets/vendor/mobile-menu/mobile-menu.min.css'),
                    'deps'    => array(),
                    'version' => ECOTECH,
                    'has_rtl' => false,
                ),
            );
            foreach ($register_styles as $name => $props) {
                self::register_style($name, $props['src'], $props['deps'], $props['version'], 'all', $props['has_rtl']);
            }
        }

        /**
         * Register/queue backend scripts.
         *
         * @param $hook_suffix
         */
        public static function admin_scripts($hook_suffix)
        {
            self::register_scripts();
            self::register_styles();
            // Styles.
            if (($hook_suffix === 'post-new.php' || $hook_suffix === 'post.php')) {
                self::enqueue_style('ecotech-edit-post');
            }
            self::enqueue_style('ecotech-admin');
            // Script.
            self::enqueue_script('ecotech-admin');
        }

        public static function dequeue_scripts()
        {
            global $post;

            /* DEQUEUE SCRIPTS - OPTIMIZER */
            if (is_a($post, 'WP_Post') && !has_shortcode($post->post_content, 'contact-form-7')) {
                wp_dequeue_style('contact-form-7');
                wp_dequeue_script('contact-form-7');
            }
            /* WOOCOMMERCE */
            if (class_exists('WooCommerce')) {
                if (WC()->cart->get_cart_contents_count() <= 0) {
                    wp_dequeue_script('wc-cart-fragments');
                }
                if (class_exists('YITH_WCQV_Frontend')) {
                    wp_dequeue_style('yith-quick-view');
                }
                if (class_exists('YITH_WCWL')) {
                    $page_id = yith_wcwl_object_id(get_option('yith_wcwl_wishlist_page_id'));
                    if (!is_page($page_id)) {
                        wp_dequeue_script('prettyPhoto');
                        wp_dequeue_script('jquery-selectBox');
                        wp_dequeue_style('woocommerce_prettyPhoto_css');
                        wp_dequeue_style('jquery-selectBox');
                        wp_dequeue_style('yith-wcwl-main');
                        wp_dequeue_style('yith-wcwl-user-main');
                    }
                    wp_dequeue_style('yith-wcwl-font-awesome');
                }
                /* PLUGIN SIZE CHART */
                if (class_exists('Size_Chart_For_Woocommerce')) {
                    $size_chart = false;
                    if (is_product()) {
                        $size_chart = get_post_meta($post->ID, 'prod-chart', true);
                    }
                    if (!$size_chart) {
                        wp_dequeue_style('size-chart-for-woocommerce');
                        wp_dequeue_style('size-chart-for-woocommerce-select2');
                        wp_dequeue_style('size-chart-for-woocommerce-jquery-modal');
                        wp_dequeue_style('size-chart-for-woocommerce-jquery-modal-default-theme');
                        wp_dequeue_script('size-chart-for-woocommerce');
                        wp_dequeue_script('size-chart-for-woocommerce-jquery-select2');
                        wp_dequeue_script('size-chart-for-woocommerce-jquery-modal');
                        wp_dequeue_script('size-chart-for-woocommerce-jquery-editable-js');
                        wp_dequeue_script('size-chart-for-woocommerce-jquery-modal-default-theme');
                    }
                }
                if (class_exists('Vc_Manager')) {
                    wp_dequeue_script('vc_woocommerce-add-to-cart-js');
                }
            }
        }

        /**
         * Register/queue frontend scripts.
         */
        public static function load_scripts()
        {
            self::register_scripts();
            self::register_styles();
            // Global frontend scripts.
            if (!class_exists('Ovic_Addon_Toolkit')) {
                self::enqueue_style('mobile-menu');
                self::enqueue_script('mobile-menu');
            }
            if (!ecotech_is_mobile()) {
                self::enqueue_style('scrollbar');
                self::enqueue_script('scrollbar');
            }
            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
            self::enqueue_script('ecotech');
            // Add inline script
            $ace_script = ecotech_get_option('ace_script');
            if (!empty($ace_script)) {
                wp_add_inline_script('ecotech', $ace_script);
            }
            // CSS Styles.
            $enqueue_styles = self::get_styles();
            if (!empty($enqueue_styles)) {
                foreach ($enqueue_styles as $handle => $args) {
                    if (!isset($args['has_rtl'])) {
                        $args['has_rtl'] = false;
                    }
                    self::enqueue_style(
                        $handle,
                        $args['src'],
                        $args['deps'],
                        $args['version'],
                        $args['media'],
                        $args['has_rtl']
                    );
                }
            }
            // Optimizer scripts
            self::dequeue_scripts();
        }

        /**
         * Localize a Ecotech script once.
         *
         * @since 2.3.0 this needs less wp_script_is() calls due to https://core.trac.wordpress.org/ticket/28404 being added in WP 4.0.
         *
         * @param  string $handle Script handle the data will be attached to.
         */
        private static function localize_script($handle)
        {
            if (!in_array($handle, self::$wp_localize_scripts, true) && wp_script_is($handle)) {
                $data = self::get_script_data($handle);
                if (!$data) {
                    return;
                }
                $name                        = str_replace('-', '_', $handle) . '_params';
                self::$wp_localize_scripts[] = $handle;
                wp_localize_script($handle, $name, apply_filters($name, $data));
            }
        }

        /**
         * Return data for script handles.
         *
         * @param  string $handle Script handle the data will be attached to.
         *
         * @return array|bool
         */
        private static function get_script_data($handle)
        {
            switch ($handle) {
                case 'ecotech':
                    $params = array(
                        'ajaxurl'          => admin_url('admin-ajax.php'),
                        'security'         => wp_create_nonce('ecotech_ajax_frontend'),
                        'ecotech_ajax_url' => Ecotech_Ajax::get_endpoint('%%endpoint%%'),
                        'ajax_comment'     => ecotech_get_option('enable_ajax_comment'),
                        'tab_warning'      => sprintf(
                            '<strong>%s</strong> %s',
                            esc_html__('Warning!', 'ecotech'),
                            esc_html__('Can not Load Data.', 'ecotech')
                        ),
                        'is_mobile'        => (bool)ecotech_is_mobile(),
                        'is_preview'       => class_exists('OVIC_CORE') ? OVIC_CORE()->is_elementor_editor() : false,
                        'sticky_menu'      => ecotech_get_option('sticky_menu', 'none'),
                        'enable_lazy'      => (bool)ecotech_get_option('enable_lazy_load'),
                        'disable_equal'    => (bool)ecotech_get_option('disable_equal'),
                    );
                    break;
                case 'ecotech-admin':
                    $params = array(
                        'security' => wp_create_nonce('ecotech_ajax_admin'),
                    );
                    break;
                default:
                    $params = false;
            }

            return apply_filters('ecotech_get_script_data', $params, $handle);
        }

        /**
         * Localize scripts only when enqueued.
         */
        public static function localize_printed_scripts()
        {
            foreach (self::$scripts as $handle) {
                self::localize_script($handle);
            }
        }
    }

    Ecotech_Assets::init();
}
