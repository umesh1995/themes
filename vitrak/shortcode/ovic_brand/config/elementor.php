<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Brand extends Ovic_Widget_Elementor
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
        return 'ovic_brand';
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
        return esc_html__( 'Brand', 'ecotech' );
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
                'options' => ecotech_preview_options(
                    $this->get_name()
                ),
                'default' => 'style-01',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'ecotech' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'brands',
            [
                'label'       => esc_html__( 'Products Brand', 'ecotech' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_taxonomy( [
                    'hide_empty' => false,
                    'taxonomy'   => 'product_brand',
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
                    '{{WRAPPER}} .brand-item .link' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'      => esc_html__( 'Spacing', 'ecotech' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .brand-item .link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_effect',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Hover Animation', 'ecotech' ),
                'options' => [
                    'none'                         => esc_html__( 'None', 'ecotech' ),
                    'effect normal-effect'         => esc_html__( 'Normal Effect', 'ecotech' ),
                    'effect normal-effect dark-bg' => esc_html__( 'Normal Effect Dark', 'ecotech' ),
                    'effect effect faded-in'       => esc_html__( 'Faded In', 'ecotech' ),
                    'effect bounce-in'             => esc_html__( 'Bounce In', 'ecotech' ),
                    'effect gray-filter'           => esc_html__( 'Gray Filter', 'ecotech' ),
                    'effect background-zoom'       => esc_html__( 'Background Zoom', 'ecotech' ),
                ],
                'default' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->carousel_settings( [
            'tab'   => Controls_Manager::TAB_SETTINGS,
            'label' => esc_html__( 'Carousel', 'ecotech' ),
        ] );
    }
}