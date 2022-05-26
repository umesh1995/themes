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
?>
<div class="owl-slick" <?php echo esc_attr( $owl_settings ); ?>>
    <?php foreach ( $atts[ 'tabs' ] as $tab ) : ?>
        <?php
        $name = !empty( $tab[ 'name' ] ) ? $tab[ 'name' ] : '';
        $link = $testmonial->add_link_attributes( $tab[ 'link' ], true );
        ?>
        <div class="item">
            <div class="inner">
                <?php if ( !empty( $tab[ 'avatar' ][ 'id' ] ) ): ?>
                    <a <?php echo esc_attr( $link ); ?> class="avatar">
                        <?php echo wp_get_attachment_image( $tab[ 'avatar' ][ 'id' ], 'full' ); ?>
                    </a>
                <?php endif; ?>
                <div class="content">
                    <?php if ( !empty( $tab[ 'title' ] ) ): ?>
                        <h3 class="title"><?php echo esc_html( $tab[ 'title' ] ); ?></h3>
                    <?php endif; ?>
                    <?php if ( !empty( $tab[ 'desc' ] ) ): ?>
                        <p class="desc">
                            <span class="quote special-font">“</span>
                            <?php echo esc_html( $tab[ 'desc' ] ); ?>
                        </p>
                    <?php endif; ?>
                    <?php if ( !empty( $name ) ): ?>
                        <a <?php echo esc_attr( $link ); ?> class="name"><?php echo esc_html( $name ); ?></a>
                    <?php endif; ?>
                    <?php if ( !empty( $tab[ 'position' ] ) ): ?>
                        <p class="position"><?php echo esc_html( $tab[ 'position' ] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>