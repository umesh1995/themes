<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Core\Schemes;
use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Menu extends Ovic_Widget_Elementor
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
        return 'ovic_menu';
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
        return esc_html__( 'Menu', 'ecotech' );
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
        return 'eicon-nav-menu';
    }

    protected function _register_controls()
    {
        $options = array_merge(
            array(
                'default' => 'Default'
            ),
            ecotech_preview_options( $this->get_name() )
        );

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
                'options' => $options,
                'default' => 'default',
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

        $locations = array();
        $menus     = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        if ( !empty( $menus ) ) {
            foreach ( $menus as $menu ) {
                $locations[ $menu->slug ] = $menu->name;
            }
        }

        $this->add_control(
            'nav_menu',
            [
                'label_block' => true,
                'options'     => $locations,
                'type'        => Controls_Manager::SELECT2,
                'label'       => esc_html__( 'Menu', 'ecotech' ),
                'description' => esc_html__( 'Select menu to display.', 'ecotech' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => esc_html__( 'Link', 'ecotech' ),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__( 'Alignment', 'ecotech' ),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'ecotech' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'ecotech' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__( 'Right', 'ecotech' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'ecotech' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default'      => '',
            ]
        );

        $this->add_control(
            'toggle_mobile',
            [
                'label' => esc_html__( 'Toggle in mobile', 'ecotech' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'all_text',
            [
                'label'     => esc_html__( 'Text view all', 'ecotech' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'View All',
                'condition' => [
                    'style' => 'style-02'
                ],
            ]
        );

        $this->add_control(
            'close_text',
            [
                'label'     => esc_html__( 'Text close', 'ecotech' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Close',
                'condition' => [
                    'style' => 'style-02'
                ],
            ]
        );

        $this->add_control(
            'visible_item',
            [
                'label'     => esc_html__( 'Visible items', 'ecotech' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '10',
                'condition' => [
                    'style' => 'style-02'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => esc_html__( 'Menu style', 'ecotech' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__( 'Margin', 'ecotech' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ecotech' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__( 'Title Typography', 'ecotech' ),
                'name'     => 'typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label'     => esc_html__( 'Menu Color', 'ecotech' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} ul.menu'                => 'color: {{VALUE}};',
                    '{{WRAPPER}} ul.menu .menu-item > a' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__( 'Menu Typography', 'ecotech' ),
                'name'     => 'menu_typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} ul.menu',
            ]
        );

        $this->end_controls_section();
    }
}