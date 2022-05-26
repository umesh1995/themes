<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $link
 *
 */
?>
<div class="inner">
    <?php if ( !empty( $atts[ 'image' ][ 'id' ] ) ): ?>
        <div class="thumb">
            <a <?php echo esc_attr( $link ); ?> class="effect background-zoom">
                <?php echo wp_get_attachment_image( $atts[ 'image' ][ 'id' ], 'full' ); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="content">
        <?php if ( !empty( $atts[ 'title' ] ) ): ?>
            <h3 class="title"><?php echo esc_html( $atts[ 'title' ] ); ?></h3>
        <?php endif; ?>
        <?php if ( !empty( $atts[ 'category' ] ) ): ?>
            <ul class="list-category">
                <?php foreach ( $atts[ 'category' ] as $category ) : ?>
                    <?php
                    $term = get_term_by( 'slug', $category, 'product_cat' );
                    if ( !is_wp_error( $term ) && !empty( $term ) ): ?>
                        <?php $term_link = get_term_link( $term->term_id, 'product_cat' ); ?>
                        <li>
                            <a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $term->name ); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ( !empty( $atts[ 'text_button' ] ) ): ?>
                    <li>
                        <a <?php echo esc_attr( $link ); ?> class="link">
                            <?php echo esc_html( $atts[ 'text_button' ] ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
