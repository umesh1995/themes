<?php
/**
 * Name:  Header style 07
 **/
?>
<header id="header" class="header style-07">
    <div class="header-top has-start has-end header-sticky">
        <div class="container">
            <div class="header-inner megamenu-wrap">
                <div class="header-box header-start">
                    <div class="box-header-nav">
                        <?php ecotech_primary_menu(); ?>
                        <?php ecotech_header_menu_bar(); ?>
                    </div>
                </div>
                <div class="header-box header-end">
                    <?php ecotech_header_user(); ?>
                    <?php ecotech_header_submenu( 'header_topmenu' ); ?>
                    <?php ecotech_header_submenu( 'header_topmenu_2' ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="header-mid">
        <div class="container">
            <div class="header-inner">
                <?php ecotech_get_logo(); ?>
                <?php ecotech_header_search( false ); ?>
                <div class="header-control">
                    <div class="inner-control">
                        <?php if ( function_exists( 'ecotech_header_wishlist' ) ) ecotech_header_wishlist(); ?>
                        <?php if ( function_exists( 'ecotech_header_mini_cart' ) ) ecotech_header_mini_cart( 'popup' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if ( function_exists( 'ecotech_header_mini_cart_popup' ) ) ecotech_header_mini_cart_popup(); ?>
