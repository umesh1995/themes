<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Core\Schemes;
use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Category extends Ovic_Widget_Elementor
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
        return 'ovic_category';
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
        return esc_html__( 'Category', 'ecotech' );
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
        return 'eicon-product-categories';
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

        $this->add_control(
            'style',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Select style', 'ecotech' ),
                'options' => ecotech_preview_options( $this->get_name() ),
                'default' => 'style-01',
            ]
        );

        $this->add_control(
            'category',
            [
                'label'       => esc_html__( 'Products Category', 'ecotech' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_taxonomy( [
                    'hide_empty' => false,
                    'taxonomy'   => 'product_cat',
                ] ),
                'multiple'    => true,
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'     => esc_html__( 'Height', 'ecotech' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-item .thumb img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'     => esc_html__( 'Image', 'ecotech' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'style' => [ 'style-02', 'style-04' ],
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'ecotech' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'condition'   => [
                    'style' => [ 'style-02' ],
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'type'        => Controls_Manager::URL,
                'label'       => esc_html__( 'Link', 'ecotech' ),
                'placeholder' => esc_html__( 'https://your-link.com', 'ecotech' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition'   => [
                    'style' => [ 'style-02' ],
                ],
            ]
        );

        $this->add_control(
            'text_button',
            [
                'type'      => Controls_Manager::TEXT,
                'label'     => esc_html__( 'Text button', 'ecotech' ),
                'default'   => 'View all',
                'condition' => [
                    'style' => [ 'style-02' ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->carousel_settings( [
            'tab'       => Controls_Manager::TAB_CONTENT,
            'label'     => esc_html__( 'Carousel settings', 'ecotech' ),
            'condition' => [
                'style' => [
                    'style-01',
                    'style-03',
                    'style-04',
                ],
            ],
        ] );
    }
}