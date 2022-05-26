<div class="post-inner">
    <?php ecotech_post_thumbnail(['width' => 90, 'height' => 60]); ?>
    <div class="post-info">
        <?php ecotech_post_title(); ?>
        <div class="post-date">
            <a href="<?php echo ecotech_post_link('date'); ?>">
                <?php echo get_the_date('F d, Y'); ?>
            </a>
        </div>
    </div>
</div>