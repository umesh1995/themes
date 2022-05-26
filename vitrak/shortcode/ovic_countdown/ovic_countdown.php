<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Countdown"
 * @version 1.0.0
 */
class Shortcode_Ovic_Countdown extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_countdown';
    public $default   = array(
        'style' => 'style-01',
    );

    public function get_params( $params, $atts )
    {
        if ( $atts[ 'format' ] && $format = explode( ',', $atts[ 'format' ] ) ) {
            $format = (array)$format;
            foreach ( $params as $key => $param ) {
                if ( !in_array( $key, $format ) ) {
                    unset( $params[ $key ] );
                }
            }
        }

        return $params;
    }

    public function content( $atts, $content = null )
    {
        $classes = array(
            'ovic-countdown',
            $atts[ 'style' ]
        );
        if ( !empty( $atts[ 'date' ] ) ) {
            $atts[ 'date' ] = apply_filters( 'ovic_change_datetime_countdown', $atts[ 'date' ], 0 );
        }
        $css_class = $this->main_class( $atts, $classes );

        ob_start();
        ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <?php if ( !empty( $atts[ 'date' ] ) ):
                $params = array(
                    'days_text' => esc_html__( 'Days', 'ecotech' ),
                    'hrs_text'  => esc_html__( 'Hours', 'ecotech' ),
                    'mins_text' => esc_html__( 'Mins', 'ecotech' ),
                    'secs_text' => esc_html__( 'Secs', 'ecotech' ),
                );
                if ( $atts[ 'style' ] == 'style-04' || $atts[ 'style' ] == 'style-05' )
                    $params = array(
                        'days_text' => esc_html__( 'Days', 'ecotech' ),
                        'hrs_text'  => esc_html__( 'Hours', 'ecotech' ),
                        'mins_text' => esc_html__( 'Minutes', 'ecotech' ),
                        'secs_text' => esc_html__( 'Seconds', 'ecotech' ),
                    );
                wp_enqueue_script( 'ecotech-countdown' );
                ?>
                <div class="ecotech-countdown-wrapper">
                    <div class="ecotech-countdown <?php if ( $atts[ 'style' ] == 'style-04' || $atts[ 'style' ] == 'style-05' ) echo esc_attr( 'special-font' ); ?>"
                         data-datetime="<?php echo esc_attr( $atts[ 'date' ] ); ?>"
                         data-params="<?php echo esc_attr( wp_json_encode( $params ) ) ?>">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php

        return ob_get_clean();
    }
}