<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Testmonials"
 * @version 1.0.0
 */
class Shortcode_Ovic_Testmonials extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_testmonials';
    public $default   = array(
        'style' => 'style-01',
    );

    public function content( $atts, $content = null )
    {
        $css_class = $this->main_class( $atts, array(
            'ovic-testmonials',
            $atts[ 'style' ]
        ) );
        if ( $atts[ 'style' ] == 'style-02' )
            $css_class .= ' dot-02';

        ob_start();
        ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <?php
            if ( !empty( $atts[ 'tabs' ] ) ) {
                $this->get_template( "layout/{$atts['style']}.php",
                    array(
                        'atts'       => $atts,
                        'testmonial' => $this,
                    )
                );
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}