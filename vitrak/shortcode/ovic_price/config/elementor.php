<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Ovic_Price extends Ovic_Widget_Elementor
{

    public function get_name()
    {
        return 'ovic_price';
    }

    public function get_title()
    {
        return esc_html__('Product Price', 'ecotech');
    }

    public function get_icon()
    {
        return 'eicon-product-price';
    }

    public function get_keywords()
    {
        return ['woocommerce', 'shop', 'store', 'price', 'product', 'sale'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_price_style',
            [
                'label' => esc_html__('Price', 'ecotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wc_style_warning',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => esc_html__('The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'ecotech'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        if (class_exists('ElementorPro\Modules\QueryControl\Module')) {
            $this->add_control(
                'product_id',
                [
                    'label'        => esc_html__('Search Product', 'ecotech'),
                    'type'         => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'options'      => [],
                    'label_block'  => true,
                    'autocomplete' => [
                        'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'product'
                        ],
                    ],
                    'export'       => false,
                ]
            );
        } else {
            $this->add_control(
                'product_id',
                [
                    'label'       => esc_html__('Product', 'ecotech'),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => '1',
                    'label_block' => true,
                ]
            );
        }

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => esc_html__('Alignment', 'ecotech'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'ecotech'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ecotech'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'ecotech'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Color', 'ecotech'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .price .amount' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .price .amount',
            ]
        );

        $this->add_control(
            'sale_heading',
            [
                'label'     => esc_html__('Sale Price', 'ecotech'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sale_price_color',
            [
                'label'     => esc_html__('Color', 'ecotech'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price ins .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'selector' => '{{WRAPPER}} .price ins .amount',
            ]
        );

        $this->add_control(
            'price_block',
            [
                'label'        => esc_html__('Stacked', 'ecotech'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'prefix_class' => 'elementor-product-price-block-',
            ]
        );

        $this->add_responsive_control(
            'sale_price_spacing',
            [
                'label'      => esc_html__('Spacing', 'ecotech'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'em' => [
                        'min'  => 0,
                        'max'  => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    'body:not(.rtl) {{WRAPPER}}:not(.elementor-product-price-block-yes) ins' => 'margin-right: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}}:not(.elementor-product-price-block-yes) ins'       => 'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-product-price-block-yes ins'                      => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
