<div class="post-inner">
    <?php ecotech_post_thumbnail(['width' => 450, 'height' => 295]); ?>
    <div class="post-date">
        <a href="<?php echo ecotech_post_link('date'); ?>">
            <span class="date"><?php echo get_the_date('d'); ?></span>
            <span class="month"><?php echo get_the_date('M'); ?></span>
        </a>
    </div>
    <div class="post-info">
        <?php
        ecotech_get_term_list();
        ecotech_post_title();
        ecotech_post_excerpt(16);
        ecotech_post_readmore(esc_html__('Continue Reading', 'ecotech'));
        ?>
    </div>
</div>