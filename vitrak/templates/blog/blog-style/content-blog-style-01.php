<?php
$metabox     = get_post_meta(get_the_ID(), '_custom_metabox_post_options', true);
$blog_style  = ecotech_get_option('blog_list_style', 'standard');
$page_layout = ecotech_page_layout();
$container   = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'main_container',
    'metabox_main_container',
    '1410'
);
$placeholder = false;
$width       = false;
$height      = false;
if ($blog_style == 'grid') {
    $placeholder = true;
    if ($page_layout['layout'] != 'full') {
        $width = ($container - 448 - (30 * 2)) / 3;
    } else {
        $width = ($container - (30 * 3)) / 4;
    }
    $height = 300;
}
if ($blog_style == 'creative') {
    $placeholder = true;
    if ($page_layout['layout'] != 'full') {
        $width = ($container - 448 - (72 * 1)) / 2;
    } else {
        $width = ($container - (72 * 2)) / 3;
    }
    if (!empty($metabox['size-creative'])) {
        if ($metabox['size-creative'] == 'size-01') {
            $height = 280;
        }
        if ($metabox['size-creative'] == 'size-02') {
            $height = 422;
        }
        if ($metabox['size-creative'] == 'size-03') {
            $height = 566;
        }
    } else {
        $rand   = array(280, 422, 566);
        $key    = array_rand($rand, 1);
        $height = $rand[$key];
    }
}
?>
<div class="post-inner">
    <?php ecotech_post_thumbnail(['placeholder' => $placeholder, 'width' => $width, 'height' => $height]); ?>
    <div class="post-info">
        <?php
        ecotech_get_term_list();
        ecotech_post_title();
        ?>
        <div class="post-meta">
            <div class="post-date">
                <a href="<?php echo ecotech_post_link('date'); ?>">
                    <span class="icon"></span>
                    <?php echo get_the_date(); ?>
                </a>
            </div>
            <?php ecotech_post_author(); ?>
        </div>
        <?php
        if ($blog_style == 'standard') {
            ecotech_post_excerpt();
        }
        if ($blog_style != 'creative') {
            ecotech_post_readmore();
        }
        ?>
    </div>
</div>