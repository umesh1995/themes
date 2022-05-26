<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Testmonials extends Ovic_Widget_Elementor
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
        return 'ovic_testmonials';
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
        return esc_html__( 'Testmonials', 'ecotech' );
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
        return 'eicon-testimonial';
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
            'background',
            [
                'label'     => esc_html__( 'Background', 'ecotech' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'style' => [
                        'style-02',
                        'style-03',
                    ],
                ],
            ]
        );

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'avatar',
            [
                'label'   => esc_html__( 'Avatar', 'ecotech' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'title', 'ecotech' ),
                'type'  => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'desc',
            [
                'label' => esc_html__( 'Description', 'ecotech' ),
                'type'  => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'ecotech' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label'   => esc_html__( 'Rating', 'ecotech' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 5,
                'step'    => 0.1,
                'default' => 5,
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => esc_html__( 'Position', 'ecotech' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__( 'Link', 'ecotech' ),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tabs',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();

        $this->carousel_settings( [
            'tab'   => Controls_Manager::TAB_SETTINGS,
            'label' => esc_html__( 'Carousel settings', 'ecotech' ),
        ] );
    }
}