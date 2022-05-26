<?php
if (!defined('ABSPATH')) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Countdown extends Ovic_Widget_Elementor
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
        return 'ovic_countdown';
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
        return esc_html__('Countdown', 'ecotech');
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
        return 'eicon-countdown';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the image widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return array Widget categories.
     * @since 2.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return array('ovic');
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
                'options' => ecotech_preview_options($this->get_name()),
                'default' => 'style-01',
            ]
        );

        $this->add_control(
            'date',
            [
                'type'           => Controls_Manager::DATE_TIME,
                'label'          => esc_html__('Countdown', 'ecotech'),
                'picker_options' => [
                    'dateFormat' => 'm/j/Y H:i:s',
                    'time_24hr'  => true,
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__('Alignment', 'ecotech'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Left', 'ecotech'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'ecotech'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'ecotech'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'ecotech'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default'      => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo ovic_do_shortcode($this->get_name(), $settings);
    }
}