<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $scroll
 *
 */
$scroll = !empty($scroll) ? $scroll : 'vertical';
if (!empty($atts['nav_menu'])): ?>
    <div class="scroll-content tab-menu" data-scroll="<?php echo esc_attr($scroll); ?>"
         data-mobile="0">
        <?php
        wp_nav_menu(array(
            'menu'            => $atts['nav_menu'],
            'theme_location'  => $atts['nav_menu'],
            'depth'           => 1,
            'container'       => '',
            'container_class' => 'scroll-list',
            'container_id'    => '',
            'menu_class'      => '',
        ));
        ?>
        <a href="#" class="scroll-arrow scroll-prev">
            <?php esc_html_e('prev', 'ecotech') ?>
        </a>
        <a href="#" class="scroll-arrow scroll-next">
            <?php esc_html_e('next', 'ecotech') ?>
        </a>
    </div>
<?php endif;