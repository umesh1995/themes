<?php
if (!defined('ABSPATH')) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Banner extends Ovic_Widget_Elementor
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
        return 'ovic_banner';
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
        return esc_html__('Banner', 'ecotech');
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
        return 'eicon-image-box';
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'general_section',
            array(
                'tab'   => Controls_Manager::TAB_CONTENT,
                'label' => esc_html__('General', 'ecotech'),
            )
        );

        $this->add_control(
            'style',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Select style', 'ecotech'),
                'options' => ecotech_preview_options(
                    $this->get_name()
                ),
                'default' => 'style-01',
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => esc_html__('Choose Image', 'ecotech'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'bg_position',
            [
                'label'     => esc_html__('Background Position', 'ecotech'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''              => esc_html__('Default', 'ecotech'),
                    'center center' => esc_html__('Center Center', 'ecotech'),
                    'center left'   => esc_html__('Center Left', 'ecotech'),
                    'center right'  => esc_html__('Center Right', 'ecotech'),
                    'top center'    => esc_html__('Top Center', 'ecotech'),
                    'top left'      => esc_html__('Top Left', 'ecotech'),
                    'top right'     => esc_html__('Top Right', 'ecotech'),
                    'bottom center' => esc_html__('Bottom Center', 'ecotech'),
                    'bottom left'   => esc_html__('Bottom Left', 'ecotech'),
                    'bottom right'  => esc_html__('Bottom Right', 'ecotech'),
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .ovic-banner .background' => 'background-position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'     => esc_html__('Height', 'ecotech'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ovic-banner .inner' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_01',
            [
                'type'        => Controls_Manager::TEXTAREA,
                'label'       => esc_html__('Text 01', 'ecotech'),
                'description' => esc_html__('some style use tag "span" for hight light', 'ecotech'),
                'condition'   => [
                    'style!' => [
                        'default',
                    ],
                ],
            ]
        );

        $this->add_control(
            'text_02',
            [
                'type'        => Controls_Manager::TEXTAREA,
                'label'       => esc_html__('Text 02', 'ecotech'),
                'description' => esc_html__('some style use tag "span" for hight light', 'ecotech'),
                'condition'   => [
                    'style!' => [
                        'default',
                    ],
                ],
            ]
        );


        $this->add_control(
            'text_03',
            [
                'type'        => Controls_Manager::TEXTAREA,
                'label'       => esc_html__('Text 03', 'ecotech'),
                'description' => esc_html__('some style use tag "span" for hight light', 'ecotech'),
                'condition'   => [
                    'style!' => [
                        'default',
                    ],
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'type'        => Controls_Manager::URL,
                'label'       => esc_html__('Link', 'ecotech'),
                'placeholder' => esc_html__('https://your-link.com', 'ecotech'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'text_button',
            [
                'type'    => Controls_Manager::TEXT,
                'label'   => esc_html__('Text button', 'ecotech'),
                'default' => 'SHOP NOW',
            ]
        );

        $this->add_control(
            'image_effect',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Hover Animation', 'ecotech'),
                'options' => [
                    'none'                          => esc_html__('None', 'ecotech'),
                    'zoom'                          => esc_html__('Zoom jquery', 'ecotech'),
                    'effect normal-effect'          => esc_html__('Normal Effect', 'ecotech'),
                    'effect normal-effect dark-bg'  => esc_html__('Normal Effect Dark', 'ecotech'),
                    'effect background-zoom'        => esc_html__('Background Zoom', 'ecotech'),
                    'effect background-slide'       => esc_html__('Background Slide', 'ecotech'),
                    'effect rotate-in rotate-left'  => esc_html__('Rotate Left In', 'ecotech'),
                    'effect rotate-in rotate-right' => esc_html__('Rotate Right In', 'ecotech'),
                    'effect plus-zoom'              => esc_html__('Plus Zoom', 'ecotech'),
                    'effect border-zoom'            => esc_html__('Border Zoom', 'ecotech'),
                    'effect border-scale'           => esc_html__('Border ScaleUp', 'ecotech'),
                    'effect border-plus'            => esc_html__('Border Plus', 'ecotech'),
                    'effect overlay-plus'           => esc_html__('Overlay Plus', 'ecotech'),
                    'effect overlay-cross'          => esc_html__('Overlay Cross', 'ecotech'),
                    'effect overlay-horizontal'     => esc_html__('Overlay Horizontal', 'ecotech'),
                    'effect overlay-vertical'       => esc_html__('Overlay Vertical', 'ecotech'),
                    'effect flashlight'             => esc_html__('Flashlight', 'ecotech'),
                ],
                'default' => 'none',
            ]
        );

        $this->end_controls_section();
    }
}