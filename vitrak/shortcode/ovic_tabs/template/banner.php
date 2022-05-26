<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $tabs
 *
 */
if ( ! empty($atts['banner_top']['id'])):
    $link = $tabs->add_link_attributes(
        array_merge($atts['top_link'], array(
            'class' => $atts['css_effect']
        )), true
    ); ?>
    <div class="tab-banner top">
        <a <?php echo esc_attr($link); ?>>
            <figure><?php echo wp_get_attachment_image($atts['banner_top']['id'], 'full'); ?></figure>
        </a>
    </div>
<?php endif;