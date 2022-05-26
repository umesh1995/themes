<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
// Theme version.
if (!defined('ECOTECH')) {
    define('ECOTECH', wp_get_theme()->get('Version'));
}
if (!function_exists('ecotech_theme_setup')) {
    function ecotech_theme_setup()
    {
        // Set the default content width.
        $GLOBALS['content_width'] = 1400;
        /*
         * Make theme available for translation.
         * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/blank
         * If you're building a theme based on Twenty Seventeen, use a find and replace
         * to change 'ecotech' to the name of your theme in all the template files.
         */
        load_theme_textdomain('ecotech', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        add_theme_support('custom-background');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'widgets',
            )
        );

        /*
		 * Enable support for Post Formats.
		 *
		 * See: https://wordpress.org/support/article/post-formats/
		 */
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
                'gallery',
                'status',
                'audio',
                'chat',
            )
        );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(
            array(
                'primary' => esc_html__('Primary Menu', 'ecotech'),
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Support WooCommerce
        add_theme_support('woocommerce', apply_filters(
            'ecotech_woocommerce_args',
            array(
                'product_grid' => array(
                    'default_columns' => 3,
                    'default_rows'    => 4,
                    'min_columns'     => 2,
                    'max_columns'     => 6,
                    'min_rows'        => 1,
                ),
            )
        ));
        if (ecotech_get_option('disable_zoom') != 1) {
            add_theme_support('wc-product-gallery-zoom');
        }
        if (ecotech_get_option('disable_lightbox') != 1) {
            add_theme_support('wc-product-gallery-lightbox');
        }
        add_theme_support('wc-product-gallery-slider');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');

        // Add support for editor styles.
        add_theme_support('editor-styles');

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls.
        add_theme_support('custom-line-height');

        // Add support for experimental link color control.
        add_theme_support('experimental-link-color');

        // Add support for experimental cover block spacing.
        add_theme_support('custom-spacing');
    }

    add_action('after_setup_theme', 'ecotech_theme_setup');
}
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if (!function_exists('ecotech_widgets_init')) {
    function ecotech_widgets_init()
    {
        // Arguments used in all register_sidebar() calls.
        $shared_args = array(
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '<span class="arrow"></span></h2>',
        );

        $sidebars = array(
            'widget-area'         => array(
                'name'        => esc_html__('Widget Area', 'ecotech'),
                'id'          => 'widget-area',
                'description' => esc_html__('Add widgets here to appear in your blog sidebar.', 'ecotech'),
            ),
            'post-widget-area'    => array(
                'name'        => esc_html__('Post Widget Area', 'ecotech'),
                'id'          => 'post-widget-area',
                'description' => esc_html__('Add widgets here to appear in your post sidebar.', 'ecotech'),
            ),
            'shop-widget-area'    => array(
                'name'        => esc_html__('Shop Widget Area', 'ecotech'),
                'id'          => 'shop-widget-area',
                'description' => esc_html__('Add widgets here to appear in your shop sidebar.', 'ecotech'),
            ),
            'product-widget-area' => array(
                'name'        => esc_html__('Product Widget Area', 'ecotech'),
                'id'          => 'product-widget-area',
                'description' => esc_html__('Add widgets here to appear in your Product sidebar.', 'ecotech'),
            ),
        );

        $multi_sidebar = ecotech_get_option('multi_sidebar');

        if (is_array($multi_sidebar) && !empty($multi_sidebar)) {
            foreach ($multi_sidebar as $sidebar) {
                if (!empty($sidebar)) {
                    $sidebar_id            = sanitize_key('custom-sidebar-' . $sidebar['add_sidebar']);
                    $sidebars[$sidebar_id] = array(
                        'name' => $sidebar['add_sidebar'],
                        'id'   => $sidebar_id,
                    );
                }
            }
        }

        foreach ($sidebars as $sidebar) {
            register_sidebar(
                array_merge($shared_args, $sidebar)
            );
        }
    }

    add_action('widgets_init', 'ecotech_widgets_init');
}
/**
 * Custom Body Class.
 */
if (!function_exists('ecotech_body_class')) {
    function ecotech_body_class($classes)
    {
        $theme_version       = wp_get_theme()->get('Version');
        $page_main_container = ecotech_theme_option_meta('_custom_page_side_options', null, 'page_main_container', '');
        $main_skin           = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'main_skin',
            'metabox_main_skin',
            'organic'
        );
        $rtl_bg              = ecotech_get_option('enable_rtl_bg', 1);
        $classes[]           = 'skin-' . $main_skin;
        if (ecotech_is_mobile()) {
            $layout    = ecotech_get_option('mobile_layout', 'style-01');
            $classes[] = "ecotech-enable-mobile";
            $classes[] = "ecotech-mobile-{$layout}";
        }
        $classes[] = $page_main_container;
        $classes[] = "ecotech-v{$theme_version}";
        if (class_exists('WooCommerce')) {
            $classes[] = "has-mini-cart";
        }
        if (class_exists('YITH_WCWL') && !empty(YITH_WCWL()->get_wishlist_url())) {
            $classes[] = "has-wishlist";
        }
        if (is_rtl() && $rtl_bg == 1) {
            $classes[] = 'ovic-rtl-bg';
        }

        return $classes;
    }

    add_filter('body_class', 'ecotech_body_class');
}
if (!function_exists('ecotech_check_hide_title')) {
    /**
     * Check hide title.
     *
     * @param  bool  $val  default value.
     *
     * @return bool
     */
    function ecotech_check_hide_title($val)
    {
        if (defined('ELEMENTOR_VERSION')) {
            $current_doc = Elementor\Plugin::instance()->documents->get(get_the_ID());
            if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
                $val = false;
            }
        }

        return $val;
    }

    add_filter('ecotech_page_title', 'ecotech_check_hide_title');
}
/**
 * Wrapper function to deal with backwards compatibility.
 */
if (!function_exists('ecotech_body_open')) {
    function ecotech_body_open()
    {
        if (function_exists('wp_body_open')) {
            wp_body_open();
        } else {
            do_action('wp_body_open');
        }
    }
}
/**
 * Functions theme helper.
 */
require get_theme_file_path('framework/settings/helpers.php');
/**
 * Enqueue scripts and styles.
 */
require get_theme_file_path('framework/settings/enqueue.php');
/**
 * Functions add inline style inline.
 */
require get_theme_file_path('framework/settings/color-patterns.php');
/**
 * Functions plugin load.
 */
require get_theme_file_path('framework/settings/plugins-load.php');
/**
 * Functions theme AJAX.
 */
require get_theme_file_path('framework/classes/core-ajax.php');
/**
 * Functions theme breadcrumbs.
 */
require get_theme_file_path('framework/classes/breadcrumbs.php');
/**
 * Functions theme options.
 */
require get_theme_file_path('framework/settings/options.php');
/**
 * Functions metabox options.
 */
require get_theme_file_path('framework/settings/metabox.php');
/**
 * Functions theme.
 */
require get_theme_file_path('framework/function-theme.php');
/**
 * Functions blog.
 */
require get_theme_file_path('framework/function-blog.php');
/**
 * Functions WooCommerce.
 */
if (class_exists('WooCommerce')) {
    require get_theme_file_path('framework/woocommerce/template-hook.php');
}
/**
 * Functions Widget.
 */
if (class_exists('WooCommerce')) {
    require get_theme_file_path('framework/widgets/widget-product-filter.php');
    require get_theme_file_path('framework/widgets/widget-price-filter.php');
}
