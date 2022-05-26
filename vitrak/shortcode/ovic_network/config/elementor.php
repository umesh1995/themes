<?php
if (!defined('ABSPATH')) {
    exit();
}

use \Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Network extends Ovic_Widget_Elementor
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
        return 'ovic_network';
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
        return esc_html__('Social Network', 'ecotech');
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
        return 'eicon-image';
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
            'title',
            [
                'label'       => esc_html__('Title', 'ecotech'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'image_source',
            [
                'label'   => esc_html__('Image Source', 'ecotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'instagram' => esc_html__('Instagram', 'ecotech'),
                    'flickr'    => esc_html__('Flickr', 'ecotech'),
                    'local'     => esc_html__('Local Image', 'ecotech'),
                ],
                'default' => 'instagram',
            ]
        );

        $this->add_control(
            'image_gallery',
            [
                'label'     => esc_html__('Local Image', 'ecotech'),
                'type'      => Controls_Manager::GALLERY,
                'condition' => [
                    'image_source' => 'local'
                ],
            ]
        );

        $this->add_control(
            'instagram_resolution',
            [
                'label'     => esc_html__('Image Resolution', 'ecotech'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'thumbnail'           => esc_html__('Thumbnail', 'ecotech'),
                    'low_resolution'      => esc_html__('Low Resolution', 'ecotech'),
                    'standard_resolution' => esc_html__('Standard Resolution', 'ecotech'),
                ],
                'default'   => 'thumbnail',
                'condition' => [
                    'image_source' => 'instagram'
                ],
            ]
        );

        $this->add_control(
            'id_instagram',
            [
                'label'       => esc_html__('ID Instagram', 'ecotech'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'condition'   => [
                    'image_source' => 'instagram'
                ],
            ]
        );

        $this->add_control(
            'token',
            [
                'label'       => esc_html__('Token Instagram', 'ecotech'),
                'description' => sprintf('<a href="%s" target="_blank">%s</a>',
                    esc_url('https://instagram.pixelunion.net'),
                    esc_html__('Get Token Instagram Here!', 'ecotech')
                ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'condition'   => [
                    'image_source' => 'instagram'
                ],
            ]
        );

        $this->add_control(
            'flickr_resolution',
            [
                'label'     => esc_html__('Image Resolution', 'ecotech'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    's' => esc_html__('Square ( 75x75 )', 'ecotech'),
                    'q' => esc_html__('Large Square ( 150x150 )', 'ecotech'),
                    't' => esc_html__('Thumbnail ( 100x75 )', 'ecotech'),
                    'n' => esc_html__('Small ( 320x240 )', 'ecotech'),
                    'c' => esc_html__('Medium ( 800x600 )', 'ecotech'),
                    'b' => esc_html__('Large ( 1024x768 )', 'ecotech'),
                    'o' => esc_html__('Original ( 2400x1800 )', 'ecotech'),
                ],
                'default'   => 't',
                'condition' => [
                    'image_source' => 'flickr'
                ],
            ]
        );

        $this->add_control(
            'id_flickr',
            [
                'label'       => esc_html__('ID Flickr', 'ecotech'),
                'description' => sprintf('<a href="%s" target="_blank">%s</a>',
                    esc_url('https://www.webfx.com/tools/idgettr/'),
                    esc_html__('Get Token Flickr Here!', 'ecotech')
                ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'condition'   => [
                    'image_source' => 'flickr'
                ],
            ]
        );

        $this->add_control(
            'items_limit',
            [
                'label'       => esc_html__('Items show', 'ecotech'),
                'description' => esc_html__('the number items show', 'ecotech'),
                'default'     => 4,
                'type'        => Controls_Manager::NUMBER,
                'condition'   => [
                    'image_source' => ['flickr', 'instagram']
                ],
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