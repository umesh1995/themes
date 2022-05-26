<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

use \Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Breadcrumb extends Ovic_Widget_Elementor
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
		return 'ovic_breadcrumb';
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
		return esc_html__( 'Breadcrumbs', 'ecotech' );
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
		return array( 'ovic' );
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

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		echo ovic_do_shortcode( $this->get_name(), $settings );
	}
}