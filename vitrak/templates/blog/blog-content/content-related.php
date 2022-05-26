<?php
/**
 * Name: Blog Related
 **/
$page_layout = ecotech_page_layout();
$item        = 1;
if ( $page_layout[ 'layout' ] == 'full' )
    $item = 2;
$args = apply_filters( 'ecotech_latest_post_args', array(
    'style'    => 'style-03',
    'title'    => esc_html__( 'Related Posts', 'ecotech' ),
    'target'   => 'related',
    'orderby'  => 'rand',
    'limit'    => '6',
    'order'    => '',
    'carousel' => array(
        'slidesToShow'  => 2,
        'slidesMargin'  => 30,
        'arrows'        => true,
        'speed'         => 800,
        'autoplay'      => true,
        'autoplaySpeed' => 3000,
        'infinite'      => true,
        'responsive'    => array(
            array(
                'breakpoint' => 1200,
                'settings'   => array(
                    'slidesToShow' => $item,
                ),
            ),
            array(
                'breakpoint' => 991,
                'settings'   => array(
                    'slidesToShow' => 1,
                ),
            ),
        ),
    ),
) );
echo '<div class="blog-related"><div class="container">';
echo ecotech_do_shortcode( 'ovic_blog', $args );
echo '</div></div>';