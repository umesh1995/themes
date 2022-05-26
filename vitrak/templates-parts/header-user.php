<?php

/**
 * Template Account menu
 *
 * @return string
 * @var $text
 *
 */
?>
<?php
$account_link = wp_login_url();
$currentUser  = wp_get_current_user();
if (class_exists('WooCommerce')) {
    $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
}
$account_link = apply_filters('ovic_shortcode_vc_link', $account_link);
$title        = '<span class="highlight">' . esc_html__('Sign in', 'ecotech') . '</span><span>' . esc_html__(' or ', 'ecotech') . '</span>' . esc_html__('Register', 'ecotech');
if (!empty($text)) {
    $title = $text;
}
?>
<div class="block-userlink ecotech-dropdown">
    <?php if (is_user_logged_in()) : ?>
        <a data-ecotech="ecotech-dropdown" class="woo-user-link" href="<?php echo esc_url($account_link); ?>">
            <span class="text"><?php echo esc_html($currentUser->display_name); ?></span>
            <span class="icon main-icon-user-2"></span>
        </a>
        <?php if (function_exists('wc_get_account_menu_items')) : ?>
            <ul class="sub-menu">
                <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                    <li class="menu-item <?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                            <?php echo esc_html($label); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <ul class="sub-menu">
                <?php wp_register('<li class="menu-item">'); ?>
                <li class="menu-item"><?php wp_loginout(); ?></li>
                <li class="menu-item">
                    <a href="<?php echo esc_url(get_bloginfo('rss2_url')); ?>">
                        <?php
                        echo sprintf(
                            '%s <abbr title="Really Simple Syndication">%s</abbr>',
                            esc_html__('Entries', 'ecotech'),
                            esc_html__('RSS', 'ecotech')
                        );
                        ?>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo esc_url(get_bloginfo('comments_rss2_url')); ?>">
                        <?php
                        echo sprintf(
                            '%s <abbr title="Really Simple Syndication">%s</abbr>',
                            esc_html__('Comments', 'ecotech'),
                            esc_html__('RSS', 'ecotech')
                        );
                        ?>
                    </a>
                </li>
                <?php
                /**
                 * Filters the "Powered by WordPress" text in the Meta widget.
                 *
                 * @param string $title_text Default title text for the WordPress.org link.
                 * @param array $instance Array of settings for the current widget.
                 *
                 * @since 3.6.0
                 * @since 4.9.0 Added the `$instance` parameter.
                 *
                 */
                echo sprintf(
                    '<li class="menu-item"><a href="%s" title="%s">%s</a></li>',
                    esc_url('//wordpress.org/'),
                    esc_attr__('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'ecotech'),
                    esc_html_x('WordPress.org', 'meta widget link text', 'ecotech')
                );
                wp_meta();
                ?>
            </ul>
        <?php endif;
    else : ?>
        <a class="woo-user-link" href="<?php echo esc_url($account_link); ?>">
            <span class="icon main-icon-user-2"></span>
            <span class="text"><?php echo wp_specialchars_decode($title); ?></span>
        </a>
    <?php endif; ?>
</div>