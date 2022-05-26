<?php
/**
 * Template Form
 *
 * @return string
 *
 * @var $product_id
 */
$product_id    = absint($product_id);
$product_image = ecotech_resize_image(get_post_thumbnail_id($product_id), 355, 460, true, false);
$image_captcha = get_theme_file_uri('framework/captcha/v1/image.php');
?>
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div id="form-send-friend" class="form-send-friend">
            <h2 class="title"><?php esc_html_e('SEND TO A FRIEND', 'ecotech'); ?></h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="product-info">
                        <div class="prodcut-image">
                            <?php echo wp_kses_post($product_image['img']); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="form-send-friend-msg"></div>
                    <div class="form">
                        <p>
                            <label for="friend_name"><?php esc_html_e('Name of your friend * :',
                                    'ecotech'); ?></label>
                            <input class="text-input" id="friend_name" name="friend_name" type="text"
                                   value="">
                        </p>
                        <p class="text">
                            <label for="friend_email"><?php esc_html_e('E-mail address of your friend * :',
                                    'ecotech') ?></label>
                            <input class="text-input" id="friend_email" name="friend_email" type="email"
                                   value="" autocomplete="email">
                        </p>
                        <p>
                            <img src="<?php echo esc_url($image_captcha); ?>" loading="lazy" id="img-captcha"
                                 alt="captcha"/>
                            <input id="captcha_reload" type="button" value="Reload"
                                   onclick="jQuery('#img-captcha').attr('src', '<?php echo esc_url($image_captcha); ?>?rand=' + Math.random())"/>
                            <br/>
                        </p>
                        <p>
                            <label for="captcha_code">
                                <input type="text" class="captcha_code" id="captcha_code" value=""/>
                            </label>
                        </p>
                        <p>
                            <button data-product_id="<?php echo esc_attr($product_id); ?>"
                                    id="button-send-to-friend"
                                    class="button">
                                <?php esc_html_e('Send', 'ecotech'); ?>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close" data-dismiss="modal">x</button>
    </div>
</div>