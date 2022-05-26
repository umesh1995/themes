<div class="post-inner">
    <?php ecotech_post_thumbnail( [ 'width' => 90, 'height' => 56 ] ); ?>
    <div class="post-info">
        <?php ecotech_post_title(); ?>
        <div class="post-meta">
            <div class="meta-1">
                <?php
                ecotech_post_author( false, false,
                    esc_html__( 'by', 'ecotech' )
                );
                ?>
                <div class="post-date">
                    <span class="text"><?php echo esc_html__( 'on', 'ecotech' ); ?></span>
                    <a href="<?php echo ecotech_post_link( 'date' ); ?>">
                        <?php echo get_the_date(); ?>
                    </a>
                </div>
            </div>
            <div class="meta-2">
                <div class="post-comment">
                    <a href="<?php echo ecotech_post_link(); ?>#comments">
                        <span class="icon"></span>
                        <?php comments_number(
                            esc_html__( '0', 'ecotech' ),
                            esc_html__( '1', 'ecotech' ),
                            esc_html__( '%', 'ecotech' )
                        );
                        ?>
                    </a>
                </div>
                <div class="post-share ecotech-dropdown">
                    <a data-ecotech="ecotech-dropdown"
                       href="javascript:void(0)">
                        <span class="icon"></span>
                    </a>
                    <div class="sub-menu">
                        <?php ecotech_post_share(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>