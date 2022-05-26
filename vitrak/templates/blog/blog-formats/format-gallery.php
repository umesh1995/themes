<?php
/**
 * Template Format Gallery
 *
 * @param $data
 *
 * @return string
 */
?>
<?php
$data_slick = array(
    'infinite'      => true,
    'fade'          => false,
    'autoplay'      => true,
    'autoplaySpeed' => 1500,
    'speed'         => 1000,
    'arrows'        => false,
    'dots'          => true,
    'slidesToShow'  => 1,
    'slidesMargin'  => 0,
);
$galleries  = !empty($data) ? explode(',', $data) : array();
?>
<?php if (!empty($galleries)): ?>
    <div class="post-thumb gallery owl-slick" data-slick="<?php echo esc_attr(wp_json_encode($data_slick)); ?>">
        <?php foreach ($galleries as $gallery): ?>
            <figure>
                <?php echo wp_get_attachment_image($gallery, 'full'); ?>
            </figure>
        <?php endforeach; ?>
    </div>
<?php endif; ?>