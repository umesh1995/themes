<div class="post-inner">
    <?php ecotech_post_thumbnail( [ 'placeholder' => true, 'width' => 480, 'height' => 310 ] ); ?>
    <div class="post-info">
        <div class="post-meta">
            <div class="post-date">
                <a href="<?php echo ecotech_post_link( 'date' ); ?>">
                    <?php echo get_the_date(); ?>
                </a>
            </div>
            <?php ecotech_get_term_list(); ?>
        </div>
        <?php
        ecotech_post_title();
        ecotech_post_excerpt( 14 );
        ecotech_post_readmore();
        ?>
    </div>
</div>