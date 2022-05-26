<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Core\Schemes;
use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Tabs extends Ovic_Widget_Elementor
{
    /**
     * Get widget name.
     *
     * Retrieve image widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'ovic_tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve image widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__( 'Tabs', 'ecotech' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve image widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-product-tabs';
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'general_section',
            [
                'tab'   => Controls_Manager::TAB_CONTENT,
                'label' => esc_html__( 'General', 'ecotech' ),
            ]
        );

        $this->start_controls_tabs( 'tabs_general' );

        $this->start_controls_tab(
            'tab_general',
            [
                'label' => esc_html__( 'Settings', 'ecotech' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Tab style', 'ecotech' ),
                'options' => ecotech_preview_options( $this->get_name() ),
                'default' => 'style-01',
            ]
        );

        $this->add_control(
            'list_style',
            array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'List style', 'ecotech' ),
                'options' => [
                    'none' => esc_html__( 'None', 'ecotech' ),
                    'grid' => esc_html__( 'Bootstrap', 'ecotech' ),
                    'owl'  => esc_html__( 'Carousel', 'ecotech' ),
                ],
                'default' => 'owl',
            )
        );

        $this->add_control(
            'product_style',
            array(
                'type'        => Controls_Manager::SELECT,
                'label'       => esc_html__( 'Product style', 'ecotech' ),
                'options'     => ecotech_product_options( 'Shortcode', true ),
                'default'     => 'style-01',
                'description' => esc_html__( 'Select a style for product item', 'ecotech' ),
            )
        );

        $this->product_size_field();

        $this->add_control(
            'disable_labels',
            [
                'label' => esc_html__( 'Disable Labels', 'ecotech' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'disable_rating',
            [
                'label' => esc_html__( 'Disable Rating', 'ecotech' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'short_text',
            [
                'label'       => esc_html__( 'Short Title', 'ecotech' ),
                'description' => esc_html__( 'Cut title by css to one line.', 'ecotech' ),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'disable_border',
            [
                'label'        => esc_html__( 'Disable Border', 'ecotech' ),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'border-not-',
                'condition'    => [
                    'product_style' => [
                        'style-01',
                        'style-14',
                    ]
                ],
            ]
        );

        $this->add_control(
            'product_hover',
            array(
                'type'      => Controls_Manager::COLOR,
                'label'     => esc_html__( 'Product Hover', 'ecotech' ),
                'selectors' => [
                    '{{WRAPPER}} .product-item.style-12 .product-inner' => '--main-product-bg: {{VALUE}}',
                ],
                'condition' => [
                    'product_style' => 'style-12',
                ],
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title',
            [
                'label' => esc_html__( 'Title', 'ecotech' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'type'  => Controls_Manager::TEXT,
                'label' => esc_html__( 'Title', 'ecotech' ),
            ]
        );

        $this->add_control(
            'active',
            [
                'label'   => esc_html__( 'Active', 'ecotech' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
            ]
        );

        $this->add_control(
            'is_ajax',
            [
                'label' => esc_html__( 'Enable ajax', 'ecotech' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'tab_link',
            [
                'label'       => esc_html__( 'Link', 'ecotech' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'ecotech' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition'   => [
                    'style' => 'style-04',
                ],
            ]
        );

        $this->add_control(
            'tab_btn',
            [
                'type'      => Controls_Manager::TEXT,
                'label'     => esc_html__( 'Button Text', 'ecotech' ),
                'condition' => [
                    'style' => 'style-04',
                ],
            ]
        );

        $this->add_control(
            'tab_image',
            [
                'type'      => Controls_Manager::MEDIA,
                'label'     => esc_html__( 'Image Hover', 'ecotech' ),
                'selectors' => [
                    '{{WRAPPER}}' => '--tab-image: url({{URL}});',
                ],
                'condition' => [
                    'style' => 'style-06',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'tab_section',
            [
                'tab'   => Controls_Manager::TAB_CONTENT,
                'label' => esc_html__( 'Tab Content', 'ecotech' ),
            ]
        );

        $repeater = new Elementor\Repeater();

        $repeater->start_controls_tabs( 'tab_repeater' );

        $repeater->start_controls_tab(
            'tab_title',
            [
                'label' => esc_html__( 'Title', 'ecotech' ),
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'ecotech' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Tab Title', 'ecotech' ),
                'placeholder' => esc_html__( 'Tab Title', 'ecotech' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label'   => esc_html__( 'Content', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'product'  => esc_html__( 'Products', 'ecotech' ),
                    'template' => esc_html__( 'Template', 'ecotech' ),
                    'link'     => esc_html__( 'Simple Link', 'ecotech' ),
                ],
                'default' => 'product',
            ]
        );

        $repeater->add_control(
            'selected_media',
            [
                'label'   => esc_html__( 'Media', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__( 'Image', 'ecotech' ),
                    'icon'  => esc_html__( 'Icon', 'ecotech' ),
                ],
                'default' => 'image',
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label'            => esc_html__( 'Icon', 'ecotech' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition'        => [
                    'selected_media' => 'icon'
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'     => esc_html__( 'Image', 'ecotech' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'selected_media' => 'image'
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__( 'Link', 'ecotech' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'ecotech' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition'   => [
                    'content' => 'link',
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'tab_template',
            [
                'label'     => esc_html__( 'Template', 'ecotech' ),
                'condition' => [
                    'content' => 'template',
                ],
            ]
        );

        if ( class_exists( 'ElementorPro\Modules\QueryControl\Module' ) ) {
            $repeater->add_control(
                'template_id',
                [
                    'label'        => esc_html__( 'Template ID', 'ecotech' ),
                    'type'         => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'options'      => [],
                    'label_block'  => true,
                    'multiple'     => false,
                    'autocomplete' => [
                        'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'elementor_library'
                        ],
                    ],
                    'description'  => sprintf( '%s <a href="%s" target="_blank">%s</a>',
                        esc_html__( 'Create template from', 'ecotech' ),
                        admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ),
                        esc_html__( 'Here', 'ecotech' )
                    ),
                    'export'       => false,
                ]
            );
        } else {
            $repeater->add_control(
                'template_id',
                [
                    'label'       => esc_html__( 'Template ID', 'ecotech' ),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => '1',
                    'description' => sprintf( '%s <a href="%s" target="_blank">%s</a>',
                        esc_html__( 'Create template from', 'ecotech' ),
                        admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ),
                        esc_html__( 'Here', 'ecotech' )
                    ),
                ]
            );
        }

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'tab_product',
            [
                'label'     => esc_html__( 'Product', 'ecotech' ),
                'condition' => [
                    'content' => 'product',
                ],
            ]
        );

        $repeater->add_control(
            'target',
            [
                'label'   => esc_html__( 'Target', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'recent_products'       => esc_html__( 'Recent Products', 'ecotech' ),
                    'featured_products'     => esc_html__( 'Feature Products', 'ecotech' ),
                    'sale_products'         => esc_html__( 'Sale Products', 'ecotech' ),
                    'best_selling_products' => esc_html__( 'Best Selling Products', 'ecotech' ),
                    'top_rated_products'    => esc_html__( 'Top Rated Products', 'ecotech' ),
                    'products'              => esc_html__( 'Products', 'ecotech' ),
                    'product_category'      => esc_html__( 'Products Category', 'ecotech' ),
                    'related_products'      => esc_html__( 'Products Related', 'ecotech' ),
                ],
                'default' => 'recent_products',
            ]
        );

        if ( class_exists( 'ElementorPro\Modules\QueryControl\Module' ) ) {
            $repeater->add_control(
                'ids',
                [
                    'label'        => esc_html__( 'Search Product', 'ecotech' ),
                    'type'         => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'options'      => [],
                    'label_block'  => true,
                    'multiple'     => true,
                    'autocomplete' => [
                        'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'product'
                        ],
                    ],
                    'condition'    => [
                        'target' => 'products'
                    ],
                    'export'       => false,
                ]
            );
        } else {
            $repeater->add_control(
                'ids',
                [
                    'label'       => esc_html__( 'Product', 'ecotech' ),
                    'type'        => Controls_Manager::TEXT,
                    'description' => esc_html__( 'Product ids', 'ecotech' ),
                    'placeholder' => '1,2,3',
                    'label_block' => true,
                    'condition'   => [
                        'target' => 'products'
                    ],
                ]
            );
        }

        $repeater->add_control(
            'category',
            [
                'label'       => esc_html__( 'Products Category', 'ecotech' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_taxonomy( [
                    'hide_empty' => true,
                    'taxonomy'   => 'product_cat',
                ] ),
                'label_block' => true,
                'condition'   => [
                    'target!' => 'products'
                ],
            ]
        );

        $repeater->add_control(
            'limit',
            [
                'label'       => esc_html__( 'Limit', 'ecotech' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 6,
                'placeholder' => 6,
            ]
        );

        $repeater->add_control(
            'orderby',
            [
                'label'   => esc_html__( 'Order by', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''              => esc_html__( 'None', 'ecotech' ),
                    'date'          => esc_html__( 'Date', 'ecotech' ),
                    'ID'            => esc_html__( 'ID', 'ecotech' ),
                    'author'        => esc_html__( 'Author', 'ecotech' ),
                    'title'         => esc_html__( 'Title', 'ecotech' ),
                    'modified'      => esc_html__( 'Modified', 'ecotech' ),
                    'rand'          => esc_html__( 'Random', 'ecotech' ),
                    'comment_count' => esc_html__( 'Comment count', 'ecotech' ),
                    'menu_order'    => esc_html__( 'Menu order', 'ecotech' ),
                    'price'         => esc_html__( 'Price: low to high', 'ecotech' ),
                    'price-desc'    => esc_html__( 'Price: high to low', 'ecotech' ),
                    'rating'        => esc_html__( 'Average Rating', 'ecotech' ),
                    'popularity'    => esc_html__( 'Popularity', 'ecotech' ),
                    'post__in'      => esc_html__( 'Post In', 'ecotech' ),
                    'most-viewed'   => esc_html__( 'Most Viewed', 'ecotech' ),
                ],
            ]
        );

        $repeater->add_control(
            'order',
            [
                'label'   => esc_html__( 'Sort order', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''     => esc_html__( 'None', 'ecotech' ),
                    'DESC' => esc_html__( 'Descending', 'ecotech' ),
                    'ASC'  => esc_html__( 'Ascending', 'ecotech' ),
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'tabs',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_section',
            [
                'tab'       => Controls_Manager::TAB_SETTINGS,
                'label'     => esc_html__( 'Carousel settings', 'ecotech' ),
                'condition' => [
                    'list_style' => 'owl',
                ],
            ]
        );

        $this->add_control(
            'slide_nav',
            [
                'label'   => esc_html__( 'Nav style', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''       => esc_html__( 'Default', 'ecotech' ),
                    'nav-02' => esc_html__( 'Style 02', 'ecotech' ),
                ],
            ]
        );

        $this->add_control(
            'slide_dot',
            [
                'label'   => esc_html__( 'Dot style', 'ecotech' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''       => esc_html__( 'Default', 'ecotech' ),
                    'dot-02' => esc_html__( 'Style 02', 'ecotech' ),
                    'dot-03' => esc_html__( 'Style 03', 'ecotech' ),
                ],
            ]
        );

        $this->carousel_settings( false );

        $this->end_controls_section();

        $this->bootstrap_settings( [
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'label'     => esc_html__( 'Bootstrap settings', 'ecotech' ),
            'condition' => [
                'list_style' => 'grid',
            ],
        ] );
    }
}