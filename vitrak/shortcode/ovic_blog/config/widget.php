<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Widget_Ovic_Blog' ) ) {
    class Widget_Ovic_Blog extends OVIC_Widget
    {
        /**
         * Constructor.
         */
        public function __construct()
        {
            $this->widget_cssclass    = 'ovic-blog';
            $this->widget_description = 'Display the customer blog.';
            $this->widget_id          = 'ovic_blog';
            $this->widget_name        = esc_html__( 'Ovic: Blog', 'ecotech' );
            $this->settings           = array(
                'title'    => array(
                    'type'  => 'text',
                    'title' => esc_html__( 'Title', 'ecotech' ),
                ),
                'style'    => array(
                    'type'    => 'select_preview',
                    'title'   => esc_html__( 'Select style', 'ecotech' ),
                    'options' => ecotech_file_options( '/shortcode/ovic_blog/layout/', '' ),
                    'default' => 'style-01',
                ),
                'target'   => array(
                    'type'       => 'select',
                    'title'      => esc_html__( 'Target', 'ecotech' ),
                    'options'    => array(
                        'recent_post' => esc_html__( 'Recent post', 'ecotech' ),
                        'popularity'  => esc_html__( 'Popularity', 'ecotech' ),
                        'date'        => esc_html__( 'Date', 'ecotech' ),
                        'title'       => esc_html__( 'Title', 'ecotech' ),
                        'random'      => esc_html__( 'Random', 'ecotech' ),
                    ),
                    'attributes' => array(
                        'data-depend-id' => 'target',
                        'style'          => 'width:100%',
                    ),
                    'default'    => 'recent_post',
                ),
                'category' => array(
                    'type'           => 'select',
                    'title'          => esc_html__( 'Category Blog', 'ecotech' ),
                    'options'        => 'categories',
                    'chosen'         => true,
                    'query_args'     => array(
                        'orderby' => 'name',
                        'order'   => 'ASC',
                    ),
                    'default_option' => esc_html__( 'Select a category', 'ecotech' ),
                    'placeholder'    => esc_html__( 'Select a category', 'ecotech' ),
                ),
                'limit'    => array(
                    'type'        => 'number',
                    'unit'        => 'items(s)',
                    'default'     => '6',
                    'title'       => esc_html__( 'Limit', 'ecotech' ),
                    'description' => esc_html__( 'How much items per page to show', 'ecotech' ),
                ),
                'orderby'  => array(
                    'type'        => 'select',
                    'title'       => esc_html__( 'Order by', 'ecotech' ),
                    'options'     => array(
                        ''              => esc_html__( 'None', 'ecotech' ),
                        'date'          => esc_html__( 'Date', 'ecotech' ),
                        'ID'            => esc_html__( 'ID', 'ecotech' ),
                        'author'        => esc_html__( 'Author', 'ecotech' ),
                        'title'         => esc_html__( 'Title', 'ecotech' ),
                        'modified'      => esc_html__( 'Modified', 'ecotech' ),
                        'rand'          => esc_html__( 'Random', 'ecotech' ),
                        'comment_count' => esc_html__( 'Comment count', 'ecotech' ),
                        'menu_order'    => esc_html__( 'Menu order', 'ecotech' ),
                    ),
                    'attributes'  => array(
                        'style' => 'width:100%',
                    ),
                    'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.',
                        'ecotech' ),
                        '<a href="' . esc_url( 'http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters' ) . '" target="_blank">' . esc_html__( 'WordPress codex page',
                            'ecotech' ) . '</a>' ),
                ),
                'order'    => array(
                    'type'        => 'select',
                    'title'       => esc_html__( 'Sort order', 'ecotech' ),
                    'options'     => array(
                        ''     => esc_html__( 'None', 'ecotech' ),
                        'DESC' => esc_html__( 'Descending', 'ecotech' ),
                        'ASC'  => esc_html__( 'Ascending', 'ecotech' ),
                    ),
                    'attributes'  => array(
                        'style' => 'width:100%',
                    ),
                    'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.',
                        'ecotech' ),
                        '<a href="' . esc_url( 'http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters' ) . '" target="_blank">' . esc_html__( 'WordPress codex page',
                            'ecotech' ) . '</a>' ),
                ),
            );

            parent::__construct();
        }

        /**
         * Output widget.
         *
         * @param  array $args
         * @param  array $instance
         *
         * @see WP_Widget
         *
         */
        public function widget( $args, $instance )
        {
            $atts                        = $instance;
            $atts[ 'title' ]             = '';
            $atts[ 'slides_rows_space' ] = 'rows-space-15';
            $atts[ 'carousel' ]          = array(
                'slidesToShow' => 1,
                'rows'         => 3,
                'slidesMargin' => 30,
                'dots'         => false,
                'arrows'       => true,
                'infinite'     => true,
                'autoplay'     => false,
            );

            $this->widget_start( $args, $instance );

            unset( $instance[ 'title' ] );

            echo ovic_do_shortcode( 'ovic_blog', $atts );

            $this->widget_end( $args );
        }
    }
}