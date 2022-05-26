<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $scroll
 *
 */
$bg_url = !empty($atts['bg_category']['id']) ? wp_get_attachment_image_url($atts['bg_category']['id'], 'full') : '';
$scroll = !empty($scroll) ? $scroll : 'vertical';
if (!empty($atts['category'])): ?>
    <div class="scroll-content tab-category" 
         style="background-image: url(<?php echo esc_url($bg_url); ?>);"
         data-scroll="<?php echo esc_attr($scroll); ?>"
         data-mobile="0">
        <div class="scroll-list">
            <?php
            echo wp_tag_cloud(array(
                'taxonomy' => 'product_cat',
                'include'  => $atts['category'],
                'format'   => 'flat',
                'unit'     => 'px',
                'smallest' => 14,
                'largest'  => 14,
                'echo'     => false,
            ));
            ?>
        </div>
        <a href="#" class="scroll-arrow scroll-prev">
            <?php esc_html_e('prev', 'ecotech') ?>
        </a>
        <a href="#" class="scroll-arrow scroll-next">
            <?php esc_html_e('next', 'ecotech') ?>
        </a>
    </div>
<?php endif;