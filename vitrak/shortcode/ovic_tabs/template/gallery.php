<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $tabs
 *
 */
$main_class = array('tab-banner left');

if (!empty($atts['hot_product'])) {
    $main_class[] = 'has-product';
}
$main_class = implode(' ', $main_class);

if (!empty($atts['banner_left']) || !empty($atts['hot_product'])): ?>
    <div class="<?php echo esc_attr($main_class); ?>">
        <?php
        if (!empty($atts['text_feature'])) {
            echo '<span class="text-feature"><span class="text">'.esc_html($atts['text_feature']).'</span></span>';
        }
        if (!empty($atts['hot_product'])):
            $product = wc_get_product($atts['hot_product']);
            if (!empty($atts['title_product'])) {
                echo '<h3 class="title-product"><span class="text">'.esc_html($atts['title_product']).'</span></h3>';
            }
            ?>
            <ul class="hot-product">

                <?php
                $post_object = get_post($atts['hot_product']);

                setup_postdata($GLOBALS['post'] =& $post_object);

                ecotech_woocommerce_setup_loop(array(
                    'width'  => 160,
                    'height' => 242,
                    'style'  => 'style-13',
                ));

                wc_get_template_part('content', 'product');

                wp_reset_postdata();
                wc_reset_loop();
                ?>

            </ul>
        <?php endif; ?>
        <?php if (!empty($atts['banner_left'])): ?>
            <?php
            $slick     = json_encode(array(
                'slidesToShow' => 1,
                'slidesMargin' => 0,
                'fade'         => true,
            ));
            $classes   = array('inner-content');
            $galleries = $atts['banner_left'];
            $link      = $tabs->add_link_attributes(
                array_merge($atts['left_link'], array(
                    'class' => $atts['css_effect']
                )), true
            );
            $count     = count($galleries);
            if ($count > 1) {
                $classes[] = 'owl-slick';
            }
            ?>
            <div class="<?php echo esc_attr(implode(' ', $classes)); ?>"
                 data-slick="<?php echo esc_attr($slick); ?>">
                <?php foreach ($galleries as $gallery) : ?>
                    <a <?php echo esc_attr($link); ?>>
                        <figure><?php echo wp_get_attachment_image($gallery['id'], 'full'); ?></figure>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php
endif;