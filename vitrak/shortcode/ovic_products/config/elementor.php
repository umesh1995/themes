<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Products extends Ovic_Widget_Elementor
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
        return 'ovic_products';
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
        return esc_html__( 'Products', 'ecotech' );
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
        return 'eicon-woocommerce';
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'general_section',
            array(
                'tab'   => Controls_Manager::TAB_CONTENT,
                'label' => esc_html__( 'General', 'ecotech' ),
            )
        );

        $this->start_controls_tabs( 'tabs_general' );

        $this->start_controls_tab(
            'tab_general',
            [
                'label' => esc_html__( 'Settings', 'ecotech' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__( 'Title', 'ecotech' ),
            ]
        );

        $this->add_control(
            'desc',
            [
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__( 'Descriptions', 'ecotech' ),
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
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'product_space',
            [
                'label'     => esc_html__( 'Space', 'ecotech' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_products',
            [
                'label' => esc_html__( 'Products', 'ecotech' ),
            ]
        );

        $this->add_control(
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
            $this->add_control(
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
            $this->add_control(
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

        $this->add_control(
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

        $this->add_control(
            'limit',
            [
                'label'       => esc_html__( 'Limit', 'ecotech' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 6,
                'placeholder' => 6,
            ]
        );

        $this->add_control(
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

        $this->add_control(
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

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
                    'nav-03' => esc_html__( 'Style 03', 'ecotech' ),
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