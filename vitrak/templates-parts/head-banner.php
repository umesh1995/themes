<?php
$head_banner = ecotech_get_option( 'head_banner' );
if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
    $shop_banner = ecotech_get_option( 'shop_banner' );
    if ( !empty( $shop_banner ) ) $head_banner = $shop_banner;
}
if ( is_page() ) {
    $page_banner = ecotech_theme_option_meta( '_custom_page_side_options', null, 'page_banner' );
    if ( !empty( $page_banner ) ) $head_banner = $page_banner;
}
$banner     = !empty( $head_banner ) ? wp_get_attachment_image_url( $head_banner, 'full' ) : '';
$post_title = ecotech_get_option( 'post_page_title', esc_html__( 'Post Details', 'ecotech' ) );
?>
<div class="head-banner" style="background-image: url(<?php echo esc_attr( $banner ); ?>);">
    <div class="container">
        <div class="inner">
            <?php
            if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
                $shop_title    = ecotech_get_option( 'shop_page_title', esc_html__( 'Shop Products', 'ecotech' ) );
                if ( !is_product() && $shop_title != '' ) {
                    echo '<h2 class="page-title">' . esc_html( $shop_title ) . '</h2>';
                }
                if ( is_product() ) {
                    echo '';
                }
            } elseif ( is_single() ) {
                echo '';
            } else {
                ecotech_page_title();
            }
            ?>
            <?php ecotech_breadcrumb(); ?>
        </div>
    </div>
</div>