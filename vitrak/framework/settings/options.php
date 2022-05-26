<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/*==========================================================================
THEME BOX OPTIONS
===========================================================================*/
if (!function_exists('ecotech_theme_options') && class_exists('OVIC_Options')) {
    function ecotech_theme_options()
    {
        $vertical                = 'style-01,style-04,style-08';
        $options                 = array();
        $options['general_main'] = array(
            'name'     => 'general_main',
            'icon'     => 'fa fa-wordpress',
            'title'    => esc_html__('General', 'ecotech'),
            'sections' => array(
                array(
                    'title'  => esc_html__('General', 'ecotech'),
                    'fields' => array(
                        'main_skin'      => array(
                            'id'      => 'main_skin',
                            'type'    => 'select',
                            'title'   => esc_html__('Main Skin', 'ecotech'),
                            'options' => array(
                                'organic' => esc_html__('Organic', 'ecotech'),
                                'food'    => esc_html__('Food', 'ecotech'),
                            ),
                            'default' => 'organic',
                        ),
                        'main_container' => array(
                            'id'      => 'main_container',
                            'type'    => 'slider',
                            'title'   => esc_html__('Main Container', 'ecotech'),
                            'min'     => 1140,
                            'max'     => 1920,
                            'step'    => 10,
                            'unit'    => esc_html__('px', 'ecotech'),
                            'default' => 1410,
                        ),
                        'logo'           => array(
                            'id'    => 'logo',
                            'type'  => 'image',
                            'title' => esc_html__('Logo', 'ecotech'),
                            'desc'  => esc_html__('Setting Logo For Site', 'ecotech'),
                        ),
                        'main_color'     => array(
                            'id'      => 'main_color',
                            'type'    => 'color',
                            'rgba'    => true,
                            'default' => '#f05127',
                            'title'   => esc_html__('Main Color', 'ecotech'),
                        ),
                        'head_banner'    => array(
                            'id'    => 'head_banner',
                            'type'  => 'image',
                            'title' => esc_html__('Head Banner', 'ecotech'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Enable/Disable', 'ecotech'),
                    'fields' => array(
                        'disable_equal'       => array(
                            'id'    => 'disable_equal',
                            'type'  => 'switcher',
                            'title' => esc_html__('Disable Equal Height', 'ecotech'),
                        ),
                        'enable_cache_option' => array(
                            'id'    => 'enable_cache_option',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Cache Options', 'ecotech'),
                        ),
                        'enable_ajax_comment' => array(
                            'id'    => 'enable_ajax_comment',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Nav Ajax Comment', 'ecotech'),
                        ),
                        'enable_backtotop'    => array(
                            'id'    => 'enable_backtotop',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Back To Top Button', 'ecotech'),
                        ),
                        'enable_rtl_bg'    => array(
                            'id'      => 'enable_rtl_bg',
                            'type'    => 'switcher',
                            'title'   => esc_html__('Enable RTL Background', 'ecotech'),
                            'desc'    => esc_html__('In RTL, Sections has class "rtl-bg" will be has rtl background', 'ecotech'),
                            'default' => 1,
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Sidebar Settings', 'ecotech'),
                    'fields' => array(
                        array(
                            'id'           => 'multi_sidebar',
                            'type'         => 'repeater',
                            'button_title' => esc_html__('Add Sidebar', 'ecotech'),
                            'title'        => esc_html__('Multi Sidebar', 'ecotech'),
                            'fields'       => array(
                                array(
                                    'id'    => 'add_sidebar',
                                    'type'  => 'text',
                                    'title' => esc_html__('Name Sidebar', 'ecotech'),
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('ACE Settings', 'ecotech'),
                    'fields' => array(
                        'ace_style'  => array(
                            'id'       => 'ace_style',
                            'type'     => 'code_editor',
                            'settings' => array(
                                'theme' => 'dracula',
                                'mode'  => 'css',
                            ),
                            'title'    => esc_html__('Editor Style', 'ecotech'),
                        ),
                        'ace_script' => array(
                            'id'       => 'ace_script',
                            'type'     => 'code_editor',
                            'settings' => array(
                                'theme' => 'dracula',
                                'mode'  => 'javascript',
                            ),
                            'title'    => esc_html__('Editor Javascript', 'ecotech'),
                        ),
                    ),
                ),
            ),
        );
        $options['mobile_main']  = array(
            'name'     => 'mobile_main',
            'icon'     => 'fa fa-wordpress',
            'title'    => esc_html__('Mobile', 'ecotech'),
            'sections' => array(
                array(
                    'title'  => esc_html__('Mobile Layout', 'ecotech'),
                    'fields' => array(
                        'mobile_enable'     => array(
                            'id'    => 'mobile_enable',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Version Mobile', 'ecotech'),
                        ),
                        'logo_mobile'       => array(
                            'id'    => 'logo_mobile',
                            'type'  => 'image',
                            'title' => esc_html__('Logo Mobile', 'ecotech'),
                            'desc'  => esc_html__('Setting Logo For Site', 'ecotech'),
                        ),
                        'mobile_layout'     => array(
                            'id'      => 'mobile_layout',
                            'type'    => 'image_select',
                            'default' => 'style-01',
                            'title'   => esc_html__('Mobile Layout', 'ecotech'),
                            'options' => array(
                                'style-01' => get_theme_file_uri('templates/mobile/mobile-style-01.jpg'),
                                'style-02' => get_theme_file_uri('templates/mobile/mobile-style-02.jpg'),
                            ),
                        ),
                        'mobile_banner'     => array(
                            'id'      => 'mobile_banner',
                            'type'    => 'switcher',
                            'default' => 'true',
                            'title'   => esc_html__('Mobile Top Banner', 'ecotech'),
                        ),
                        'background_mobile' => array(
                            'id'         => 'background_mobile',
                            'type'       => 'background',
                            'title'      => esc_html__('Background Mobile', 'ecotech'),
                            'desc'       => esc_html__('Setting Background For Mobile Menu', 'ecotech'),
                            'default'    => array(
                                'background-position'   => 'center center',
                                'background-repeat'     => 'no-repeat',
                                'background-attachment' => 'scroll',
                                'background-size'       => 'cover',
                            ),
                            'dependency' => array(
                                'mobile_banner',
                                '==',
                                'true'
                            ),
                            'output'     => '.ovic-menu-clone-wrap .head-menu-mobile'
                        ),
                    )
                ),
                array(
                    'title'  => esc_html__('Mobile Content', 'ecotech'),
                    'fields' => array(
                        'mobile_menu_top'    => array(
                            'id'          => 'mobile_menu_top',
                            'type'        => 'select',
                            'title'       => esc_html__('Mobile Menu Top', 'ecotech'),
                            'options'     => 'menus',
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'placeholder' => esc_html__('None', 'ecotech'),
                        ),
                        'mobile_menu_bottom' => array(
                            'id'          => 'mobile_menu_bottom',
                            'type'        => 'select',
                            'title'       => esc_html__('Mobile Menu Bottom', 'ecotech'),
                            'options'     => 'menus',
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'placeholder' => esc_html__('None', 'ecotech'),
                        ),
                        'mobile_footer'      => array(
                            'id'      => 'mobile_footer',
                            'type'    => 'select_preview',
                            'default' => 'inherit',
                            'title'   => esc_html__('Footer Mobile', 'ecotech'),
                            'options' => ecotech_footer_preview(true),
                        ),
                    )
                ),
            ),
        );
        $options['header_main']  = array(
            'name'     => 'header_main',
            'icon'     => 'fa fa-folder-open-o',
            'title'    => esc_html__('Header', 'ecotech'),
            'sections' => array(
                array(
                    'title'  => esc_html__('Header Menu', 'ecotech'),
                    'fields' => array(
                        'sticky_menu'      => array(
                            'id'      => 'sticky_menu',
                            'type'    => 'button_set',
                            'title'   => esc_html__('Header Sticky', 'ecotech'),
                            'options' => array(
                                'none'     => esc_html__('None', 'ecotech'),
                                'template' => esc_html__('Template', 'ecotech'),
                                'jquery'   => esc_html__('jQuery', 'ecotech'),
                            ),
                            'default' => 'none',
                        ),
                        'header_template'  => array(
                            'id'      => 'header_template',
                            'type'    => 'select_preview',
                            'title'   => esc_html__('Header Desktop', 'ecotech'),
                            'options' => ecotech_file_options('/templates/header/', 'header'),
                            'default' => 'style-01',
                        ),
                        'header_banner'    => array(
                            'id'          => 'header_banner',
                            'type'        => 'select',
                            'options'     => 'page',
                            'chosen'      => true,
                            'ajax'        => true,
                            'placeholder' => esc_html__('None', 'ecotech'),
                            'title'       => esc_html__('Header Banner', 'ecotech'),
                            'desc'        => esc_html__('Get banner on header from page builder', 'ecotech'),
                        ),
                        'header_topmenu'   => array(
                            'id'          => 'header_topmenu',
                            'type'        => 'select',
                            'title'       => esc_html__('Header Top Menu', 'ecotech'),
                            'options'     => 'menus',
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'placeholder' => esc_html__('None', 'ecotech'),
                        ),
                        'header_topmenu_2' => array(
                            'id'          => 'header_topmenu_2',
                            'type'        => 'select',
                            'title'       => esc_html__('Header Top Menu 02', 'ecotech'),
                            'options'     => 'menus',
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'placeholder' => esc_html__('None', 'ecotech'),
                        ),
                        'header_message'   => array(
                            'id'    => 'header_message',
                            'type'  => 'textarea',
                            'title' => esc_html__('Header Message', 'ecotech'),
                        ),
                        'header_info'      => array(
                            'id'              => 'header_info',
                            'type'            => 'group',
                            'max'             => 3,
                            'title'           => esc_html__('Header Infomation', 'ecotech'),
                            'button_title'    => esc_html__('Add item', 'ecotech'),
                            'accordion_title' => esc_html__('Add New item', 'ecotech'),
                            'fields'          => array(
                                array(
                                    'id'    => 'info_title',
                                    'type'  => 'text',
                                    'title' => esc_html__('Title', 'ecotech'),
                                ),
                                array(
                                    'id'    => 'info_subtitle',
                                    'type'  => 'text',
                                    'title' => esc_html__('Subtitle', 'ecotech'),
                                ),
                                array(
                                    'id'    => 'info_icon',
                                    'type'  => 'icon',
                                    'title' => esc_html__('Select icon', 'ecotech'),
                                ),
                                array(
                                    'id'    => 'info_link',
                                    'type'  => 'text',
                                    'title' => esc_html__('Link', 'ecotech'),
                                ),
                            ),
                            'dependency'      => array(
                                'header_template',
                                'any',
                                'style-01,style-02,style-04,style-08'
                            ),
                        ),
                    )
                ),
                array(
                    'title'  => esc_html__('Vertical Menu', 'ecotech'),
                    'fields' => array(
                        array(
                            'id'       => 'vertical_always_open',
                            'type'     => 'select',
                            'options'  => 'page',
                            'multiple' => true,
                            'chosen'   => true,
                            'ajax'     => true,
                            'title'    => esc_html__('Vertical Menu Always Open', 'ecotech'),
                            'desc'     => esc_html__('Vertical menu will be always open', 'ecotech'),
                        ),
                        array(
                            'type'       => 'notice',
                            'style'      => 'warning',
                            'content'    => esc_html__('Style header do not support vertical menu.',
                                'ecotech'),
                            'dependency' => array('header_template', 'not-any', $vertical, true),
                        ),
                        array(
                            'id'          => 'vertical_menu',
                            'type'        => 'select',
                            'title'       => esc_html__('Vertical Menu', 'ecotech'),
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'options'     => 'menus',
                            'placeholder' => esc_html__('Select vertical menu', 'ecotech'),
                            'dependency'  => array('header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('Vertical Menu Title', 'ecotech'),
                            'id'         => 'vertical_title',
                            'type'       => 'text',
                            'default'    => esc_html__('All departments', 'ecotech'),
                            'dependency' => array('header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('Vertical Menu Button show all text', 'ecotech'),
                            'id'         => 'vertical_all_text',
                            'type'       => 'text',
                            'default'    => esc_html__('View All', 'ecotech'),
                            'dependency' => array('header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('Vertical Menu Button close text', 'ecotech'),
                            'id'         => 'vertical_close_text',
                            'type'       => 'text',
                            'default'    => esc_html__('Close', 'ecotech'),
                            'dependency' => array('header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('The number of visible items', 'ecotech'),
                            'id'         => 'vertical_visible_item',
                            'default'    => 10,
                            'type'       => 'number',
                            'unit'       => 'items',
                            'dependency' => array('header_template', 'any', $vertical, true),
                        ),
                    )
                ),
            ),
        );
        $options['footer_main']  = array(
            'name'   => 'footer_main',
            'icon'   => 'fa fa-folder-open-o',
            'title'  => esc_html__('Footer', 'ecotech'),
            'fields' => array(
                'footer_template' => array(
                    'id'      => 'footer_template',
                    'type'    => 'select_preview',
                    'default' => 'footer-01',
                    'title'   => esc_html__('Footer Desktop', 'ecotech'),
                    'options' => ecotech_footer_preview(),
                ),
            ),
        );
        $options['posts_main']   = array(
            'name'     => 'posts_main',
            'icon'     => 'fa fa-rss',
            'title'    => esc_html__('Posts Settings', 'ecotech'),
            'sections' => array(
                array(
                    'title'  => esc_html__('Posts Main', 'ecotech'),
                    'fields' => array(
                        'blog_list_style'     => array(
                            'id'      => 'blog_list_style',
                            'type'    => 'select',
                            'title'   => esc_html__('Blog Style', 'ecotech'),
                            'options' => array(
                                'standard' => esc_html__('Standard', 'ecotech'),
                                'list'     => esc_html__('List', 'ecotech'),
                                'grid'     => esc_html__('Grid', 'ecotech'),
                                'creative' => esc_html__('Creative', 'ecotech'),
                            ),
                            'default' => 'standard',
                        ),
                        'sidebar_blog_layout' => array(
                            'id'      => 'sidebar_blog_layout',
                            'type'    => 'image_select',
                            'title'   => esc_html__('Sidebar Blog Layout', 'ecotech'),
                            'desc'    => esc_html__('Select sidebar position on Blog.', 'ecotech'),
                            'options' => array(
                                'left'  => get_theme_file_uri('assets/images/left-sidebar.png'),
                                'right' => get_theme_file_uri('assets/images/right-sidebar.png'),
                                'full'  => get_theme_file_uri('assets/images/no-sidebar.png'),
                            ),
                            'default' => 'right',
                        ),
                        'blog_used_sidebar'   => array(
                            'id'         => 'blog_used_sidebar',
                            'type'       => 'select',
                            'default'    => 'widget-area',
                            'title'      => esc_html__('Blog Sidebar', 'ecotech'),
                            'options'    => 'sidebars',
                            'dependency' => array('sidebar_blog_layout', '!=', 'full'),
                        ),
                        'blog_featured_posts' => array(
                            'id'       => 'blog_featured_posts',
                            'type'     => 'select',
                            'title'    => esc_html__('Blog Featured Posts', 'ecotech'),
                            'options'  => 'post',
                            'chosen'   => true,
                            'ajax'     => true,
                            'multiple' => true,
                        ),
                        'blog_pagination'     => array(
                            'id'      => 'blog_pagination',
                            'type'    => 'button_set',
                            'title'   => esc_html__('Blog Pagination', 'ecotech'),
                            'options' => array(
                                'pagination' => esc_html__('Pagination', 'ecotech'),
                                'load_more'  => esc_html__('Load More', 'ecotech'),
                                'infinite'   => esc_html__('Infinite Scrolling', 'ecotech'),
                            ),
                            'default' => 'pagination',
                            'desc'    => esc_html__('Select style pagination on blog page.', 'ecotech'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Posts Single', 'ecotech'),
                    'fields' => array(
                        'post_page_title'        => array(
                            'id'      => 'post_page_title',
                            'type'    => 'text',
                            'title'   => esc_html__('Post Page Title', 'ecotech'),
                            'default' => esc_html__('Post Details', 'ecotech'),
                        ),
                        'single_layout'          => array(
                            'id'      => 'single_layout',
                            'type'    => 'select',
                            'default' => 'standard',
                            'title'   => esc_html__('Single Post Layout', 'ecotech'),
                            'options' => array(
                                'standard' => esc_html__('Standard', 'ecotech'),
                                'full'     => esc_html__('Full Width', 'ecotech'),
                            ),
                        ),
                        'sidebar_single_layout'  => array(
                            'id'         => 'sidebar_single_layout',
                            'type'       => 'image_select',
                            'title'      => esc_html__(' Sidebar Single Post Layout', 'ecotech'),
                            'desc'       => esc_html__('Select sidebar position on Blog.', 'ecotech'),
                            'options'    => array(
                                'left'  => get_theme_file_uri('assets/images/left-sidebar.png'),
                                'right' => get_theme_file_uri('assets/images/right-sidebar.png'),
                                'full'  => get_theme_file_uri('assets/images/no-sidebar.png'),
                            ),
                            'default'    => 'right',
                            'dependency' => array('single_layout', '!=', 'full'),
                        ),
                        'single_used_sidebar'    => array(
                            'id'         => 'single_used_sidebar',
                            'type'       => 'select',
                            'default'    => 'widget-area',
                            'title'      => esc_html__('Blog Single Sidebar', 'ecotech'),
                            'options'    => 'sidebars',
                            'dependency' => array('sidebar_single_layout', '!=', 'full'),
                        ),
                        'enable_share_post'      => array(
                            'id'    => 'enable_share_post',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Share Post', 'ecotech'),
                        ),
                        'enable_pagination_post' => array(
                            'id'    => 'enable_pagination_post',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Pagination Post', 'ecotech'),
                        ),
                        'enable_related_post'    => array(
                            'id'    => 'enable_related_post',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Related Post', 'ecotech'),
                        ),
                    ),
                ),
            ),
        );
        if (class_exists('WooCommerce')) {
            $options['woocommerce_mains'] = array(
                'name'     => 'woocommerce_mains',
                'icon'     => 'fa fa-shopping-bag',
                'title'    => esc_html__('WooCommerce', 'ecotech'),
                'sections' => array(
                    array(
                        'title'  => esc_html__('General', 'ecotech'),
                        'fields' => array(
                            'shop_banner'              => array(
                                'id'    => 'shop_banner',
                                'type'  => 'image',
                                'title' => esc_html__('Shop Banner', 'ecotech'),
                                'desc'  => esc_html__('Default is General / Head Banner', 'ecotech'),
                            ),
                            'shop_product_style'       => array(
                                'id'      => 'shop_product_style',
                                'type'    => 'select_preview',
                                'default' => 'style-01',
                                'title'   => esc_html__('Product shop style', 'ecotech'),
                                'desc'    => esc_html__('Select a product style in shop page', 'ecotech'),
                                'options' => ecotech_product_options('Theme Option'),
                            ),
                            'shop_list_style'          => array(
                                'id'      => 'shop_list_style',
                                'type'    => 'image_select',
                                'default' => 'grid',
                                'title'   => esc_html__('Shop Layout', 'ecotech'),
                                'desc'    => esc_html__('Select layout for shop product, product category archive.',
                                    'ecotech'),
                                'options' => array(
                                    'grid' => get_theme_file_uri('assets/images/grid-display.png'),
                                    'list' => get_theme_file_uri('assets/images/list-display.png'),
                                ),
                            ),
                            'sidebar_shop_layout'      => array(
                                'id'      => 'sidebar_shop_layout',
                                'type'    => 'image_select',
                                'title'   => esc_html__('Shop Page Sidebar Layout', 'ecotech'),
                                'desc'    => esc_html__('Select sidebar position on Shop Page.', 'ecotech'),
                                'options' => array(
                                    'left'  => get_theme_file_uri('assets/images/left-sidebar.png'),
                                    'right' => get_theme_file_uri('assets/images/right-sidebar.png'),
                                    'full'  => get_theme_file_uri('assets/images/no-sidebar.png'),
                                ),
                                'default' => 'left',
                            ),
                            'shop_used_sidebar'        => array(
                                'id'         => 'shop_used_sidebar',
                                'type'       => 'select',
                                'default'    => 'shop-widget-area',
                                'title'      => esc_html__('Sidebar Used For Shop', 'ecotech'),
                                'options'    => 'sidebars',
                                'dependency' => array('sidebar_shop_layout', '!=', 'full'),
                            ),
                            'shop_vendor_used_sidebar' => array(
                                'id'         => 'shop_vendor_used_sidebar',
                                'type'       => 'select',
                                'title'      => esc_html__('Sidebar Used For Vendor', 'ecotech'),
                                'options'    => 'sidebars',
                                'dependency' => array('sidebar_shop_layout', '!=', 'full'),
                            ),
                            'enable_short_title'       => array(
                                'id'    => 'enable_short_title',
                                'type'  => 'switcher',
                                'title' => esc_html__('Enable Short Title on Mobile (<768px)', 'ecotech'),
                            ),
                            'count_widget_attribute'   => array(
                                'id'    => 'count_widget_attribute',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show product counts of widget Ovic: Attribute Product', 'ecotech'),
                            ),
                        ),
                    ),
                    array(
                        'title'  => esc_html__('Shop Settings', 'ecotech'),
                        'fields' => array(
                            'shop_page_title'        => array(
                                'id'      => 'shop_page_title',
                                'type'    => 'text',
                                'title'   => esc_html__('Shop Page Title', 'ecotech'),
                                'default' => esc_html__('Shop Products', 'ecotech'),
                            ),
                            'product_hover'          => array(
                                'id'      => 'product_hover',
                                'type'    => 'button_set',
                                'title'   => esc_html__('Product Image Hover', 'ecotech'),
                                'options' => array(
                                    'change' => esc_html__('Change Image', 'ecotech'),
                                    'zoom'   => esc_html__('Zoom Image', 'ecotech'),
                                ),
                                'default' => 'zoom',
                            ),
                            'product_loop_columns'   => array(
                                'id'      => 'product_loop_columns',
                                'type'    => 'spinner',
                                'title'   => esc_html__('Products Columns', 'ecotech'),
                                'desc'    => esc_html__('Number Columns of products on shop page.',
                                    'ecotech'),
                                'max'     => 6,
                                'min'     => 2,
                                'step'    => 1,
                                'unit'    => 'columns',
                                'default' => 4,
                            ),
                            'product_per_page'       => array(
                                'id'      => 'product_per_page',
                                'type'    => 'spinner',
                                'default' => '16',
                                'unit'    => 'items',
                                'title'   => esc_html__('Products Per Page', 'ecotech'),
                                'desc'    => esc_html__('Number of products on shop page.', 'ecotech'),
                            ),
                            'product_newness'        => array(
                                'id'      => 'product_newness',
                                'default' => '100',
                                'type'    => 'spinner',
                                'unit'    => 'days',
                                'title'   => esc_html__('Products Newness', 'ecotech'),
                            ),
                            'woocommerce_pagination' => array(
                                'id'      => 'woocommerce_pagination',
                                'type'    => 'button_set',
                                'title'   => esc_html__('WooCommerce Pagination', 'ecotech'),
                                'options' => array(
                                    'pagination' => esc_html__('Pagination', 'ecotech'),
                                    'load_more'  => esc_html__('Load More', 'ecotech'),
                                    'infinite'   => esc_html__('Infinite Scrolling', 'ecotech'),
                                ),
                                'default' => 'pagination',
                                'desc'    => esc_html__('Select style pagination on shop page.', 'ecotech'),
                            ),
                        ),
                    ),
                    array(
                        'title'  => esc_html__('Single Products', 'ecotech'),
                        'fields' => array(
                            'sidebar_product_layout'   => array(
                                'id'      => 'sidebar_product_layout',
                                'type'    => 'image_select',
                                'title'   => esc_html__('Product Sidebar', 'ecotech'),
                                'desc'    => esc_html__('Select sidebar position on Product Page.',
                                    'ecotech'),
                                'options' => array(
                                    'left'  => get_theme_file_uri('assets/images/left-sidebar.png'),
                                    'right' => get_theme_file_uri('assets/images/right-sidebar.png'),
                                    'full'  => get_theme_file_uri('assets/images/no-sidebar.png'),
                                ),
                                'default' => 'right',
                            ),
                            'product_used_sidebar'     => array(
                                'id'         => 'product_used_sidebar',
                                'type'       => 'select',
                                'default'    => 'product-widget-area',
                                'title'      => esc_html__('Sidebar Used For Product', 'ecotech'),
                                'options'    => 'sidebars',
                                'dependency' => array('sidebar_product_layout', '!=', 'full'),
                            ),
                            'enable_share_product'     => array(
                                'id'    => 'enable_share_product',
                                'type'  => 'switcher',
                                'title' => esc_html__('Enable Share Product', 'ecotech'),
                            ),
                            'enable_countdown_product' => array(
                                'id'    => 'enable_countdown_product',
                                'type'  => 'switcher',
                                'title' => esc_html__('Enable Countdown Product', 'ecotech'),
                            ),
                            'disable_zoom'             => array(
                                'id'    => 'disable_zoom',
                                'type'  => 'switcher',
                                'title' => esc_html__('Disable Zoom Gallery', 'ecotech'),
                            ),
                            'disable_lightbox'         => array(
                                'id'    => 'disable_lightbox',
                                'type'  => 'switcher',
                                'title' => esc_html__('Disable Lightbox Gallery', 'ecotech'),
                            ),
                        ),
                    ),
                    array(
                        'title'  => esc_html__('Related Products', 'ecotech'),
                        'fields' => array(
                            'woo_related_enable'    => array(
                                'id'      => 'woo_related_enable',
                                'type'    => 'button_set',
                                'default' => 'enable',
                                'options' => array(
                                    'enable'  => esc_html__('Enable', 'ecotech'),
                                    'disable' => esc_html__('Disable', 'ecotech'),
                                ),
                                'title'   => esc_html__('Enable Related Products', 'ecotech'),
                            ),
                            'woo_related_title'     => array(
                                'id'         => 'woo_related_title',
                                'type'       => 'text',
                                'title'      => esc_html__('Related products title', 'ecotech'),
                                'desc'       => esc_html__('Related products title', 'ecotech'),
                                'dependency' => array('woo_related_enable', '==', 'enable'),
                                'default'    => esc_html__('Related Products', 'ecotech'),
                            ),
                            'woo_related_style'     => array(
                                'id'         => 'woo_related_style',
                                'type'       => 'select_preview',
                                'default'    => 'style-01',
                                'title'      => esc_html__('Product Related Layout', 'ecotech'),
                                'options'    => ecotech_product_options('Theme Option'),
                                'dependency' => array('woo_related_enable', '==', 'enable'),
                            ),
                            'woo_related_perpage'   => array(
                                'id'         => 'woo_related_perpage',
                                'type'       => 'spinner',
                                'title'      => esc_html__('Related products Items', 'ecotech'),
                                'desc'       => esc_html__('Number Related products to show', 'ecotech'),
                                'dependency' => array('woo_related_enable', '==', 'enable'),
                                'default'    => 6,
                                'unit'       => 'item(s)',
                            ),
                            'woo_related_desktop'   => array(
                                'id'      => 'woo_related_desktop',
                                'title'   => esc_html__('items on Desktop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 1500px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 5,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_related_laptop'    => array(
                                'id'      => 'woo_related_laptop',
                                'title'   => esc_html__('items on Laptop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 1200px & < 1500px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 4,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_related_ipad'      => array(
                                'id'      => 'woo_related_ipad',
                                'title'   => esc_html__('items on Ipad', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 992px & < 1200px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 4,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_related_landscape' => array(
                                'id'      => 'woo_related_landscape',
                                'title'   => esc_html__('items on Landscape Tablet', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 768px & < 992px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 3,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_related_portrait'  => array(
                                'id'      => 'woo_related_portrait',
                                'title'   => esc_html__('items on Portrait Tablet', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 480px & < 768px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 2,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_related_mobile'    => array(
                                'id'      => 'woo_related_mobile',
                                'title'   => esc_html__('items on Desktop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution < 480px )', 'ecotech'),
                                'type'    => 'slider',
                                'default' => 2,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                        ),
                    ),
                    array(
                        'title'  => esc_html__('Cross Sell Products', 'ecotech'),
                        'fields' => array(
                            'woo_crosssell_enable'    => array(
                                'id'      => 'woo_crosssell_enable',
                                'type'    => 'button_set',
                                'default' => 'enable',
                                'options' => array(
                                    'enable'  => esc_html__('Enable', 'ecotech'),
                                    'disable' => esc_html__('Disable', 'ecotech'),
                                ),
                                'title'   => esc_html__('Enable Cross Sell Products', 'ecotech'),
                            ),
                            'woo_crosssell_title'     => array(
                                'id'         => 'woo_crosssell_title',
                                'type'       => 'text',
                                'title'      => esc_html__('Cross Sell products title', 'ecotech'),
                                'desc'       => esc_html__('Cross Sell products title', 'ecotech'),
                                'dependency' => array('woo_crosssell_enable', '==', 'enable'),
                                'default'    => esc_html__('Cross Sell Products', 'ecotech'),
                            ),
                            'woo_crosssell_style'     => array(
                                'id'         => 'woo_crosssell_style',
                                'type'       => 'select_preview',
                                'default'    => 'style-01',
                                'title'      => esc_html__('Product Cross Sell Layout', 'ecotech'),
                                'options'    => ecotech_product_options('Theme Option'),
                                'dependency' => array('woo_crosssell_enable', '==', 'enable'),
                            ),
                            'woo_crosssell_desktop'   => array(
                                'id'      => 'woo_crosssell_desktop',
                                'title'   => esc_html__('items on Desktop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 1500px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 5,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_crosssell_laptop'    => array(
                                'id'      => 'woo_crosssell_laptop',
                                'title'   => esc_html__('items on Laptop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 1200px & < 1500px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 4,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_crosssell_ipad'      => array(
                                'id'      => 'woo_crosssell_ipad',
                                'title'   => esc_html__('items on Ipad', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 992px & < 1200px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 4,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_crosssell_landscape' => array(
                                'id'      => 'woo_crosssell_landscape',
                                'title'   => esc_html__('items on Landscape Tablet', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 768px & < 992px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 3,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_crosssell_portrait'  => array(
                                'id'      => 'woo_crosssell_portrait',
                                'title'   => esc_html__('items on Portrait Tablet', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 480px & < 768px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 2,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_crosssell_mobile'    => array(
                                'id'      => 'woo_crosssell_mobile',
                                'title'   => esc_html__('items on Desktop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution < 480px )', 'ecotech'),
                                'type'    => 'slider',
                                'default' => 2,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                        ),
                    ),
                    array(
                        'title'  => esc_html__('Upsell Products', 'ecotech'),
                        'fields' => array(
                            'woo_upsell_enable'    => array(
                                'id'      => 'woo_upsell_enable',
                                'type'    => 'button_set',
                                'default' => 'enable',
                                'options' => array(
                                    'enable'  => esc_html__('Enable', 'ecotech'),
                                    'disable' => esc_html__('Disable', 'ecotech'),
                                ),
                                'title'   => esc_html__('Enable Upsell Products', 'ecotech'),
                            ),
                            'woo_upsell_title'     => array(
                                'id'         => 'woo_upsell_title',
                                'type'       => 'text',
                                'title'      => esc_html__('Upsell products title', 'ecotech'),
                                'desc'       => esc_html__('Upsell products title', 'ecotech'),
                                'dependency' => array('woo_upsell_enable', '==', 'enable'),
                                'default'    => esc_html__('Upsell Products', 'ecotech'),
                            ),
                            'woo_upsell_style'     => array(
                                'id'         => 'woo_upsell_style',
                                'type'       => 'select_preview',
                                'default'    => 'style-01',
                                'title'      => esc_html__('Product Upsell Layout', 'ecotech'),
                                'options'    => ecotech_product_options('Theme Option'),
                                'dependency' => array('woo_upsell_enable', '==', 'enable'),
                            ),
                            'woo_upsell_desktop'   => array(
                                'id'      => 'woo_upsell_desktop',
                                'title'   => esc_html__('items on Desktop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 1500px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 5,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_upsell_laptop'    => array(
                                'id'      => 'woo_upsell_laptop',
                                'title'   => esc_html__('items on Laptop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 1200px & < 1500px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 4,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_upsell_ipad'      => array(
                                'id'      => 'woo_upsell_ipad',
                                'title'   => esc_html__('items on Ipad', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 992px & < 1200px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 4,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_upsell_landscape' => array(
                                'id'      => 'woo_upsell_landscape',
                                'title'   => esc_html__('items on Landscape Tablet', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 768px & < 992px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 3,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_upsell_portrait'  => array(
                                'id'      => 'woo_upsell_portrait',
                                'title'   => esc_html__('items on Portrait Tablet', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution >= 480px & < 768px )',
                                    'ecotech'),
                                'type'    => 'slider',
                                'default' => 2,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                            'woo_upsell_mobile'    => array(
                                'id'      => 'woo_upsell_mobile',
                                'title'   => esc_html__('items on Desktop', 'ecotech'),
                                'desc'    => esc_html__('(Screen resolution < 480px )', 'ecotech'),
                                'type'    => 'slider',
                                'default' => 2,
                                'min'     => 1,
                                'max'     => 6,
                                'unit'    => 'item(s)',
                            ),
                        ),
                    ),
                ),
            );
        }
        $options['social']     = array(
            'name'   => 'social',
            'icon'   => 'fa fa-users',
            'title'  => esc_html__('Social', 'ecotech'),
            'fields' => array(
                array(
                    'id'              => 'user_all_social',
                    'type'            => 'group',
                    'title'           => esc_html__('Social', 'ecotech'),
                    'button_title'    => esc_html__('Add New Social', 'ecotech'),
                    'accordion_title' => esc_html__('Social Settings', 'ecotech'),
                    'fields'          => array(
                        array(
                            'id'      => 'title_social',
                            'type'    => 'text',
                            'title'   => esc_html__('Title Social', 'ecotech'),
                            'default' => 'Facebook',
                        ),
                        array(
                            'id'      => 'link_social',
                            'type'    => 'text',
                            'title'   => esc_html__('Link Social', 'ecotech'),
                            'default' => 'https://facebook.com',
                        ),
                        array(
                            'id'      => 'icon_social',
                            'type'    => 'icon',
                            'title'   => esc_html__('Icon Social', 'ecotech'),
                            'default' => 'fa fa-facebook',
                        ),
                    ),
                    'default'         => array(
                        array(
                            'title_social' => 'Facebook',
                            'link_social'  => 'https://facebook.com/',
                            'icon_social'  => 'fa fa-facebook',
                        ),
                        array(
                            'title_social' => 'Twitter',
                            'link_social'  => 'https://twitter.com/',
                            'icon_social'  => 'fa fa-twitter',
                        ),
                        array(
                            'title_social' => 'Youtube',
                            'link_social'  => 'https://youtube.com/',
                            'icon_social'  => 'fa fa-youtube',
                        ),
                        array(
                            'title_social' => 'Pinterest',
                            'link_social'  => 'https://pinterest.com/',
                            'icon_social'  => 'fa fa-pinterest',
                        ),
                        array(
                            'title_social' => 'Instagram',
                            'link_social'  => 'https://instagram.com/',
                            'icon_social'  => 'fa fa-instagram',
                        ),
                    ),
                ),
            ),
        );
        $options['typography'] = array(
            'name'   => 'typography',
            'icon'   => 'fa fa-font',
            'title'  => esc_html__('Typography', 'ecotech'),
            'fields' => array(
                'body_typography'    => array(
                    'id'                 => 'body_typography',
                    'type'               => 'typography',
                    'title'              => esc_html__('Typography of Body', 'ecotech'),
                    'font_family'        => true,
                    'font_weight'        => true,
                    'font_style'         => true,
                    'font_size'          => true,
                    'line_height'        => false,
                    'letter_spacing'     => false,
                    'text_align'         => false,
                    'text_transform'     => false,
                    'color'              => true,
                    'subset'             => true,
                    'extra_styles'       => true,
                    'backup_font_family' => false,
                    'font_variant'       => false,
                    'word_spacing'       => false,
                    'text_decoration'    => false,
                    'output'             => 'body',
                ),
                'special_typography' => array(
                    'id'             => 'special_typography',
                    'type'           => 'typography',
                    'title'          => esc_html__('Typography of Special texts', 'ecotech'),
                    'font_family'    => true,
                    'font_weight'    => false,
                    'font_style'     => false,
                    'font_size'      => false,
                    'line_height'    => false,
                    'letter_spacing' => false,
                    'text_align'     => false,
                    'text_transform' => false,
                    'color'          => false,
                    'subset'         => false,
                    'extra_styles'   => false,
                    'output'         => '.special-font',
                ),
            ),
        );
        $options['backup']     = array(
            'name'   => 'backup',
            'icon'   => 'fa fa-bold',
            'title'  => esc_html__('Backup / Reset', 'ecotech'),
            'fields' => array(
                'reset'             => array(
                    'id'    => 'reset',
                    'type'  => 'backup',
                    'title' => esc_html__('Reset', 'ecotech'),
                ),
                'delete_transients' => array(
                    'id'      => 'delete_transients',
                    'type'    => 'content',
                    'content' => '<a href="#" data-text-done="'.esc_attr__('%n transient database entries have been deleted.',
                            'ecotech').'" class="button button-primary delete-transients"/>'.esc_html__('Delete Transients',
                            'ecotech').'</a><span class="spinner" style="float:none;"></span>',
                    'title'   => esc_html__('Delete Transients', 'ecotech'),
                    'desc'    => esc_html__('All transient related database entries will be deleted.',
                        'ecotech'),
                    'after'   => ' <p class="ovic-text-success"></p>',
                ),
            ),
        );
        //
        // Framework Settings
        //
        $settings = array(
            'option_name'      => '_ovic_customize_options',
            'menu_title'       => esc_html__('Theme Options', 'ecotech'),
            'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
            'menu_parent'      => 'ovic_addon-dashboard',
            'menu_slug'        => 'ovic_theme_options',
            'menu_position'    => 5,
            'show_search'      => true,
            'show_reset'       => true,
            'show_footer'      => false,
            'show_all_options' => true,
            'ajax_save'        => true,
            'sticky_header'    => true,
            'save_defaults'    => true,
            'framework_title'  => sprintf(
                '%s <small>%s <a href="%s" target="_blank">%s</a></small>',
                esc_html__('Theme Options', 'ecotech'),
                esc_html__('by', 'ecotech'),
                esc_url('https://kutethemes.com/'),
                esc_html__('Kutethemes', 'ecotech')
            ),
        );

        OVIC_Options::instance($settings, $options);
    }

    add_action('init', 'ecotech_theme_options');
}