<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

use Elementor\Core\Files\Assets\Svg\Svg_Handler;

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Tabs"
 * @version 1.0.0
 */
class Shortcode_Ovic_Tabs extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_tabs';
    public $default   = array(
        'style'       => 'style-01',
        'template_id' => '0',
    );

    public function product_atts( $atts, $tab )
    {
        $carousel                              = $this->generate_carousel( $atts, 'slides_', false );
        $args                                  = $tab;
        $args[ 'carousel' ]                    = $carousel;
        $args[ 'list_style' ]                  = $atts[ 'list_style' ];
        $args[ 'disable_labels' ]              = $atts[ 'disable_labels' ];
        $args[ 'disable_rating' ]              = $atts[ 'disable_rating' ];
        $args[ 'short_text' ]                  = $atts[ 'short_text' ];
        $args[ 'slides_rows_space' ]           = $atts[ 'slides_rows_space' ];
        $args[ 'product_style' ]               = $atts[ 'product_style' ];
        $args[ 'product_image_size' ]          = $atts[ 'product_image_size' ];
        $args[ 'product_custom_thumb_width' ]  = $atts[ 'product_custom_thumb_width' ];
        $args[ 'product_custom_thumb_height' ] = $atts[ 'product_custom_thumb_height' ];
        $args[ 'slide_nav' ]                   = $atts[ 'slide_nav' ];
        $args[ 'slide_dot' ]                   = $atts[ 'slide_dot' ];
        unset( $args[ 'title' ] );
        unset( $args[ 'image' ] );
        unset( $args[ '_id' ] );

        return $args;
    }

    public function tab_content( $section )
    {
        foreach ( $section as $tag => $shortcode ) {
            if ( !is_array( $shortcode ) ) {
                if ( class_exists( 'Elementor\Plugin' ) ) {
                    echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $shortcode );
                } else {
                    $post_id = get_post( $shortcode );
                    $content = $post_id->post_content;
                    $content = apply_filters( 'the_content', $content );
                    $content = str_replace( ']]>', ']]>', $content );
                    echo wp_specialchars_decode( $content );
                }
            } else {
                echo ovic_do_shortcode( $tag, $shortcode );
            }
        }
    }

    public function content( $atts, $content = null )
    {
        $sections  = array();
        $is_ajax   = $atts[ 'is_ajax' ] == 'yes' ? 1 : 0;
        $classes   = array( 'ovic-tab', 'ovic-tabs', $atts[ 'style' ] );
        $css_class = $this->main_class( $atts, $classes );

        ob_start();
        ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <div class="tabs-head">
                <?php if ( !empty( $atts[ 'title' ] ) ) {
                    if ( $atts[ 'style' ] == 'style-01' ) {
                        echo '<h2 class="tabs-title">' . esc_html( $atts[ 'title' ] ) . '</h2>';
                    } else {
                        echo ovic_do_shortcode( 'ovic_title',
                            array( 'title' => $atts[ 'title' ] )
                        );
                    }
                } ?>
                <?php
                if ( $atts[ 'style' ] == 'style-04' && !empty( $atts[ 'tab_btn' ] ) ) {
                    $attributes = $this->add_link_attributes( $atts[ 'tab_link' ], true );
                    echo '<div class="button-wrap"><a ' . esc_attr( $attributes ) . ' class="button">';
                    echo esc_html( $atts[ 'tab_btn' ] );
                    echo '</a></div>';
                }
                ?>
                <ul class="tabs-list">
                    <?php if ( !empty( $atts[ 'tabs' ] ) ): ?>
                        <?php foreach ( $atts[ 'tabs' ] as $key => $tab ) : ?>
                            <?php
                            $count       = $key + 1;
                            $rendered    = array();
                            $data        = $tab[ 'template_id' ];
                            $class_items = array( 'tab-item' );
                            $class_link  = array( 'tab-link' );
                            $tab_id      = $tab[ '_id' ] . '-' . uniqid();

                            if ( $count == $atts[ 'active' ] ) {
                                $class_items[] = 'active';
                                $class_link[]  = 'loaded';
                            }

                            if ( $tab[ 'content' ] == 'product' ) {
                                $data = $this->product_atts( $atts, $tab );
                            }
                            $shortcode = array(
                                'ovic_products' => $data
                            );
                            if ( $tab[ 'content' ] != 'link' ) {
                                $sections[ $tab_id ] = $shortcode;
                            }
                            $shortcode = json_encode( $shortcode );

                            if ( $tab[ 'content' ] == 'link' && !empty( $tab[ 'link' ][ 'url' ] ) ) {
                                $attributes = $this->add_link_attributes( $tab[ 'link' ] );
                            } else {
                                $attributes = array(
                                    'class'        => implode( ' ', $class_link ),
                                    'href'         => '#tab-' . $tab_id,
                                    'data-ajax'    => $is_ajax,
                                    'data-animate' => 'fadeIn',
                                );
                                if ( $is_ajax == 1 ) {
                                    $attributes[ 'data-section' ] = $shortcode;
                                }
                            }

                            foreach ( $attributes as $name => $value ) {
                                if ( is_array( $value ) ) {
                                    $value = implode( ' ', $value );
                                }
                                $rendered[] = sprintf( '%1$s="%2$s"', $name, esc_attr( $value ) );
                            }
                            ?>
                            <li class="<?php echo esc_attr( implode( ' ', $class_items ) ); ?>">
                                <a <?php echo implode( ' ', $rendered ); ?>>
                                    <?php if ( $tab[ 'selected_media' ] == 'icon' ): ?>
                                        <?php if ( !empty( $tab[ 'selected_icon' ][ 'value' ] ) ): ?>
                                            <figure class="thumb type-icon">
                                                <?php
                                                \Elementor\Icons_Manager::render_icon( $tab[ 'selected_icon' ], [ 'aria-hidden' => 'true' ] );
                                                ?>
                                            </figure>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if ( !empty( $tab[ 'image' ][ 'url' ] ) ): ?>
                                            <figure class="thumb type-image">
                                                <?php
                                                if ( strpos( basename( $tab[ 'image' ][ 'url' ] ), '.svg' ) === false ) {
                                                    echo wp_get_attachment_image( $tab[ 'image' ][ 'id' ], 'full' );
                                                } else {
                                                    echo Svg_Handler::get_inline_svg( $tab[ 'image' ][ 'id' ] );
                                                }
                                                ?>
                                            </figure>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ( !empty( $tab[ 'title' ] ) ): ?>
                                        <span class="title"><?php echo esc_html( $tab[ 'title' ] ); ?></span>
                                    <?php endif; ?>
                                    <span class="hover"></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php
            $this->get_template( "layout/style-01.php", array(
                'atts'     => $atts,
                'tabs'     => $this,
                'sections' => $sections,
                'is_ajax'  => $is_ajax,
            ) );
            ?>
        </div>
        <?php

        return ob_get_clean();
    }
}