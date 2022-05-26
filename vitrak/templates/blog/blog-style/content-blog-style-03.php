<?php
$page_layout = ecotech_page_layout();
$container   = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'main_container',
    'metabox_main_container',
    '1410'
);
?>
<div class="post-inner">
    <?php
    if ($page_layout['layout'] != 'full') {
        ecotech_post_thumbnail(['effect' => '', 'width' => ($container - 390), 'height' => 450]);
    } else {
        ecotech_post_thumbnail(['effect' => '', 'width' => $container, 'height' => 450]);
    }
    ?>
    <div class="post-info">
        <div class="post-meta">
            <div class="post-date">
                <a href="<?php echo ecotech_post_link('date'); ?>">
                    <?php echo get_the_date(); ?>
                </a>
            </div>
            <?php ecotech_get_term_list(); ?>
        </div>
        <?php
        ecotech_post_title();
        ecotech_post_readmore();
        ?>
    </div>
</div>