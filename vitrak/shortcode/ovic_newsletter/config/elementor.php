<?php
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

use Elementor\Core\Schemes;
use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Newsletter extends Ovic_Widget_Elementor
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
        return 'ovic_newsletter';
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
        return esc_html__( 'Newsletter', 'ecotech' );
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
        return 'eicon-yoast';
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
                'label'   => esc_html__( 'Style', 'ecotech' ),
                'options' => ecotech_preview_options( $this->get_name() ),
                'default' => 'style-01',
            ]
        );

        $this->add_control(
            'title',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__( 'Title', 'ecotech' ),
                'label_block' => true,
                'condition'   => [
                    'style' => [
                        'style-01',
                        'style-06',
                        'style-07',
                    ],
                ],
            ]
        );

        $this->add_control(
            'desc',
            [
                'type'      => Controls_Manager::TEXTAREA,
                'label'     => esc_html__( 'Description', 'ecotech' ),
                'condition' => [
                    'style' => [
                        'style-01',
                        'style-06',
                        'style-07',
                    ],
                ],
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__( 'Placeholder', 'ecotech' ),
                'default'     => esc_html__( 'Your E-mail address...', 'ecotech' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button',
            [
                'type'    => Controls_Manager::TEXT,
                'label'   => esc_html__( 'Button', 'ecotech' ),
                'default' => esc_html__( 'SIGN IN', 'ecotech' ),
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

        $this->end_controls_section();
    }
}