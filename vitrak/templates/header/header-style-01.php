<?php
/**
 * Name:  Header style 01
 **/
?>
<?php
$header_top     = 'header-top';
$header_topmenu = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_topmenu',
    "metabox_header_topmenu"
);
if ( !empty( $header_topmenu ) ) $header_top .= ' has-start';
$header_topmenu_2 = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_topmenu_2',
    "metabox_header_topmenu_2"
);
if ( !empty( $header_topmenu_2 ) ) $header_top .= ' has-end';
$header_message = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_message',
    "metabox_header_message"
);
if ( !empty( $header_message ) ) $header_top .= ' has-center';
?>
<header id="header" class="header style-01">
    <div class="<?php echo esc_attr( $header_top ); ?>">
        <div class="container">
            <div class="header-inner">
                <div class="header-box header-start">
                    <?php ecotech_header_submenu( 'header_topmenu' ); ?>
                </div>
                <?php ecotech_header_message(); ?>
                <div class="header-box header-end">
                    <?php ecotech_header_submenu( 'header_topmenu_2' ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="header-mid">
        <div class="container">
            <div class="header-inner">
                <?php ecotech_get_logo(); ?>
                <div class="header-control">
                    <?php ecotech_header_search(); ?>
                    <?php ecotech_header_info(); ?>
                    <div class="inner-control">
                        <?php ecotech_header_user(); ?>
                        <?php if ( function_exists( 'ecotech_header_wishlist' ) ) ecotech_header_wishlist(); ?>
                        <?php if ( function_exists( 'ecotech_header_mini_cart' ) ) ecotech_header_mini_cart( 'popup' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bot header-sticky">
        <div class="container">
            <div class="header-inner megamenu-wrap">
                <?php ecotech_header_vertical(); ?>
                <div class="box-header-nav">
                    <?php ecotech_primary_menu(); ?>
                    <?php ecotech_header_menu_bar(); ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if ( function_exists( 'ecotech_header_mini_cart_popup' ) ) ecotech_header_mini_cart_popup(); ?>
