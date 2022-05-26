<?php

/**
 * Name:  Header style 09
 **/
?>
<?php
$header_top     = 'header-top has-start has-end';
$header_message = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_message',
    "metabox_header_message"
);
if (!empty($header_message)) $header_top .= ' has-center';
?>
<header id="header" class="header style-09 style-04">
    <div class="<?php echo esc_attr($header_top); ?>">
        <div class="container">
            <div class="header-inner">
                <div class="header-box header-start">
                    <?php ecotech_header_social(); ?>
                    <?php ecotech_header_submenu('header_topmenu'); ?>
                </div>
                <?php ecotech_header_message(); ?>
                <div class="header-box header-end">
                    <?php ecotech_header_submenu('header_topmenu_2'); ?>
                </div>
            </div>
        </div>
    </div>
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
                        <?php if (is_user_logged_in()) : ?>
                            <?php //if (function_exists('ecotech_header_wishlist')) ecotech_header_wishlist(); 
                            ?>
                            <?php if (function_exists('ecotech_header_mini_cart')) ecotech_header_mini_cart('popup'); ?>
                        <?php endif; ?>
                        <?php ecotech_header_user(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if (function_exists('ecotech_header_mini_cart_popup')) ecotech_header_mini_cart_popup(); ?>