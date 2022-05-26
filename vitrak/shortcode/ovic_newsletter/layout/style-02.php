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
        <label class="text-field field-email">
            <input class="input-text email-newsletter" type="email" name="EMAIL"
                   required="required"
                   placeholder="<?php echo esc_html( $atts['placeholder'] ); ?>">
            <span class="input-focus"></span>
        </label>
        <button type="submit" class="submit-newsletter" value="">
            <span class="icon fa fa-paper-plane-o"></span>
        </button>
        <?php
        $html = ob_get_clean();
        $newsletter->newsletter_form( $html, $form_id );
        ?>
    </div>
</div>