<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Keyword"
 * @version 1.0.0
 */
class Shortcode_Ovic_Keyword extends Ovic_Addon_Shortcode
{
	/**
	 * Shortcode name.
	 *
	 * @var  string
	 */
	public $shortcode = 'ovic_keyword';

	public function content( $atts, $content = null )
	{
		$css_class = $this->main_class( $atts,
			array(
				'ovic-keyword'
			)
		);
		ob_start();
		?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
			<?php
			if ( ! empty( $atts['title'] ) ) {
				echo '<h3 class="title">' . esc_html( $atts['title'] ) . '</h3>';
			}
			?>
			<?php if ( ! empty( $atts['tabs'] ) ): ?>
                <ul class="list">
					<?php foreach ( $atts['tabs'] as $tab ) : ?>
						<?php $link = $this->add_link_attributes( $tab['link'], true ); ?>
						<?php if ( ! empty( $tab['title'] ) ): ?>
                            <li>
                                <a <?php echo esc_attr( $link ); ?> class="link">
                                    <?php echo esc_html( $tab['title'] ); ?>
                                </a>
                            </li>
						<?php endif; ?>
					<?php endforeach; ?>
                </ul>
			<?php endif; ?>
        </div>
		<?php
		return ob_get_clean();
	}
}