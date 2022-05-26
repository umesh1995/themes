<?php
/**
 * Template Newsletter
 *
 * @return string
 *
 * @var $atts
 * @var $form_id
 * @var $newsletter
 */
?>
<div class="inner">
    <div class="content">
        <?php ob_start(); ?>
        <div class="field-email">
            <span class="text"><?php echo esc_html__('Email Address *', 'ecotech'); ?></span>
            <label class="text-field">
                <input class="input-text email-newsletter" type="email" name="EMAIL"
                       required="required"
                       placeholder="<?php echo esc_html($atts['placeholder']); ?>">
                <span class="input-focus"></span>
            </label>
        </div>
        <div class="field-birthday">
            <span class="text"><?php echo esc_html__('Birthday *', 'ecotech'); ?></span>
            <label class="text-field">
                <input class="input-text" type="date" name="BIRTHDAY"
                       required="required">
                <span class="input-focus"></span>
            </label>
        </div>
        <button type="submit" class="submit-newsletter" value="">
            <?php if (!empty($atts['button'])) : ?>
                <?php echo esc_html($atts['button']); ?>
            <?php endif; ?>
        </button>
        <?php
        $html = ob_get_clean();
        $newsletter->newsletter_form($html, $form_id);
        ?>
    </div>
</div>