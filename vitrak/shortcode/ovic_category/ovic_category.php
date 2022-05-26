<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Category"
 * @version 1.0.0
 */
class Shortcode_Ovic_Category extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode      = 'ovic_category';
    public $is_woocommerce = true;
    public $default        = array(
        'style' => 'style-01',
    );

    public function content( $atts, $content = null )
    {
        $link      = $this->add_link_attributes( $atts[ 'link' ], true );
        $css_class = $this->main_class( $atts, array(
            'ovic-category',
            $atts[ 'style' ],
            'equal-container better-height'
        ) );
        if ( !empty( $atts[ 'image' ][ 'url' ] ) ) {
            $hover = 'background-image: url(' . esc_url( $atts[ 'image' ][ 'url' ] ) . ')';
        } else {
            $hover = 'background-color: var(--main-color); border-radius: 50%;';
        }

        ob_start(); ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <?php
            if ( $atts[ 'style' ] == 'style-02' ) {
                $this->get_template( "layout/{$atts['style']}.php",
                    array(
                        'atts' => $atts,
                        'cat'  => $this,
                        'link' => $link,
                    )
                );
            } else {
                if ( !empty( $atts[ 'category' ] ) ):
                    $owl_settings = $this->generate_carousel( $atts ); ?>
                    <div class="list-category owl-slick" <?php echo esc_attr( $owl_settings ); ?>>
                        <?php foreach ( $atts[ 'category' ] as $category ) : ?>
                            <?php
                            $term = get_term_by( 'slug', $category, 'product_cat' );
                            if ( !is_wp_error( $term ) && !empty( $term ) ): ?>
                                <?php
                                $term_link    = get_term_link( $term->term_id, 'product_cat' );
                                $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                                ?>
                                <div class="category-item">
                                    <a class="link <?php if ( $atts[ 'style' ] == 'style-04' ) echo esc_attr( 'special-font' ); ?>"
                                       href="<?php echo esc_url( $term_link ); ?>">
                                        <?php if ( !empty( $thumbnail_id ) ): ?>
                                            <figure class="thumb">
                                                <span class="hover" style="<?php echo esc_attr( $hover ); ?>"></span>
                                                <?php echo wp_get_attachment_image( $thumbnail_id, 'full' ); ?>
                                            </figure>
                                        <?php endif; ?>
                                        <span class="title"><?php echo esc_html( $term->name ); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif;
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}