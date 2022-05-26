<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/*==========================================================================
METABOX BOX OPTIONS
===========================================================================*/
if (!function_exists('ecotech_metabox_options') && class_exists('OVIC_Metabox')) {
    function ecotech_metabox_options()
    {
        $vertical = 'style-01,style-04,style-08';
        $sections = array();
        // -----------------------------------------
        // Page Side Meta box Options              -
        // -----------------------------------------
        $sections[] = array(
            'id'             => '_custom_page_side_options',
            'title'          => esc_html__('Custom Page Side Options', 'ecotech'),
            'post_type'      => 'page',
            'context'        => 'side',
            'priority'       => 'high',
            'page_templates' => 'default',
            'sections'       => array(
                array(
                    'name'   => 'page_option',
                    'fields' => array(
                        'page_banner'         => array(
                            'id'    => 'page_banner',
                            'type'  => 'image',
                            'title' => esc_html__('Page Banner', 'ecotech'),
                            'desc'  => esc_html__('Default is General / Head Banner', 'ecotech'),
                        ),
                        'sidebar_page_layout' => array(
                            'id'         => 'sidebar_page_layout',
                            'type'       => 'image_select',
                            'title'      => esc_html__('Single Page Sidebar Position', 'ecotech'),
                            'desc'       => esc_html__('Select sidebar position on Page.', 'ecotech'),
                            'options'    => array(
                                'left'  => get_theme_file_uri('assets/images/left-sidebar.png'),
                                'right' => get_theme_file_uri('assets/images/right-sidebar.png'),
                                'full'  => get_theme_file_uri('assets/images/no-sidebar.png'),
                            ),
                            'default'    => 'left',
                            'attributes' => array(
                                'data-depend-id' => 'sidebar_page_layout',
                            ),
                        ),
                        'page_sidebar'        => array(
                            'id'         => 'page_sidebar',
                            'type'       => 'select',
                            'title'      => esc_html__('Page Sidebar', 'ecotech'),
                            'options'    => 'sidebars',
                            'dependency' => array('sidebar_page_layout', '!=', 'full'),
                        ),
                        'page_extra_class'    => array(
                            'id'    => 'page_extra_class',
                            'type'  => 'text',
                            'title' => esc_html__('Extra Class', 'ecotech'),
                        ),
                    ),
                ),
            ),
        );
        // -----------------------------------------
        // Page Meta box Options                   -
        // -----------------------------------------
        $sections[] = array(
            'id'        => '_custom_metabox_theme_options',
            'title'     => esc_html__('Custom Theme Options', 'ecotech'),
            'post_type' => 'page',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => array(
                'options'  => array(
                    'name'   => 'options',
                    'title'  => esc_html__('Theme Settings', 'ecotech'),
                    'icon'   => 'fa fa-wordpress',
                    'fields' => array(
                        'enable_metabox_options' => array(
                            'id'    => 'enable_metabox_options',
                            'type'  => 'switcher',
                            'title' => esc_html__('Enable Metabox Options', 'ecotech'),
                            'desc'  => esc_html__('If this option enable then this page will get setting in here, else this page will get setting in Theme Options',
                                'ecotech'),
                        ),
                        'metabox_main_skin'      => array(
                            'id'      => 'metabox_main_skin',
                            'type'    => 'select',
                            'title'   => esc_html__('Main Skin', 'ecotech'),
                            'options' => array(
                                'organic' => esc_html__('Organic', 'ecotech'),
                                'food'    => esc_html__('Food', 'ecotech'),
                            ),
                            'default' => 'organic',
                        ),
                        'metabox_main_container' => array(
                            'id'      => 'metabox_main_container',
                            'type'    => 'slider',
                            'title'   => esc_html__('Main Container', 'ecotech'),
                            'min'     => 1140,
                            'max'     => 1920,
                            'step'    => 10,
                            'unit'    => esc_html__('px', 'ecotech'),
                            'default' => 1410,
                        ),
                        'metabox_logo'           => array(
                            'id'    => 'metabox_logo',
                            'type'  => 'image',
                            'title' => esc_html__('Logo', 'ecotech'),
                            'desc'  => esc_html__('Setting Logo For Site', 'ecotech'),
                        ),
                        'metabox_main_color'     => array(
                            'id'      => 'metabox_main_color',
                            'type'    => 'color',
                            'rgba'    => true,
                            'default' => '#f05127',
                            'title'   => esc_html__('Main Color', 'ecotech'),
                        ),
                        'body_typography'        => array(
                            'id'             => 'body_typography',
                            'type'           => 'typography',
                            'title'          => esc_html__('Typography of Body', 'ecotech'),
                            'font_family'    => true,
                            'font_weight'    => true,
                            'font_style'     => true,
                            'font_size'      => true,
                            'line_height'    => true,
                            'letter_spacing' => true,
                            'text_align'     => true,
                            'text_transform' => true,
                            'color'          => true,
                            'subset'         => true,
                            'extra_styles'   => true,
                            'output'         => 'body',
                        ),
                        'special_typography'     => array(
                            'id'             => 'special_typography',
                            'type'           => 'typography',
                            'title'          => esc_html__('Typography of Special texts', 'ecotech'),
                            'font_family'    => true,
                            'font_weight'    => true,
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
                ),
                'header'   => array(
                    'name'   => 'header',
                    'title'  => esc_html__('Header Settings', 'ecotech'),
                    'icon'   => 'fa fa-folder-open-o',
                    'fields' => array(
                        'metabox_header_template'  => array(
                            'id'         => 'metabox_header_template',
                            'type'       => 'select_preview',
                            'options'    => ecotech_file_options('/templates/header/', 'header'),
                            'default'    => 'style-01',
                            'attributes' => array(
                                'data-depend-id' => 'metabox_header_template',
                            ),
                        ),
                        'metabox_primary_menu'     => array(
                            'id'          => 'metabox_primary_menu',
                            'type'        => 'select',
                            'title'       => esc_html__('Primary Menu', 'ecotech'),
                            'after'       => esc_html__('default is Display location on Menu panel: "Primary Menu"',
                                'ecotech'),
                            'options'     => 'menus',
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'placeholder' => esc_html__('None', 'ecotech'),
                        ),
                        'metabox_header_banner'    => array(
                            'id'          => 'metabox_header_banner',
                            'type'        => 'select',
                            'options'     => 'page',
                            'chosen'      => true,
                            'ajax'        => true,
                            'placeholder' => esc_html__('None', 'ecotech'),
                            'title'       => esc_html__('Header Banner', 'ecotech'),
                            'desc'        => esc_html__('Get banner on header from page builder', 'ecotech'),
                        ),
                        'metabox_header_topmenu'   => array(
                            'id'          => 'metabox_header_topmenu',
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
                        'metabox_header_topmenu_2' => array(
                            'id'          => 'metabox_header_topmenu_2',
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
                        'metabox_header_message'   => array(
                            'id'    => 'metabox_header_message',
                            'type'  => 'textarea',
                            'title' => esc_html__('Header Message', 'ecotech'),
                        ),
                        'metabox_header_info'      => array(
                            'id'              => 'metabox_header_info',
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
                                'metabox_header_template',
                                'any',
                                'style-01,style-02,style-04,style-08'
                            ),
                        ),
                    ),
                ),
                'vertical' => array(
                    'name'   => 'vertical',
                    'title'  => esc_html__('Vertical Settings', 'ecotech'),
                    'icon'   => 'fa fa-folder-open-o',
                    'fields' => array(
                        array(
                            'type'       => 'notice',
                            'style'      => 'warning',
                            'content'    => esc_html__('Style header do not support vertical menu.',
                                'ecotech'),
                            'dependency' => array('metabox_header_template', 'not-any', $vertical, true),
                        ),
                        array(
                            'id'          => 'metabox_vertical_menu',
                            'type'        => 'select',
                            'title'       => esc_html__('Vertical Menu', 'ecotech'),
                            'chosen'      => true,
                            'ajax'        => true,
                            'query_args'  => array(
                                'data-slug' => true,
                            ),
                            'options'     => 'menus',
                            'placeholder' => esc_html__('Select vertical menu', 'ecotech'),
                            'dependency'  => array('metabox_header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('Vertical Menu Title', 'ecotech'),
                            'id'         => 'metabox_vertical_title',
                            'type'       => 'text',
                            'default'    => esc_html__('All departments', 'ecotech'),
                            'dependency' => array('metabox_header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('Vertical Menu Button show all text', 'ecotech'),
                            'id'         => 'metabox_vertical_all_text',
                            'type'       => 'text',
                            'default'    => esc_html__('View All', 'ecotech'),
                            'dependency' => array('metabox_header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('Vertical Menu Button close text', 'ecotech'),
                            'id'         => 'metabox_vertical_close_text',
                            'type'       => 'text',
                            'default'    => esc_html__('Close', 'ecotech'),
                            'dependency' => array('metabox_header_template', 'any', $vertical, true),
                        ),
                        array(
                            'title'      => esc_html__('The number of visible items', 'ecotech'),
                            'id'         => 'metabox_vertical_visible_item',
                            'default'    => 10,
                            'type'       => 'number',
                            'unit'       => 'items',
                            'dependency' => array('metabox_header_template', 'any', $vertical, true),
                        ),
                    ),
                ),
                'footer'   => array(
                    'name'   => 'footer',
                    'title'  => esc_html__('Footer Settings', 'ecotech'),
                    'icon'   => 'fa fa-folder-open-o',
                    'fields' => array(
                        array(
                            'id'      => 'metabox_footer_template',
                            'type'    => 'select_preview',
                            'default' => 'footer-01',
                            'options' => ecotech_footer_preview(),
                        ),
                    ),
                ),
            ),
        );
        // -----------------------------------------
        // Post Meta box Options                   -
        // -----------------------------------------
        $sections[] = array(
            'id'        => '_custom_metabox_post_options',
            'title'     => esc_html__('Post Meta', 'ecotech'),
            'post_type' => 'post',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => array(
                array(
                    'name'   => 'post_options',
                    'icon'   => 'fa fa-picture-o',
                    'fields' => array(
                        array(
                            'id'      => 'size-creative',
                            'type'    => 'select',
                            'title'   => esc_html__('Size Creative', 'ecotech'),
                            'options' => array(
                                ''        => esc_html__('Rand', 'ecotech'),
                                'size-01' => esc_html__('Size 01', 'ecotech'),
                                'size-02' => esc_html__('Size 02', 'ecotech'),
                                'size-03' => esc_html__('Size 03', 'ecotech'),
                            ),
                            'default' => '',
                        ),
                        array(
                            'id'    => 'post_formats',
                            'type'  => 'tabbed',
                            'title' => esc_html__('Post formats', 'ecotech'),
                            'desc'  => esc_html__('The data post formats', 'ecotech'),
                            'tabs'  => array(
                                array(
                                    'title'  => esc_html__('Quote', 'ecotech'),
                                    'fields' => array(
                                        array(
                                            'id'         => 'quote',
                                            'type'       => 'text',
                                            'title'      => esc_html__('Quote Text', 'ecotech'),
                                            'attributes' => array(
                                                'style' => 'width:100%',
                                            ),
                                        ),
                                    ),
                                ),
                                array(
                                    'title'  => esc_html__('Gallery', 'ecotech'),
                                    'fields' => array(
                                        array(
                                            'id'    => 'gallery',
                                            'type'  => 'gallery',
                                            'title' => esc_html__('Gallery source', 'ecotech'),
                                        ),
                                    ),
                                ),
                                array(
                                    'title'  => esc_html__('Video', 'ecotech'),
                                    'fields' => array(
                                        array(
                                            'id'      => 'video',
                                            'type'    => 'upload',
                                            'library' => 'video',
                                            'title'   => esc_html__('Video source', 'ecotech'),
                                        ),
                                    ),
                                ),
                                array(
                                    'title'  => esc_html__('Audio', 'ecotech'),
                                    'fields' => array(
                                        array(
                                            'id'      => 'audio',
                                            'type'    => 'upload',
                                            'title'   => esc_html__('Audio source', 'ecotech'),
                                            'library' => 'audio',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),

            ),
        );
        // -----------------------------------------
        // Product Meta box Options                   -
        // -----------------------------------------
        $sections[] = array(
            'id'        => '_custom_metabox_product_options',
            'title'     => esc_html__('Product Meta', 'ecotech'),
            'post_type' => 'product',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => array(
                array(
                    'name'   => 'product_options',
                    'icon'   => 'fa fa-picture-o',
                    'title'  => esc_html__('Product options', 'ecotech'),
                    'fields' => array(
                        array(
                            'id'    => 'color',
                            'type'  => 'color',
                            'title' => esc_html__('Background', 'ecotech'),
                            'desc'  => esc_html__('for Ovic Products - style 05', 'ecotech'),
                        ),
                        array(
                            'id'    => 'subtitle',
                            'type'  => 'text',
                            'title' => esc_html__('Subtitle', 'ecotech'),
                            'desc'  => esc_html__('for Ovic Products - style 05', 'ecotech'),
                        ),
                    )
                ),
                array(
                    'name'   => 'size_chart',
                    'icon'   => 'fa fa-picture-o',
                    'title'  => esc_html__('Size Chart', 'ecotech'),
                    'fields' => array(
                        array(
                            'id'   => 'size_chart',
                            'type' => 'wp_editor',
                        ),
                    ),
                ),
                array(
                    'name'   => 'delivery',
                    'icon'   => 'fa fa-picture-o',
                    'title'  => esc_html__('Delivery & Return', 'ecotech'),
                    'fields' => array(
                        array(
                            'id'   => 'delivery',
                            'type' => 'wp_editor',
                        ),
                    ),
                ),
                array(
                    'name'   => 'other_info',
                    'icon'   => 'fa fa-picture-o',
                    'title'  => esc_html__('Other Infomation', 'ecotech'),
                    'fields' => array(
                        array(
                            'id'   => 'other_info',
                            'type' => 'wp_editor',
                        ),
                    ),
                ),
            ),
        );

        OVIC_Metabox::instance($sections);
    }

    add_action('init', 'ecotech_metabox_options');
}