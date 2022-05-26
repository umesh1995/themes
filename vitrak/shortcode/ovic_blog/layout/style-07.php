<div class="post-inner">
    <?php ecotech_post_title(); ?>
    <div class="post-meta">
        <div class="post-date">
            <a href="<?php echo ecotech_post_link( 'date' ); ?>">
                <span class="icon"></span>
                <?php echo get_the_date('F d, Y'); ?>
            </a>
        </div>
        <?php ecotech_post_author( true ); ?>
    </div>
</div>