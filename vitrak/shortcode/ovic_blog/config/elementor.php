<?php
if (!defined('ABSPATH')) {
    exit();
}

use Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Blog extends Ovic_Widget_Elementor
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
        return 'ovic_blog';
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
        return esc_html__('Blog', 'ecotech');
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
        return 'eicon-post-list';
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
            'image_full_size',
            [
                'label' => esc_html__('Image Full size', 'ecotech'),
                'type'  => Controls_Manager::SWITCHER,
            ]
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
            'list_style',
            array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('List style', 'ecotech'),
                'options' => [
                    'none' => esc_html__('None', 'ecotech'),
                    'grid' => esc_html__('Bootstrap', 'ecotech'),
                    'owl'  => esc_html__('Carousel', 'ecotech'),
                ],
                'default' => 'owl',
            )
        );

        $this->add_control(
            'title',
            [
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'label'       => esc_html__('Title', 'ecotech'),
            ]
        );

        $this->add_control(
            'target',
            [
                'label'   => esc_html__('Target', 'ecotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'recent_post' => esc_html__('Latest', 'ecotech'),
                    'popularity'  => esc_html__('Popularity', 'ecotech'),
                    'related'     => esc_html__('Related', 'ecotech'),
                    'date'        => esc_html__('Date', 'ecotech'),
                    'title'       => esc_html__('Title', 'ecotech'),
                    'post'        => esc_html__('Post', 'ecotech'),
                    'random'      => esc_html__('Random', 'ecotech'),
                ],
                'default' => 'recent_post',
            ]
        );

        if (class_exists('ElementorPro\Modules\QueryControl\Module')) {
            $this->add_control(
                'ids',
                [
                    'label'        => esc_html__('Search Post', 'ecotech'),
                    'type'         => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'options'      => [],
                    'label_block'  => true,
                    'multiple'     => true,
                    'autocomplete' => [
                        'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'post'
                        ],
                    ],
                    'condition'    => [
                        'target' => 'post'
                    ],
                    'export'       => false,
                ]
            );
        } else {
            $this->add_control(
                'ids',
                [
                    'label'       => esc_html__('Post', 'ecotech'),
                    'type'        => Controls_Manager::TEXT,
                    'description' => esc_html__('Post ids', 'ecotech'),
                    'placeholder' => '1,2,3',
                    'label_block' => true,
                    'condition'   => [
                        'target' => 'post'
                    ],
                ]
            );
        }

        $this->add_control(
            'category',
            [
                'label'       => esc_html__('Category', 'ecotech'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_taxonomy([
                    'meta_key'   => '',
                    'hide_empty' => true,
                ]),
                'label_block' => true,
                'condition'   => [
                    'target!' => 'post'
                ],
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'       => esc_html__('Limit', 'ecotech'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 6,
                'placeholder' => 6,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order by', 'ecotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''              => esc_html__('None', 'ecotech'),
                    'date'          => esc_html__('Date', 'ecotech'),
                    'ID'            => esc_html__('ID', 'ecotech'),
                    'author'        => esc_html__('Author', 'ecotech'),
                    'title'         => esc_html__('Title', 'ecotech'),
                    'modified'      => esc_html__('Modified', 'ecotech'),
                    'rand'          => esc_html__('Random', 'ecotech'),
                    'comment_count' => esc_html__('Comment count', 'ecotech'),
                    'menu_order'    => esc_html__('Menu order', 'ecotech'),
                    'post__in'      => esc_html__('Post In', 'ecotech'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Sort order', 'ecotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''     => esc_html__('None', 'ecotech'),
                    'DESC' => esc_html__('Descending', 'ecotech'),
                    'ASC'  => esc_html__('Ascending', 'ecotech'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->carousel_settings([
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'label'     => esc_html__('Carousel settings', 'ecotech'),
            'condition' => [
                'list_style' => 'owl',
            ],
        ]);

        $this->bootstrap_settings([
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'label'     => esc_html__('Bootstrap settings', 'ecotech'),
            'condition' => [
                'list_style' => 'grid',
            ],
        ]);
    }
}