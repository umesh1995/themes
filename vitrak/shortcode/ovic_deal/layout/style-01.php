<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 *
 */
?>
<?php
if (!empty($atts['title'])) {
    echo ovic_do_shortcode('ovic_title',
        array('title' => $atts['title'])
    );
}

unset($atts['title']);

$args = array(
    'list_style' => 'owl'
);
$args = array_merge($args, $atts);

echo ovic_do_shortcode('ovic_products', $args);
?>
