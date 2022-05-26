<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.

if (ecotech_is_mobile()) {
    include_once dirname(__FILE__).'/function-mobile.php';
}

add_filter('ovic_menu_toggle_mobile', '__return_false');
add_filter('ovic_menu_locations_mobile', 'ecotech_menu_locations_mobile', 10, 2);
add_filter('ovic_override_footer_template', 'ecotech_footer_template');
add_filter('elementor/icons_manager/native', 'ecotech_elementor_icons');
add_action('dynamic_sidebar_before', 'ecotech_dynamic_sidebar_before', 10, 2);
add_action('dynamic_sidebar_after', 'ecotech_dynamic_sidebar_after', 10, 2);
add_action('dgwt/wcas/search_query/args', 'ecotech_search_query_args');
add_action('ovic_install_mobile_menu', 'ecotech_install_mobile_vertical', 10, 2);
add_filter('elementor/fonts/additional_fonts', 'ecotech_elementor_fonts');

/**
 *
 * ajax search query
 */
if (!function_exists('ecotech_search_query_args')) {
    function ecotech_search_query_args($args)
    {
        if (!empty($_REQUEST['product_cat'])) {

            $product_cat = sanitize_text_field($_REQUEST['product_cat']);

            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array($product_cat),
            );
        }

        return $args;
    }
}
/**
 *
 * dynamic sidebar
 */
if (!function_exists('ecotech_dynamic_sidebar_before')) {
    function ecotech_dynamic_sidebar_before()
    {
        if (!is_admin()) {
            if (ecotech_is_mobile()) :?>
                <div class="sidebar-head">
                    <span class="title"><?php echo esc_html__('Sidebar', 'ecotech'); ?></span>
                    <a href="#" class="close-sidebar"><span class="main-icon-close"></span></a>
                </div>
            <?php endif;
            echo '<div class="sidebar-inner">';
        }
    }
}
if (!function_exists('ecotech_dynamic_sidebar_after')) {
    function ecotech_dynamic_sidebar_after()
    {
        if (!is_admin()) {
            echo '</div>';
        }
    }
}
/**
 *
 * TEMPLATE HEADER
 */
if (!function_exists('ecotech_header_template')) {
    function ecotech_header_template()
    {
        if (ecotech_is_mobile()) {
            ecotech_mobile_template();
        } else {
            $sticky_menu = ecotech_get_option('sticky_menu', 'none');
            $banner_id   = ecotech_theme_option_meta(
                '_custom_metabox_theme_options',
                'header_banner',
                'metabox_header_banner',
                ''
            );

            if ($sticky_menu == 'template') {
                get_template_part('templates-parts/header', 'sticky');
            }
            if (!empty($banner_id)) {
                ecotech_get_template(
                    "templates-parts/header-banner.php",
                    array(
                        'banner_id' => $banner_id,
                    )
                );
            }
            get_template_part('templates/header/header', ecotech_get_header());
            if (!class_exists('Ovic_Megamenu_Settings')) {
                ecotech_mobile_menu('primary');
            }
        }
    }
}
if (!function_exists('ecotech_footer_template')) {
    function ecotech_footer_template()
    {
        return ecotech_get_footer();
    }
}
if (!function_exists('ecotech_menu_locations_mobile')) {
    function ecotech_menu_locations_mobile($menus, $locations)
    {
        $primary_menu = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            null,
            "metabox_primary_menu"
        );
        if (!empty($primary_menu)) {
            $term = get_term_by('slug', $primary_menu, 'nav_menu');
            if (!is_wp_error($term) && !empty($term)) {
                return array($primary_menu);
            }
        }
        if (empty($menus) && !empty($locations['primary'])) {
            $mobile_menu = wp_get_nav_menu_object($locations['primary']);
            $menus[]     = $mobile_menu->slug;
        }

        return $menus;
    }
}
if (!function_exists('ecotech_install_mobile_vertical')) {
    function ecotech_install_mobile_vertical($menus, $locations)
    {
        $vertical_menu = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'vertical_menu',
            'metabox_vertical_menu'
        );
        if (!empty($vertical_menu) && class_exists('Ovic_Megamenu_Settings')) {
            Ovic_Megamenu_Settings::install_mobile_menu(array($vertical_menu), array(
                'is_ajax' => OVIC_CORE()->get_config('mobile_menu'),
                'default' => 'category',
                'class'   => 'mobile-category-menu',
                'title'   => esc_html__('Category', 'ecotech'),
            ));
        }
    }
}
/**
 *
 * PRIMARY MENU
 */
