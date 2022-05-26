<?php
/**
 * Name:  Mobile style 02
 *
 * @var $account_link
 * @var $logo_link
 * @var $page_layout
 * @var $page_template
 **/
?>
<div class="main">
    <div class="container">
        <div class="inner">
            <?php ecotech_get_logo(); ?>
            <div class="control">
                <a class="woo-user-link" href="<?php echo esc_url( $account_link ); ?>">
                    <span class="icon main-icon-user-2"></span>
                </a>
                <?php if ( function_exists( 'ecotech_header_wishlist' ) ) ecotech_header_wishlist(); ?>
                <?php if ( function_exists( 'ecotech_header_cart_link' ) ) ecotech_header_cart_link(); ?>
            </div>
        </div>
        <?php ecotech_header_search( false ); ?>
    </div>
</div>
<div class="fixed ecotech-dropdown">
    <div class="inner">
        <?php $vertical_menu = ecotech_theme_option_meta( '_custom_metabox_theme_options', 'vertical_menu' ); ?>
        <?php if ( !empty( $vertical_menu ) ) : ?>
            <a href="javascript:void(0)" class="menu-bar menu-toggle" data-index="2">
                <span class="icon main-icon-menu-2"></span>
                <span class="text"><?php echo esc_html__( 'Category', 'ecotech' ); ?></span>
            </a>
        <?php else : ?>
            <a href="<?php echo esc_url( $logo_link ); ?>" class="home-page">
                <span class="icon main-icon-home"></span>
                <span class="text"><?php echo esc_html__( 'Home', 'ecotech' ); ?></span>
            </a>
        <?php endif; ?>
        <a href="javascript:void(0)" class="menu-bar menu-toggle" data-index="1">
            <span class="icon main-icon-menu"></span>
        </a>
        <?php if ( $page_layout['layout'] != 'full' && $page_template == '' ) : ?>
            <a href="javascript:void(0)" class="open-sidebar">
                <span class="icon main-icon-sidebar"></span>
            </a>
        <?php elseif ( class_exists( 'WeDevs_Dokan' ) && dokan_is_store_page() ) : ?>
            <a href="javascript:void(0)" class="open-sidebar">
                <span class="icon main-icon-sidebar"></span>
            </a>
        <?php else: ?>
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a class="woo-cart-link icon-link" href="<?php echo wc_get_cart_url(); ?>">
                    <span class="icon main-icon-cart"></span>
                </a>
            <?php endif; ?>
        <?php endif; ?>
        <a href="javascript:void(0)" class="action-to-top">
            <span class="icon main-icon-back-2"></span>
        </a>
    </div>
    <a href="javascript:void(0)" class="mobile-toggle" data-ecotech="ecotech-dropdown">
        <span class="icon main-icon-close"></span>
    </a>
</div>
