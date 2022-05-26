<?php
/**
 * Template Vertical Menu
 *
 * @return string
 * @var $vertical_menu
 * @var $always_open
 * @var $vertical_title
 * @var $visible_item
 * @var $all_text
 * @var $close_text
 *
 */
?>
<?php
global $post;

$id = 0;

$classes = array(
    'box-nav-vertical',
    'ecotech-dropdown',
);

if ( !empty( $post->ID ) ) {
    $id = $post->ID;
}
if ( !empty($always_open) && is_page() && is_array( $always_open ) && in_array( $id, $always_open ) ) {
    $classes[] = 'always-open';
}
$menu  = wp_get_nav_menu_object( $vertical_menu );
$count = ( $menu instanceof \WP_Term ) ? $menu->count : 0;
?>
<div class="header-vertical">
    <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <a href="#" class="block-title main-bg" data-ecotech="ecotech-dropdown">
            <span class="icon main-icon-menu"></span>
            <span class="text"><?php echo esc_html( $vertical_title ); ?></span>
        </a>
        <div class="block-content sub-menu">
            <?php
            wp_nav_menu(
                array(
                    'menu'            => $vertical_menu,
                    'theme_location'  => $vertical_menu,
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'after'           => '<span class="carets"></span>',
                    'menu_class'      => 'ecotech-nav vertical-menu',
                    'megamenu_layout' => 'vertical',
                )
            );
            ?>
            <?php if ( $count > $visible_item ) : ?>
                <div class="view-all-menu">
                    <a href="javascript:void(0);"
                       data-items="<?php echo esc_attr( $visible_item ); ?>"
                       data-closetext="<?php echo esc_attr( $close_text ); ?>"
                       data-alltext="<?php echo esc_attr( $all_text ) ?>"
                       class="btn-view-all open-menu"><?php echo esc_html( $all_text ) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>