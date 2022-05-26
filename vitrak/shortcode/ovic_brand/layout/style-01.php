<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $ovic_brand
 *
 */

if (!empty($atts['title'])) {
    echo ovic_do_shortcode('ovic_title', array(
        'title' => $atts['title'],
        'style' => 'style-01',
    ));
}
if (!empty($atts['brands'])) {

    $brands = is_array($atts['brands']) ? $atts['brands'] : explode(',', $atts['brands']);
    if (isset($atts['is_editor'])) {
        $slick = json_encode(array(
            'slidesToShow'  => (int) $atts['slide_item'],
            'infinite'      => true,
            'variableWidth' => true,
        ));

        echo '<div class="owl-slick" data-slick="'.esc_attr($slick).'">';
    } else {
        $slick = $ovic_brand->generate_carousel($atts);

        echo '<div class="owl-slick" '.esc_attr($slick).'>';
    }

    foreach ($brands as $brand) {
        $term = get_term_by('slug', $brand, 'product_brand');
        if (!is_wp_error($term) && !empty($term)) {
            $term_link    = get_term_link($term->term_id, 'product_brand');
            $thumbnail_id = get_term_meta($term->term_id, 'logo_id', true);
            ?>
            <div class="brand-item">
                <a href="<?php echo esc_url($term_link); ?>"
                   class="link <?php echo esc_attr($atts['image_effect']); ?>">
                    <figure class="thumb"><?php echo wp_get_attachment_image($thumbnail_id, 'full'); ?></figure>
                </a>
            </div>
            <?php
        }
    }

    echo '</div>';

}