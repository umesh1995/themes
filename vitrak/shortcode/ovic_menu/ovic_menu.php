<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Menu"
 * @version 1.0.0
 */
class Shortcode_Ovic_Menu extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_menu';
    public $default   = array(
        'style'         => 'default',
        'title'         => '',
        'toggle_mobile' => '',
        'visible_item'  => 10,
    );

    public function content( $atts, $content = null )
    {
        $toggle   = '';
        $menu_id  = 0;
        $tab_id   = uniqid( 'ovic-custommenu-' );
        $menu_obj = get_term_by( 'slug', $atts[ 'nav_menu' ], 'nav_menu' );
        if ( !empty( $menu_obj ) && !is_wp_error( $menu_obj ) ) {
            $menu_id = $menu_obj->term_id;
        }
        $atts[ 'nav_menu' ] = $menu_id;
        $classes            = array(
            'ovic-custommenu',
            'wpb_content_element',
            'vc_wp_custommenu',
            $atts[ 'style' ],
            $tab_id,
        );
        if ( $atts[ 'toggle_mobile' ] == 'yes' ) {
            $toggle    = 'data-ecotech=ecotech-dropdown';
            $classes[] = 'ecotech-dropdown';
            $classes[] = 'toggle-mobile';
        }
        $css_class = $this->main_class( $atts, $classes );

        ob_start();
        ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <?php
            if ( $atts[ 'style' ] != 'style-02' && class_exists( 'WP_Nav_Menu_Widget' ) ) {
                $args = array(
                    'before_title' => '<h2 class="widget-title" ' . esc_attr( $toggle ) . '><span>',
                    'after_title'  => '</span><span class="arrow"></span></h2>',
                );
                the_widget( 'WP_Nav_Menu_Widget', $atts, $args );
                $atts[ 'link' ][ 'url' ] = apply_filters( 'ovic_shortcode_vc_link', $atts[ 'link' ][ 'url' ] );
                $link                    = $this->add_link_attributes( $atts[ 'link' ], true );
                if ( !empty( $atts[ 'link' ][ 'url' ] ) ) : ?>
                    <div class="button-wrap">
                        <a <?php echo esc_attr( $link ); ?> class="link"><?php echo esc_html__( 'View All', 'ecotech' ); ?></a>
                    </div>
                <?php endif;
            }
            if ( $atts[ 'style' ] == 'style-02' ) {
                $items = $atts[ 'visible_item' ] + 1;

                wp_register_style( $this->enqueue_name(), false );
                wp_enqueue_style( $this->enqueue_name() );

                wp_add_inline_style( $this->enqueue_name(),
                    ".{$tab_id} .vertical-menu > .menu-item:nth-child(n+{$items}){display: none;}"
                );
                ecotech_get_template(
                    "templates-parts/header-vertical.php",
                    array(
                        'vertical_menu'  => $atts[ 'nav_menu' ],
                        'always_open'    => true,
                        'vertical_title' => $atts[ 'title' ],
                        'visible_item'   => $atts[ 'visible_item' ],
                        'all_text'       => $atts[ 'all_text' ],
                        'close_text'     => $atts[ 'close_text' ],
                    )
                );
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}