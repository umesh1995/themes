<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Blog"
 * @version 1.0.0
 */
class Shortcode_Ovic_Blog extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_blog';
    public $default   = array(
        'style'             => 'style-01',
        'list_style'        => 'owl',
        'slides_rows_space' => '',
        'image_full_size'   => '',
        'limit'             => '6',
        'orderby'           => '',
        'order'             => '',
        'target'            => 'recent_post',
    );

    public function content($atts, $content = null)
    {
        $i            = 0;
        $owl_settings = '';
        $item_class   = array('blog-item', $atts['style']);
        $list_class   = array('content-post equal-container better-height', $atts['slides_rows_space']);
        $css_class    = $this->main_class($atts, array(
            'ovic-blog',
            $atts['style']
        ));
        if (!empty($atts['title'])) {
            if ($atts['style'] == 'style-01' || $atts['style'] == 'style-02') {
                $css_class .= ' arrows-02 arrows-top';
            }
        }

        if ($atts['list_style'] == 'grid') {
            $list_class[] = 'product-list-grid row';
            $item_class[] = $this->generate_boostrap($atts);
        }

        if (!empty($atts['slides_to_show']) && $atts['list_style'] == 'owl') {
            $list_class[] = 'product-list-owl owl-slick';
            $owl_settings = $this->generate_carousel($atts);
        }
        if (!empty($atts['carousel']) && $atts['list_style'] == 'owl') {
            $list_class[] = 'post-list-owl owl-slick';
            $owl_settings = htmlspecialchars(' data-slick='.json_encode($atts['carousel']).' ');
        }

        $query = new WP_Query(ecotech_shortcode_posts_query($atts));

        if ($atts['image_full_size'] == 'yes') {
            add_filter('ecotech_post_thumbnail_width', function () {
                return false;
            });
            add_filter('ecotech_post_thumbnail_height', function () {
                return false;
            });
        }

        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <?php
            if (!empty($atts['title'])) {
                echo '<div class="head"><h3 class="title">'.esc_html($atts['title']).'</h3></div>';
            }
            ?>
            <?php if ($query->have_posts()) : ?>
                <div class="<?php echo esc_attr(implode(' ', $list_class)); ?>" <?php echo esc_attr($owl_settings); ?>>
                    <?php while ($query->have_posts()) :
                        $query->the_post();
                        $format    = 'format-standard';
                        $post_meta = get_post_meta(get_the_ID(), '_custom_metabox_post_options', true);
                        if (!empty($post_meta['type'])) {
                            $format = 'format-'.$post_meta['type'];
                        }
                        $item_class[] = $format;
                        $i++;
                        ?>
                        <article <?php post_class($item_class); ?>>
                            <?php
                            $this->get_template("layout/{$atts['style']}.php",
                                array(
                                    'atts'  => $atts,
                                    'count' => $i,
                                )
                            );
                            ?>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}