if (!function_exists('ecotech_primary_menu')) {
    function ecotech_primary_menu($layout = 'horizontal')
    {
        $enable_metabox = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            null,
            "enable_metabox_options"
        );
        $primary_menu   = '';
        if ($enable_metabox == 1) {
            $primary_menu = ecotech_theme_option_meta(
                '_custom_metabox_theme_options',
                null,
                "metabox_primary_menu"
            );
        }
        if (!empty($primary_menu)) {
            $term = get_term_by('slug', $primary_menu, 'nav_menu');
            if (!is_wp_error($term) && !empty($term)) {
                wp_nav_menu(array(
                    'menu'            => $primary_menu,
                    'theme_location'  => $primary_menu,
                    'depth'           => 3,
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'ecotech-nav main-menu '.$layout.'-menu',
                    'megamenu_layout' => $layout,
                ));
            }
        } else {
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'menu'            => 'primary',
                    'theme_location'  => 'primary',
                    'depth'           => 3,
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'ecotech-nav main-menu '.$layout.'-menu',
                    'megamenu_layout' => $layout,
                ));
            }
        }
    }
}
if (!function_exists('ecotech_header_menu_bar')) {
    function ecotech_header_menu_bar()
    {
        $title = esc_html__('Main Menu', 'ecotech');
        ?>
        <div class="mobile-block block-menu-bar main">
            <a href="#" class="menu-bar menu-toggle main" data-index="1">
                <span class="icon main-icon-menu"></span>
                <span class="text"><?php echo esc_html($title); ?></span>
            </a>
        </div>
        <?php
    }
}
/**
 *
 * VERTICAL MENU
 */
if (!function_exists('ecotech_header_vertical')) {
    function ecotech_header_vertical()
    {
        $vertical_menu = ecotech_theme_option_meta('_custom_metabox_theme_options', 'vertical_menu');
        if (!empty($vertical_menu)) {
            $always_open    = ecotech_get_option('vertical_always_open');
            $title          = ecotech_theme_option_meta('_custom_metabox_theme_options', 'vertical_title');
            $visible_item   = ecotech_theme_option_meta('_custom_metabox_theme_options', 'vertical_visible_item');
            $all_text       = ecotech_theme_option_meta('_custom_metabox_theme_options', 'vertical_all_text');
            $close_text     = ecotech_theme_option_meta('_custom_metabox_theme_options', 'vertical_close_text');
            $vertical_title = !empty($title) ? $title : esc_html__('All departments', 'ecotech');
            ecotech_get_template(
                "templates-parts/header-vertical.php",
                array(
                    'vertical_menu'  => $vertical_menu,
                    'always_open'    => $always_open,
                    'vertical_title' => $vertical_title,
                    'visible_item'   => $visible_item,
                    'all_text'       => $all_text,
                    'close_text'     => $close_text,
                )
            );
        }
    }
}
/**
 *
 * HEADER SUB MENU
 */
if (!function_exists('ecotech_header_submenu')) {
    function ecotech_header_submenu($menu_location, $depth = 2)
    {
        $header_menu = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            $menu_location,
            "metabox_{$menu_location}"
        );
        if (!empty($header_menu)) {
            do_action("ecotech_before_header_menu_{$header_menu}", $header_menu);
            wp_nav_menu(array(
                'menu'           => $header_menu,
                'theme_location' => $header_menu,
                'link_before'    => '<span class="text">',
                'link_after'     => '</span>',
                'depth'          => $depth,
                'menu_class'     => 'ovic-menu header-submenu '.$menu_location,
            ));
            do_action("ecotech_after_header_menu_{$header_menu}", $header_menu);
        }
    }
}
/**
 *
 * HEADER MESSAGE
 */
if (!function_exists('ecotech_header_message')) {
    function ecotech_header_message()
    {
        $header_message = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'header_message',
            'metabox_header_message',
            ''
        );
        if (!empty($header_message)) {
            ecotech_get_template(
                "templates-parts/header-message.php",
                array(
                    'message' => $header_message,
                )
            );
        }
    }
}
/**
 *
 * HEADER INFO
 */
if (!function_exists('ecotech_header_info')) {
    function ecotech_header_info()
    {
        $header_info = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'header_info',
            'metabox_header_info',
            ''
        );
        if (!empty($header_info)) {
            ecotech_get_template(
                "templates-parts/header-info.php",
                array(
                    'header_info' => $header_info,
                )
            );
        }
    }
}
/**
 *
 * HEADER SEARCH
 */
if (!function_exists('ecotech_header_social')) {
    function ecotech_header_social()
    {
        $socials = ecotech_get_option('user_all_social');
        if (!empty($socials)) {
            ecotech_get_template(
                "templates-parts/header-social.php",
                array(
                    'socials' => $socials,
                )
            );
        }
    }
}
/**
 *
 * HEADER SEARCH
 */
if (!function_exists('ecotech_header_search')) {
    function ecotech_header_search($category = true, $text = '')
    {
        ecotech_get_template(
            "templates-parts/header-search.php",
            array(
                'category' => $category,
                'text'     => $text,
            )
        );
    }
}
/**
 *
 * HEADER SEARCH POPUP
 */
if (!function_exists('ecotech_header_search_popup')) {
    function ecotech_header_search_popup($category = false, $text = '')
    {
        ?>
        <div class="block-search ecotech-dropdown">
            <a data-ecotech="ecotech-dropdown" class="woo-search-link" href="#">
                <span class="icon main-icon-search"></span>
                <span class="text"><?php echo esc_html__('Search', 'ecotech'); ?></span>
            </a>
            <?php
            ecotech_get_template(
                "templates-parts/header-search.php",
                array(
                    'category' => $category,
                    'text'     => $text,
                )
            );
            ?>
        </div>
        <?php
    }
}
/**
 *
 * HEADER ACCOUNT MENU
 */
