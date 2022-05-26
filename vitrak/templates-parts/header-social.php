<?php
/**
 * Template Header Social
 *
 * @return string
 * @var $socials
 *
 */
?>
<div class="header-social">
    <div class="inner">
        <?php foreach ($socials as $social) : ?>
            <a href="<?php echo esc_url($social['link_social']) ?>">
                <span class="icon <?php echo esc_attr($social['icon_social']); ?>"></span>
                <span class="text"><?php echo esc_html($social['title_social']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>