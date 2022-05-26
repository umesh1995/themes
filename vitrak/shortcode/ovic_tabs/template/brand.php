<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 *
 */
if (!empty($atts['brand'])): ?>
    <div class="tab-brand">
        <div class="scroll-content" data-scroll="vertical"
             data-mobile="true">
            <div class="scroll-list">
                <?php foreach ($atts['brand'] as $brand): ?>
                    <?php
                    $term             = get_term_by('slug', $brand, 'product_brand');
                    if (!is_wp_error($term) && !empty($term)):
                        $term_link = get_term_link($term->term_id, 'product_brand');
                        $thumbnail_id = get_term_meta($term->term_id, 'logo_id', true);
                        ?>
                        <a href="<?php echo esc_url($term_link); ?>" class="effect bounce-in">
                            <figure><?php echo wp_get_attachment_image($thumbnail_id, 'full'); ?></figure>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <a href="#" class="scroll-arrow scroll-prev">prev</a>
            <a href="#" class="scroll-arrow scroll-next">next</a>
        </div>
    </div>
<?php endif;