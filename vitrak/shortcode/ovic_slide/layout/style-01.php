<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $link
 * @var $owl_settings
 *
 */
?>
<?php if (!empty($atts['gallery'])): ?>
    <div class="owl-slick" <?php echo esc_attr($owl_settings); ?>>
        <?php foreach ($atts['gallery'] as $gallery) : ?>
            <div class="item">
                <a class="link" <?php echo esc_attr($link); ?>>
                    <figure class="thumb">
                        <img src="<?php echo esc_url($gallery['url']); ?>"
                             alt="<?php echo esc_attr($gallery['id']); ?>">
                    </figure>
                    <span class="content">
                        <?php if (!empty($atts['subtitle'])) : ?>
                            <span class="subtitle"><?php echo wp_specialchars_decode($atts['subtitle']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($atts['title'])) : ?>
                            <span class="title"><?php echo wp_specialchars_decode($atts['title']); ?></span>
                        <?php endif; ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
