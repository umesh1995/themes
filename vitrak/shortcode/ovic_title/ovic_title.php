<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Title"
 * @version 1.0.0
 */
class Shortcode_Ovic_Title extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_title';
    public $default   = array(
        'style' => 'style-01',
        'title' => '',
    );

    public function content($atts, $content = null)
    {
        $css_class = $this->main_class($atts, array(
            'ovic-title',
            $atts['style'],
        ));
        if (empty($atts['title'])) {
            return '';
        }
        ob_start();
        ?>
        <div class="<?php echo esc_attr($css_class); ?>">
            <div class="inner">
                <span class="icon main-icon-leaf"></span>
                <h2 class="title"><?php echo esc_html($atts['title']); ?></h2>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}