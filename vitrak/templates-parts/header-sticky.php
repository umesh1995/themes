<div id="header-sticky" class="header-sticky">
    <div class="container">
        <div class="header-inner megamenu-wrap">
            <?php ecotech_header_vertical(); ?>
            <div class="wrap-header-nav">
                <div class="box-header-nav">
                    <?php ecotech_primary_menu(); ?>
                </div>
                <div class="header-control">
                    <div class="inner-control">
                        <?php if ( function_exists( 'ecotech_header_mini_cart' ) ) ecotech_header_mini_cart( 'popup' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>