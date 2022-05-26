<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

use \Elementor\Controls_Manager as Controls_Manager;

class Elementor_Ovic_Keyword extends Ovic_Widget_Elementor
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
		return 'ovic_keyword';
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
		return esc_html__( 'Keyword', 'ecotech' );
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
		return 'eicon-bullet-list';
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
		return array( 'ovic', 'Keyword' );
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'ecotech' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'ecotech' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
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
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		echo ovic_do_shortcode( $this->get_name(), $settings );
	}
}