if (!function_exists('ecotech_header_user')) {
    function ecotech_header_user($text = '')
    {
        ecotech_get_template(
            "templates-parts/header-user.php",
            array(
                'text' => $text,
            )
        );
    }
}
/**
 *
 * POPUP NEWSLETTER
 */
if (!function_exists('ecotech_popup_newsletter')) {
    function ecotech_popup_newsletter()
    {
        global $post;
        $enable = ecotech_get_option('enable_popup');
        if ($enable != 1) {
            return;
        }
        if (isset($_COOKIE['ecotech_disabled_popup_by_user']) && $_COOKIE['ecotech_disabled_popup_by_user'] == 'true') {
            return;
        }
        $page = (array) ecotech_get_option('popup_page');
        if (isset($post->ID) && is_array($page) && in_array($post->ID, $page) && $post->post_type == 'page') {
            wp_enqueue_style('magnific-popup');
            wp_enqueue_script('magnific-popup');
            get_template_part('templates-parts/popup', 'newsletter');
        }
    }
}
/**
 *
 * HEAD BANNER
 */
if (!function_exists('ecotech_head_banner')) {
    function ecotech_head_banner()
    {
        get_template_part('templates-parts/head', 'banner');
    }
}
/**
 *
 * CUSTOM MOBILE MENU
 */
if (!function_exists('ecotech_header_mobile')) {
    function ecotech_header_mobile()
    {
        $header_options = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'mobile_header',
            'metabox_mobile_header',
            'style-01'
        );
        get_template_part('templates/mobile/mobile', $header_options);
    }
}
if (!function_exists('ecotech_before_mobile_menu')) {
    function ecotech_before_mobile_menu($menu_locations, $data_menus)
    {
        ecotech_get_template(
            "templates-parts/mobile-header.php",
            array(
                'menu_locations' => $menu_locations,
                'data_menus'     => $data_menus,
            )
        );
    }

    add_action('ovic_before_html_mobile_menu', 'ecotech_before_mobile_menu', 10, 2);
}
if (!function_exists('ecotech_after_mobile_menu')) {
    function ecotech_after_mobile_menu($menu_locations, $data_menus)
    {
        ecotech_get_template(
            "templates-parts/mobile-footer.php",
            array(
                'menu_locations' => $menu_locations,
                'data_menus'     => $data_menus,
            )
        );
    }

    add_action('ovic_after_html_mobile_menu', 'ecotech_after_mobile_menu', 10, 2);
}
/**
 *
 * MEGAMENU ICON
 */
if (!function_exists('ecotech_field_icon_add_icons')) {
    function ecotech_field_icon_add_icons($icon)
    {
        ecotech_get_template("templates-parts/icon-options.php");

        return ecotech_get_icon_options($icon);
    }

    add_filter('ovic_field_icon_add_icons', 'ecotech_field_icon_add_icons');
}
/**
 *
 * MEGAMENU ICON
 */
if (!function_exists('ecotech_megamenu_options_icons')) {
    function ecotech_megamenu_options_icons()
    {
        ecotech_get_template("templates-parts/icon-megamenu.php");

        return ecotech_get_icon_megamenu();
    }

    add_filter('ovic_menu_icons_setting', 'ecotech_megamenu_options_icons');
}
if (!function_exists('ecotech_elementor_icons')) {
    function ecotech_elementor_icons($tabs)
    {
        $tabs['main_icon'] = [
            'name'          => 'main_icon',
            'label'         => esc_html__('Font Theme', 'ecotech'),
            'url'           => get_theme_file_uri('/assets/vendor/main-icon/style.css'),
            'enqueue'       => [],
            'prefix'        => '',
            'displayPrefix' => 'far',
            'labelIcon'     => 'fab fa-font-awesome-alt',
            'ver'           => '1.0.0',
            'fetchJson'     => get_theme_file_uri('/assets/json/main-icons.json'),
            'native'        => true,
        ];

        return $tabs;
    }
}

if (!function_exists('ecotech_elementor_fonts')) {
    function ecotech_elementor_fonts($additional_fonts)
    {
        return array(
            'Sora' => 'googlefonts',
        );
    }
}

function ecotech_after_content_import()
{
    $cpt_support   = get_option('elementor_cpt_support', ['page', 'post']);
    $cpt_support[] = 'ovic_menu';
    $cpt_support[] = 'ovic_footer';

    update_option('elementor_cpt_support', $cpt_support);
    update_option('elementor_disable_color_schemes', 'yes');
    update_option('elementor_disable_typography_schemes', 'yes');
    update_option('elementor_load_fa4_shim', 'yes');

    if (class_exists('Elementor\Plugin')) {
        $manager = new Elementor\Core\Files\Manager();
        $manager->clear_cache();
    }
}

add_action('ovic_after_content_import', 'ecotech_after_content_import');
add_action('import_sample_data_after_install_sample_data', 'ecotech_after_content_import');