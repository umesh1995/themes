<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Slide"
 * @version 1.0.0
 */
class Shortcode_Ovic_Slide extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_slide';
    public $default   = array(
        'style'             => 'style-01',
        'slides_rows_space' => '',
    );

    public function content( $atts, $content = null )
    {
        $owl_settings            = $this->generate_carousel( $atts );
        $css_class               = $this->main_class( $atts, array(
            'ovic-slide',
            $atts[ 'style' ]
        ) );
        $class_item              = 'slide-item ' . $atts[ 'slides_rows_space' ];
        $atts[ 'link' ][ 'url' ] = apply_filters( 'ovic_shortcode_vc_link', $atts[ 'link' ][ 'url' ] );
        $link                    = $this->add_link_attributes( $atts[ 'link' ], true );
        ob_start();
        ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <?php if ( $atts[ 'style' ] == 'style-01' || $atts[ 'style' ] == 'style-03' ) : ?>
                <?php
                $this->get_template( "layout/style-01.php",
                    array(
                        'atts'         => $atts,
                        'link'         => $link,
                        'owl_settings' => $owl_settings,
                    )
                );
                ?>
            <?php else : ?>
                <?php if ( !empty( $atts[ 'tabs' ] ) ): ?>
                    <div class="owl-slick equal-container better-height" <?php echo esc_attr( $owl_settings ); ?>>
                        <?php foreach ( $atts[ 'tabs' ] as $tab ) : ?>
                            <?php
                            $link       = $this->add_link_attributes( $tab[ 'link' ], true );
                            $title      = !empty( $tab[ 'title' ] ) ? $tab[ 'title' ] : '';
                            $class_item .= ' elementor-repeater-item-' . $tab[ '_id' ];
                            ?>
                            <div class="<?php echo esc_attr( $class_item ); ?>">
                                <a <?php echo esc_attr( $link ); ?>>
                                    <?php if ( $tab[ 'selected_media' ] == 'icon' ): ?>
                                        <?php if ( !empty( $tab[ 'selected_icon' ][ 'value' ] ) ): ?>
                                            <span class="icon equal-elem <?php echo esc_attr( $tab[ 'selected_icon' ][ 'library' ] ); ?>">
                                            <?php
                                            \Elementor\Icons_Manager::render_icon( $tab[ 'selected_icon' ], [ 'aria-hidden' => 'true' ] );
                                            ?>
                                        </span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if ( !empty( $tab[ 'image' ][ 'url' ] ) ): ?>
                                            <span class="icon equal-elem type-image">
                                            <img src="<?php echo esc_url( $tab[ 'image' ][ 'url' ] ); ?>"
                                                 alt="<?php echo esc_attr( $title ); ?>">
                                        </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="content">
                                        <?php if ( !empty( $tab[ 'title' ] ) ): ?>
                                            <span class="title"><?php echo esc_html( $title ); ?></span>
                                        <?php endif; ?>
                                        <?php if ( !empty( $tab[ 'desc' ] ) ): ?>
                                            <span class="desc"><?php echo wp_specialchars_decode( $tab[ 'desc' ] ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}