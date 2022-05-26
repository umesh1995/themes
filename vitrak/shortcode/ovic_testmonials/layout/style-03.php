<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $testmonial
 *
 */
$owl_settings = $testmonial->generate_carousel( $atts );
$background   = !empty( $atts[ 'background' ][ 'id' ] ) ? wp_get_attachment_image_url( $atts[ 'background' ][ 'id' ], 'full' ) : '';
?>
<span class="background" style="background-image: url(<?php echo esc_url( $background ); ?>)"></span>
<div class="owl-slick" <?php echo esc_attr( $owl_settings ); ?>>
    <?php foreach ( $atts[ 'tabs' ] as $tab ) : ?>
        <?php
        $name = !empty( $tab[ 'name' ] ) ? $tab[ 'name' ] : '';
        $link = $testmonial->add_link_attributes( $tab[ 'link' ], true );
        ?>
        <div class="item">
            <div class="head">
                <?php if ( !empty( $tab[ 'avatar' ][ 'id' ] ) ): ?>
                    <figure class="avatar">
                        <?php echo wp_get_attachment_image( $tab[ 'avatar' ][ 'id' ], 'full' ); ?>
                    </figure>
                <?php endif; ?>
                <div class="info">
                    <?php if ( !empty( $name ) ): ?>
                        <a <?php echo esc_attr( $link ); ?> class="name"><?php echo esc_html( $name ); ?></a>
                    <?php endif; ?>
                    <?php if ( !empty( $tab[ 'position' ] ) ): ?>
                        <p class="position"><?php echo esc_html( $tab[ 'position' ] ); ?></p>
                    <?php endif; ?>
                    <?php if ( !empty( $tab[ 'rating' ] ) ): ?>
                        <span class="star-rating">
                        <span style="width:<?php echo( ( (int)$tab[ 'rating' ] / 5 ) * 100 ); ?>%"></span>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ( !empty( $tab[ 'title' ] ) ): ?>
                <h3 class="title"><?php echo esc_html( $tab[ 'title' ] ); ?></h3>
            <?php endif; ?>
            <?php if ( !empty( $tab[ 'desc' ] ) ): ?>
                <p class="desc"><?php echo esc_html( $tab[ 'desc' ] ); ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>