<?php
/**
 * Template Mobile Footer
 *
 * @return string
 * @var $data_menus
 *
 * @var $menu_locations
 */
$textarea = ecotech_theme_option_meta(
    '_custom_metabox_theme_options',
    'header_textarea',
    'metabox_header_textarea'
);
if (!empty($textarea)) : ?>
    <div class="footer-menu-mobile">
        <div class="header-text">
            <p><?php echo preg_replace('/<\/?p\>/', "\n", $textarea); ?></p>
        </div>
    </div>
<?php endif;