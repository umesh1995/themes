<div class="post-inner">
    <?php ecotech_post_thumbnail( [ 'width' => 436, 'height' => 280 ] ); ?>
    <div class="post-info">
        <div class="post-date">
            <a href="<?php echo ecotech_post_link( 'date' ); ?>">
                <span class="date"><?php echo get_the_date( 'd' ); ?></span>
                <span class="month"><?php echo get_the_date( 'M' ); ?></span>
            </a>
        </div>
        <?php ecotech_post_title(); ?>
        <div class="post-meta">
            <?php
            ecotech_post_author( true, false, esc_html__( 'By:', 'ecotech' ) );
            ecotech_post_comment();
            ?>
        </div>
    </div>
</div>