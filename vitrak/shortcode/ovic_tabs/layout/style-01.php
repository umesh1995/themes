<?php
/**
 * Template shortcode
 *
 * @return string
 * @var $atts
 * @var $tabs
 * @var $is_ajax
 * @var $sections
 *
 */
?>
<div class="tabs-container">
    <?php if (!empty($sections)): ?>
        <?php
        $count = 1;
        foreach ($sections as $id => $section) : ?>
            <?php
            $active = array('tab-panel');
            if ($count == $atts['active']) {
                $active[] = 'active';
            }
            ?>
            <div class="<?php echo esc_attr(implode(' ', $active)); ?>"
                 id="tab-<?php echo esc_attr($id); ?>">
                <?php if ($is_ajax == true) :
                    if ($count == $atts['active']) :
                        $tabs->tab_content($section);
                    endif;
                else :
                    $tabs->tab_content($section);
                endif;
                $count++;
                ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>