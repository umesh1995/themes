<?php
if (!defined('ABSPATH')) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Slide extends Ovic_Widget_Elementor
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
        return 'ovic_slide';
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
        return esc_html__('Slide', 'ecotech');
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
        return 'eicon-slider-push';
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
            'title',
            [
                'label'       => esc_html__('Title', 'ecotech'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'condition'   => [
                    'style' => [
                        'style-01',
                        'style-03',
                    ]
                ],
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'       => esc_html__('Subtitle', 'ecotech'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'condition'   => [
                    'style' => [
                        'style-01',
                        'style-03',
                    ]
                ],
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label'     => esc_html__('Gallery', 'ecotech'),
                'type'      => Controls_Manager::GALLERY,
                'condition' => [
                    'style' => [
                        'style-01',
                        'style-03',
                    ]
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => esc_html__('Link', 'ecotech'),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
                'condition'   => [
                    'style' => [
                        'style-01',
                        'style-03',
                    ]
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_section',
            array(
                'tab'       => Controls_Manager::TAB_CONTENT,
                'label'     => esc_html__('Slide items', 'ecotech'),
                'condition' => [
                    'style' => [
                        'style-02',
                    ]
                ],
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'selected_media',
            [
                'label'   => esc_html__('Media', 'ecotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__('Image', 'ecotech'),
                    'icon'  => esc_html__('Icon', 'ecotech'),
                ],
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label'            => esc_html__('Icon', 'ecotech'),
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
                'label'     => esc_html__('Image', 'ecotech'),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'selected_media' => 'image'
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'ecotech'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Title', 'ecotech'),
                'placeholder' => esc_html__('Title', 'ecotech'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'desc',
            [
                'label'       => esc_html__('Description', 'ecotech'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__('Description', 'ecotech'),
                'placeholder' => esc_html__('Description', 'ecotech'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__('Link', 'ecotech'),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tabs',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ title }}}',
            ]
        );

        $this->end_controls_section();

        $this->carousel_settings();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo ovic_do_shortcode($this->get_name(), $settings);
    }
}