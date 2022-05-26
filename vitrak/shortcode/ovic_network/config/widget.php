<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Widget_Ovic_Network' ) ) {
	class Widget_Ovic_Network extends OVIC_Widget
	{
		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$this->widget_cssclass    = 'ovic-network';
			$this->widget_description = 'Display the customer network.';
			$this->widget_id          = 'ovic_network';
			$this->widget_name        = esc_html__( 'Ovic: Social Network', 'ecotech' );
			$this->settings           = array(
				'title'                => array(
					'type'  => 'text',
					'title' => esc_html__( 'Title', 'ecotech' ),
				),
				'profile'              => array(
					'type'  => 'text',
					'title' => esc_html__( 'Link profile', 'ecotech' ),
				),
				'image_source'         => array(
					'type'       => 'select',
					'title'      => esc_html__( 'Image Source', 'ecotech' ),
					'options'    => [
						'instagram' => esc_html__( 'Instagram', 'ecotech' ),
						'flickr'    => esc_html__( 'Flickr', 'ecotech' ),
						'local'     => esc_html__( 'Local Image', 'ecotech' ),
					],
					'default'    => 'instagram',
					'attributes' => array(
						'data-depend-id' => 'image_source',
					),
				),
				'image_gallery'        => array(
					'type'       => 'gallery',
					'title'      => esc_html__( 'Local Image', 'ecotech' ),
					'dependency' => array( 'image_source', '==', 'local' ),
				),
				'instagram_resolution' => array(
					'type'       => 'select',
					'title'      => esc_html__( 'Image Resolution', 'ecotech' ),
					'options'    => [
						'thumbnail'           => esc_html__( 'Thumbnail', 'ecotech' ),
						'low_resolution'      => esc_html__( 'Low Resolution', 'ecotech' ),
						'standard_resolution' => esc_html__( 'Standard Resolution', 'ecotech' ),
					],
					'default'    => 'thumbnail',
					'dependency' => array( 'image_source', '==', 'instagram' ),
				),
				'id_instagram'         => array(
					'type'       => 'text',
					'title'      => esc_html__( 'ID Instagram', 'ecotech' ),
					'dependency' => array( 'image_source', '==', 'instagram' ),
				),
				'token'                => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Token Instagram', 'ecotech' ),
					'description' => sprintf( '<a href="%s" target="_blank">%s</a>',
						esc_url( 'https://instagram.pixelunion.net' ),
						esc_html__( 'Get Token Instagram Here!', 'ecotech' )
					),
					'dependency'  => array( 'image_source', '==', 'instagram' ),
				),
				'flickr_resolution'    => array(
					'type'       => 'select',
					'title'      => esc_html__( 'Image Resolution', 'ecotech' ),
					'options'    => [
						's' => esc_html__( 'Square ( 75x75 )', 'ecotech' ),
						'q' => esc_html__( 'Large Square ( 150x150 )', 'ecotech' ),
						't' => esc_html__( 'Thumbnail ( 100x75 )', 'ecotech' ),
						'n' => esc_html__( 'Small ( 320x240 )', 'ecotech' ),
						'c' => esc_html__( 'Medium ( 800x600 )', 'ecotech' ),
						'b' => esc_html__( 'Large ( 1024x768 )', 'ecotech' ),
						'o' => esc_html__( 'Original ( 2400x1800 )', 'ecotech' ),
					],
					'default'    => 't',
					'dependency' => array( 'image_source', '==', 'flickr' ),
				),
				'id_flickr'            => array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID Flickr', 'ecotech' ),
					'description' => sprintf( '<a href="%s" target="_blank">%s</a>',
						esc_url( 'https://www.webfx.com/tools/idgettr/' ),
						esc_html__( 'Get Token Flickr Here!', 'ecotech' )
					),
					'dependency'  => array( 'image_source', '==', 'flickr' ),
				),
				'items_limit'          => array(
					'type'        => 'number',
					'title'       => esc_html__( 'Items show', 'ecotech' ),
					'description' => esc_html__( 'the number items show', 'ecotech' ),
					'default'     => 4,
					'unit'        => 'items(s)',
					'dependency'  => array( 'image_source', 'any', 'flickr,instagram' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Output widget.
		 *
		 * @param  array  $args
		 * @param  array  $instance
		 *
		 * @see WP_Widget
		 *
		 */
		public function widget( $args, $instance )
		{
			$this->widget_start( $args, $instance );

			unset( $instance['title'] );

			$instance['slides_rows_space'] = 'elem-space-10';

			echo ovic_do_shortcode( 'ovic_network', $instance );

			if ( ! empty( $instance['profile'] ) ) {
				echo '<a href="' . esc_url( $instance['profile'] ) . '"><i class="fa fa-instagram"></i>' . esc_html__( 'View profile', 'ecotech' ) . '</a>';
			}

			$this->widget_end( $args );
		}
	}
}