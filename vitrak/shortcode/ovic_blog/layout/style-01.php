<div class="post-inner">
    <?php ecotech_post_thumbnail(['width' => 80, 'height' => 54]); ?>
    <div class="post-info">
        <?php ecotech_post_title(); ?>
        <div class="post-date">
            <a href="<?php echo ecotech_post_link('date'); ?>">
                <span class="icon"></span>
                <?php echo get_the_date('F d, Y'); ?>
            </a>
        </div>
    </div>
</div>