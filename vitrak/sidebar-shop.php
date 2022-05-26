<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Ecotech
 * @since 1.0
 * @version 1.0
 */

$page_layout = ecotech_page_layout();
?>
<?php if ($page_layout['layout'] != 'full') : ?>
    <aside id="secondary" class="widget-area" role="complementary"
           aria-label="<?php esc_attr_e('Shop Sidebar', 'ecotech'); ?>">
        <?php dynamic_sidebar($page_layout['sidebar']); ?>
    </aside><!-- #secondary -->
<?php endif; ?>
<?php
if (function_exists('is_product') && is_product()) {
    woocommerce_upsell_display();
    woocommerce_output_related_products();
}
?>
</div><!-- .site-content-contain -->
