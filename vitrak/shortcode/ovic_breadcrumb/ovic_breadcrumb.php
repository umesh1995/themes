<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Breadcrumb"
 * @version 1.0.0
 */
class Shortcode_Ovic_Breadcrumb extends Ovic_Addon_Shortcode
{
	/**
	 * Shortcode name.
	 *
	 * @var  string
	 */
	public $shortcode = 'ovic_breadcrumb';
	public $default   = array(
		'style' => 'style-01',
	);

	public function content( $atts, $content = null )
	{
		$css_class = $this->main_class( $atts,
			array(
				'ovic-breadcrumb',
				$atts['style']
			)
		);
		ob_start();
		?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
			<?php ecotech_breadcrumb(); ?>
        </div>
		<?php
		return ob_get_clean();
	}
}