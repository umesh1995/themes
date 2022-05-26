<?php
/**
 * Template Header Info
 *
 * @return string
 * @var $header_info
 *
 */
?>
<div class="header-info">
    <div class="inner">
        <?php foreach ( $header_info as $item ) :
            $link = !empty( $item[ 'info_link' ] ) ? $item[ 'info_link' ] : '#';
            ?>
            <div class="item">
                <a class="link" href="<?php echo esc_attr( $link ); ?>">
                    <?php if ( !empty( $item[ 'info_icon' ] ) ): ?>
                        <span class="icon <?php echo esc_attr( $item[ 'info_icon' ] ); ?>"></span>
                    <?php endif; ?>
                    <span class="content">
                        <?php if ( !empty( $item[ 'info_title' ] ) ): ?>
                            <span class="title"><?php echo esc_html( $item[ 'info_title' ] ); ?></span>
                        <?php endif; ?>
                        <?php if ( !empty( $item[ 'info_subtitle' ] ) ): ?>
                            <span class="subtitle"><?php echo esc_html( $item[ 'info_subtitle' ] ); ?></span>
                        <?php endif; ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>