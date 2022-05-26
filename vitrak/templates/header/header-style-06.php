<?php
/**
 * Name:  Header style 06
 **/
?>
<?php
$header_topmenu   = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_topmenu',
    "metabox_header_topmenu"
);
$header_topmenu_2 = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_topmenu_2',
    "metabox_header_topmenu_2"
);
$header_message   = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_message',
    "metabox_header_message"
);
?>
<header id="header" class="header style-06">
    <div class="header-mid header-sticky">
        <div class="container">
            <div class="header-inner megamenu-wrap">
                <?php ecotech_get_logo(); ?>
                <div class="box-header-nav">
                    <?php ecotech_primary_menu(); ?>
                </div>
                <div class="header-control">
                    <div class="inner-control">
                        <?php ecotech_header_menu_bar(); ?>
                        <?php ecotech_header_search_popup(); ?>
                        <?php ecotech_header_user(); ?>
                        <?php if ( function_exists( 'ecotech_header_mini_cart' ) ) ecotech_header_mini_cart( 'popup' ); ?>
                        <?php if ( !empty( $header_topmenu ) || !empty( $header_topmenu_2 ) || !empty( $header_message ) ) : ?>
                            <div class="header-setting ecotech-dropdown">
                                <a data-ecotech="ecotech-dropdown" class="setting-link" href="#">
                                    <span class="icon main-icon-settings"></span>
                                    <span class="text">Settings</span>
                                </a>
                                <div class="sub-menu">
                                    <?php ecotech_header_message(); ?>
                                    <?php ecotech_header_submenu( 'header_topmenu', 1 ); ?>
                                    <?php ecotech_header_submenu( 'header_topmenu_2', 1 ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if ( function_exists( 'ecotech_header_mini_cart_popup' ) ) ecotech_header_mini_cart_popup(); ?>
