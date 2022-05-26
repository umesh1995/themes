<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * ADD CLASS NAV
 **/
add_filter('navigation_markup_template',
    function ($template, $class) {
        return '<nav class="navigation woocommerce-pagination %1$s" role="navigation">
                    <h2 class="screen-reader-text">%2$s</h2>
                    <div class="nav-links">%3$s</div>
                </nav>';
    }, 10, 2
);
/**
 *
 * VERSION MOBILE OPTION
 **/
if (!function_exists('ecotech_is_mobile')) {
    function ecotech_is_mobile($tablet = false)
    {
        $mobile_enable = ecotech_get_option('mobile_enable');

        if ($mobile_enable == 1) {
            if (class_exists('WP_Rocket_Mobile_Detect')) {
                $detect = new \WP_Rocket_Mobile_Detect();

                if ($tablet == true && ($detect->isMobile() || $detect->isTablet())) {
                    return true;
                }

                if ($detect->isMobile() && !$detect->isTablet()) {
                    return true;
                }
            } else {
                if (wp_is_mobile()) {
                    return true;
                }
            }
        }

        return false;
    }
}
/**
 *
 * GET OPTION
 **/
if (!function_exists('ecotech_get_option')) {
    function ecotech_get_option($option_name = '', $default = '')
    {
        $cs_option = array();
        if (get_option('_ovic_customize_options') !== false) {
            $cs_option = get_option('_ovic_customize_options');
        }
        if (isset($_GET[$option_name])) {
            $default                 = wp_unslash($_GET[$option_name]);
            $cs_option[$option_name] = wp_unslash($_GET[$option_name]);
        }
        $options = apply_filters('ecotech_get_customize_option', $cs_option, $option_name, $default);
        if (!empty($options) && isset($options[$option_name])) {
            $option = $options[$option_name];
            if (is_array($option) && isset($option['multilang']) && $option['multilang'] == true) {
                if (defined('ICL_LANGUAGE_CODE')) {
                    if (isset($option[ICL_LANGUAGE_CODE])) {
                        return $option[ICL_LANGUAGE_CODE];
                    }
                } else {
                    $option = reset($option);
                }
            }

            return $option;
        } else {
            return $default;
        }
    }
}

if (!function_exists('ecotech_preview_options')) {
    function ecotech_preview_options($name)
    {
        $cache_key       = '';
        $preview_options = array();
        $path            = trailingslashit(get_template_directory())."shortcode/{$name}/layout/";
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            return array();
        }
        if (ecotech_get_option('enable_cache_option')) {
            $cache_key = sanitize_key(implode('-', array('ecotech-preview', $name, ECOTECH)));
            $options   = get_transient($cache_key);
            if ($options) {
                return $options;
            }
        }
        if (is_dir($path)) {
            $files = scandir($path);
            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $fileInfo = pathinfo($file);
                        if ($fileInfo['extension'] == 'jpg') {
                            $fileName = str_replace(
                                array('_', '-'),
                                array(' ', ' '),
                                $fileInfo['filename']
                            );
                            /* PRINT OPTION */
                            $preview_options[$fileInfo['filename']] = ucwords($fileName);
                        }
                    }
                }
            }
        }

        if (!empty($cache_key)) {
            set_transient($cache_key, $preview_options);
        }

        return $preview_options;
    }
}

if (!function_exists('ecotech_get_header')) {
    function ecotech_get_header()
    {
        $header_options = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'header_template',
            'metabox_header_template',
            'style-01'
        );

        return $header_options;
    }
}
if (!function_exists('ecotech_get_footer')) {
    function ecotech_get_footer()
    {
        $mobile_footer = ecotech_get_option('mobile_footer', 'inherit');
        $footer_option = ecotech_theme_option_meta(
            '_custom_metabox_theme_options',
            'footer_template',
            'metabox_footer_template',
            'footer-01'
        );

        if (ecotech_is_mobile() && $mobile_footer != 'inherit') {
            $footer_option = $mobile_footer;
        }

        return $footer_option;
    }
}
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
if (!function_exists('ecotech_edit_link')) {
    function ecotech_edit_link($id = 0, $text = null)
    {
        if (!$post = get_post($id)) {
            return;
        }
        if (!$url = get_edit_post_link($post->ID)) {
            return;
        }
        if (null === $text) {
            $text = esc_html__('Edit This', 'ecotech');
        }
        /**
         * Filters the post edit link anchor tag.
         *
         * @param  string  $link  Anchor tag for the edit link.
         * @param  int  $post_id  Post ID.
         * @param  string  $text  Anchor text.
         *
         * @since 2.3.0
         *
         */
        ?>
        <span class="edit-link ovic-edit-link">
            <a class="post-edit-link" href="<?php echo esc_url($url); ?>">
                <span class="dashicons dashicons-edit"></span>
                <?php echo esc_html($text); ?>
            </a>
        </span>
        <?php
    }
}
if (!function_exists('ecotech_theme_option_meta')) {
    function ecotech_theme_option_meta($meta_id, $option_key, $key_meta = '', $default = '')
    {
        $ID = get_the_ID();

        if (!isset($_GET[$option_key]) && !empty($_GET['demo']) && $meta_id == '_custom_metabox_theme_options') {
            $ID = $_GET['demo'];
        }

        $data_meta = get_post_meta($ID, $meta_id, true);

        if ($option_key == null) {
            $enable_options = 1;
            $theme_options  = $default;
        } else {
            $enable_options = 0;
            if (!empty($data_meta['enable_metabox_options'])) {
                $enable_options = $data_meta['enable_metabox_options'];
            }
            $theme_options = ecotech_get_option($option_key, $default);
        }
        if ($key_meta == '' || $key_meta == null) {
            $key_meta = "metabox_{$option_key}";
        }
        if ($enable_options == 1 && isset($data_meta[$key_meta])) {
            $theme_options = $data_meta[$key_meta];
        }
        if ($default != '' && $theme_options == '') {
            $theme_options = $default;
        }

        return $theme_options;
    }
}
if (!function_exists('ecotech_get_logo')) {
    function ecotech_get_logo($shortcode = false)
    {
        $tag = 'div';
        if (is_home()) {
            $tag = !$shortcode ? 'h2' : 'h1';
        }
        $title = get_bloginfo('name');
        $desc  = get_bloginfo('description');
        if (!empty($desc)) {
            $title .= ' - '.$desc;
        }
        $logo_link   = apply_filters('ovic_get_link_logo', home_url('/'));
        $logo_url    = get_theme_file_uri('/assets/images/logo.svg');
        $logo        = ecotech_theme_option_meta('_custom_metabox_theme_options', 'logo');
        $logo_mobile = ecotech_get_option('logo_mobile');
        if (ecotech_is_mobile() && !empty($logo_mobile)) {
            $logo = ecotech_get_option('logo_mobile');
        }
        if (!empty($logo)) {
            $logo_url = wp_get_attachment_image_url($logo, 'full');
        }
        $html = '<'.$tag.' class="logo">';
        $html .= '<a href="'.esc_url($logo_link).'" title="'.esc_attr($title).'">';
        $html .= '<span><img alt="'.get_bloginfo('name').'" src="'.esc_url($logo_url).'" class="_rw" /></span>';
        $html .= '<span class="alt-logo screen-reader-text">'.esc_html($title).'</span>';
        $html .= '</a>';
        $html .= '</'.$tag.'>';

        echo apply_filters('ecotech_site_logo', $html);
    }
}
/**
 * Call a shortcode function by tag name.
 *
 * @param  string  $tag  The shortcode whose function to call.
 * @param  array  $atts  The attributes to pass to the shortcode function. Optional.
 * @param  array  $content  The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 * @since  1.4.6
 *
 */
if (!function_exists('ecotech_do_shortcode')) {
    function ecotech_do_shortcode($tag, array $atts = array(), $content = null)
    {
        global $shortcode_tags;
        if (!isset($shortcode_tags[$tag])) {
            return false;
        }

        return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
    }
}
if (!function_exists('ecotech_locate_template')) {
    function ecotech_locate_template($template_name, $template_path = '', $default_path = '')
    {
        if (!$template_path) {
            $template_path = get_template_directory();
        }
        if (!$default_path) {
            $default_path = get_template_directory();
        }
        // Look within passed path within the theme - this is priority.
        $template = locate_template(
            array(
                trailingslashit($template_path).$template_name,
                $template_name,
            )
        );
        // Get default template/.
        if (!$template) {
            $template = $default_path.$template_name;
        }

        // Return what we found.
        return apply_filters('ecotech_locate_template', $template, $template_name, $template_path);
    }
}
if (!function_exists('ecotech_get_template')) {
    function ecotech_get_template($template_name, $args = array(), $template_path = '', $default_path = '')
    {
        $cache_key = array('ecotech-template', $template_name, $template_path, $default_path, ECOTECH);
        $cache_key = sanitize_key(implode('-', $cache_key));
        $template  = (string) wp_cache_get($cache_key, 'ovic');

        if (!$template) {
            $template = ecotech_locate_template($template_name, $template_path, $default_path);
            wp_cache_set($cache_key, $template, 'ovic');
        }

        // Allow 3rd party plugin filter template file from their plugin.
        $filter_template = apply_filters('ecotech_get_template', $template, $template_name, $args, $template_path, $default_path);

        if ($filter_template !== $template) {
            if (!file_exists($filter_template)) {
                /* translators: %s template */
                _doing_it_wrong(
                    __FUNCTION__,
                    sprintf(__('%s does not exist.', 'ecotech'), '<code>'.$template.'</code>'),
                    '2.1'
                );

                return;
            }
            $template = $filter_template;
        }

        $action_args = array(
            'template_name' => $template_name,
            'template_path' => $template_path,
            'located'       => $template,
            'args'          => $args,
        );

        if (!empty($args) && is_array($args)) {
            if (isset($args['action_args'])) {
                _doing_it_wrong(
                    __FUNCTION__,
                    __('action_args should not be overwritten when calling ecotech_get_template.', 'ecotech'),
                    '3.6.0'
                );
                unset($args['action_args']);
            }
            extract($args); // @codingStandardsIgnoreLine
        }

        do_action('ecotech_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args']);

        include $action_args['located'];

        do_action('ecotech_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args']);
    }
}
/**
 *
 * QUERY POSTS
 **/
if (!function_exists('ecotech_shortcode_posts_query')) {
    function ecotech_shortcode_posts_query($atts, $post_type = 'post')
    {
        global $post;

        $args = array(
            'post_type'           => $post_type,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'suppress_filter'     => true,
            'posts_per_page'      => $atts['limit'],
            'orderby'             => $atts['orderby'],
            'order'               => $atts['order'],
        );
        if (!empty($atts['category'])) {
            $args['category_name'] = $atts['category'];
        }
        switch ($atts['target']) {
            case 'popularity':
                $args['meta_key'] = 'ecotech_post_views_count';
                $args['orderby']  = 'meta_value_num';

                break;

            case 'related':
                $categories = get_the_category($post->ID);
                $ids        = array();
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $ids[] = $category->term_id;
                    }
                }
                $args['category__in'] = $ids;
                $args['post__not_in'] = array($post->ID);

                break;

            case 'title':
                $args['orderby'] = 'title';
                $args['order']   = 'ASC';

                break;

            case 'date':
                $args['orderby'] = array(
                    'post_date' => 'DESC',
                    'title'     => 'ASC',
                );

                break;

            case 'random':
                $args['orderby'] = 'rand';

                break;

            case 'post':
                $args['post__in']       = is_array($atts['ids']) ? $atts['ids'] : explode(',', $atts['ids']);
                $args['posts_per_page'] = -1;
                unset($args['category_name']);

                break;
        }

        return $args;
    }
}
/**
 *
 * QUERY PRODUCTS
 **/
if (!function_exists('ecotech_shortcode_products_query')) {
    function ecotech_shortcode_products_query($atts, $exclude_id = false)
    {
        if (!class_exists('WooCommerce')) {
            return array();
        }
        $atts['ids'] = is_array($atts['ids']) ? implode(',', $atts['ids']) : $atts['ids'];
        /* QUERY DATA PRODUCTS */
        if (isset($atts['filter']) && $atts['filter'] && $atts['attribute'] != '') {
            $atts['terms'] = $atts['filter'];
        }
        add_filter('woocommerce_shortcode_products_query',
            function ($query_args) use ($atts, $exclude_id) {
                if (isset($atts['category_brand']) && $atts['category_brand'] && $atts['category_brand'] != '') {
                    $query_args['tax_query'][] = array(
                        'taxonomy' => 'product_brand',
                        'terms'    => array_map('sanitize_title', explode(',', $atts['category_brand'])),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    );
                }
                if (isset($atts['vendor_list']) && $atts['vendor_list'] != '' && function_exists('wcmp_plugin_init')) {
                    global $WCMp;
                    $term_id                   = get_user_meta($atts['vendor_list'], '_vendor_term_id', true);
                    $query_args['tax_query'][] = array(
                        'taxonomy' => $WCMp->taxonomy->taxonomy_name,
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    );
                }
                if (!empty($atts['orderby']) && $atts['orderby'] == 'most-viewed') {
                    $query_args['meta_key']     = 'ovic_product_views_count';
                    $query_args['orderby']      = 'meta_value_num';
                    $query_args['order']        = 'DESC';
                    $query_args['meta_query'][] = array(
                        'relation' => 'AND'
                    );
                }
                if ($exclude_id) {
                    if ($atts['ids'] != '') {
                        $exclude_id             = array_diff($query_args['post__in'], (array) $exclude_id);
                        $query_args['post__in'] = !empty($exclude_id) ? $exclude_id : array('');
                    } else {
                        $query_args['post__not_in'] = (array) $exclude_id;
                    }
                }

                return $query_args;
            }
        );
        $args = array(
            'limit'     => '-1',      // Results limit.
            'columns'   => '',        // Number of columns.
            'orderby'   => 'title',   // menu_order, title, date, rand, price, popularity, rating, or id.
            'order'     => 'ASC',     // ASC or DESC.
            'ids'       => '',        // Comma separated IDs.
            'skus'      => '',        // Comma separated SKUs.
            'category'  => '',        // Comma separated category slugs or ids.
            'attribute' => '',        // Single attribute slug.
            'terms'     => '',        // Comma separated term slugs or ids.
            'class'     => '',        // HTML class.
            'page'      => '1',
            'paginate'  => true,
        );
        foreach ($args as $key => $shortcode) {
            if (isset($atts[$key]) && $atts[$key] != '') {
                $args[$key] = $atts[$key];
            }
        }

        return $args;
    }
}
/**
 *    RESIZE IMAGE
 *
 *    Enable Lazy     : enable_lazy_load
 *    Disable Crop    : disable_crop_image
 **/
if (!function_exists('ecotech_resize_image')) {
    function ecotech_resize_image($attachment_id, $width, $height, $crop = false, $use_lazy = false, $placeholder = true, $class = '')
    {
        if (function_exists('ovic_resize_image')) {
            return ovic_resize_image($attachment_id, $width, $height, $crop, $use_lazy, $placeholder, $class);
        } else {
            $size_class = $width.'x'.$height;
            $image_alt  = '';
            if ($attachment_id) {
                $image_src = wp_get_attachment_image_src($attachment_id, $size_class);
                $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                $vt_image  = array(
                    'url'    => $image_src[0],
                    'width'  => $image_src[1],
                    'height' => $image_src[2],
                    'img'    => '<img class="attachment-'.esc_attr($size_class).' size-'.esc_attr($size_class).' '.esc_attr($class).'" src="'.esc_url($image_src[0]).'" '.image_hwstring($image_src[1],
                            $image_src[2]).' alt="'.esc_attr($image_alt).'">',
                );
            } else {
                $placeholder = 'https://via.placeholder.com/'.$width.'x'.$height;
                $vt_image    = array(
                    'url'    => $placeholder,
                    'width'  => $width,
                    'height' => $height,
                    'img'    => '<img class="attachment-'.esc_attr($size_class).' size-'.esc_attr($size_class).' '.esc_attr($class).'" src="'.esc_url($placeholder).'" '.image_hwstring($width,
                            $height).' alt="'.esc_attr($image_alt).'">',
                );
            }

            return $vt_image;
        }
    }
}
/**
 *
 * GET OPTIONS
 **/
if (!function_exists('ecotech_file_options')) {
    function ecotech_file_options($path, $name, $is_block = false)
    {
        $cache_key = '';
        $id_block  = $is_block ? 'block' : 'none-block';
        if (ecotech_get_option('enable_cache_option')) {
            $cache_key = sanitize_key(implode('-', array('ecotech-file-options', $name, $id_block, $path, ECOTECH)));
            $options   = get_transient($cache_key);
            if ($options) {
                return $options;
            }
        }
        $layoutDir      = get_template_directory().$path;
        $header_options = array();
        if (is_dir($layoutDir)) {
            $files = scandir($layoutDir);
            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && $file != 'style') {
                        $fileInfo  = pathinfo($file);
                        $file_data = get_file_data($layoutDir.$file,
                            array(
                                'Name' => 'Name',
                            )
                        );
                        if (isset($fileInfo['extension']) && $fileInfo['extension'] == 'php' && $fileInfo['basename'] != 'index.php') {
                            if ($file_data['Name'] != '') {
                                $file_name = $file_data['Name'];
                            } else {
                                $file_name = str_replace(array('_', '-', 'content'), array(
                                    ' ',
                                    ' ',
                                    ''
                                ), $fileInfo['filename']);
                            }
                            $preview = get_theme_file_uri('/assets/images/placeholder.jpg');
                            $file_id = $name != '' ? str_replace("{$name}-", '', $fileInfo['filename']) : $fileInfo['filename'];
                            if (is_file(get_template_directory()."{$path}{$fileInfo['filename']}.jpg")) {
                                $preview = get_theme_file_uri("{$path}{$fileInfo['filename']}.jpg");
                            }
                            if ($is_block == true) {
                                $header_options[$file_id] = ucwords($file_name);
                            } else {
                                $header_options[$file_id] = array(
                                    'title'   => ucwords($file_name),
                                    'preview' => $preview,
                                );
                            }
                        }
                    }
                }
            }
        }

        if (!empty($cache_key)) {
            set_transient($cache_key, $header_options);
        }

        return $header_options;
    }
}
if (!function_exists('ecotech_footer_preview')) {
    function ecotech_footer_preview($inherit = false)
    {
        $cache_key = '';
        if (ecotech_get_option('enable_cache_option')) {
            $cache_key = sanitize_key(implode('-', array('ecotech-footer-preview', ECOTECH)));
            $options   = get_transient($cache_key);
            if ($options) {
                if ($inherit == false) {
                    unset($options['inherit']);
                }

                return $options;
            }
        }
        $footer_preview            = array();
        $footer_preview['inherit'] = array(
            'title'   => esc_html__('Inherit Desktop', 'ecotech'),
            'preview' => get_theme_file_uri('/assets/images/placeholder.jpg'),
        );
        $footer_preview['none']    = array(
            'title'   => esc_html__('None', 'ecotech'),
            'preview' => get_theme_file_uri('/assets/images/placeholder.jpg'),
        );
        $args                      = array(
            'post_type'      => 'ovic_footer',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        );
        $posts          = get_posts($args);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                setup_postdata($post);
                $url     = get_edit_post_link($post->ID);
                $preview = get_theme_file_uri('/assets/images/placeholder.jpg');
                if (has_post_thumbnail($post)) {
                    $preview = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full');
                }
                $footer_preview[$post->post_name] = array(
                    'title'   => $post->post_title,
                    'preview' => $preview,
                    'url'     => $url,
                );
            }
        }
        wp_reset_postdata();

        if (!empty($cache_key)) {
            set_transient($cache_key, $footer_preview, 12 * HOUR_IN_SECONDS);
        }
        if ($inherit == false) {
            unset($footer_preview['inherit']);
        }

        return $footer_preview;
    }
}
if (!function_exists('ecotech_social_option')) {
    function ecotech_social_option($reverse = false)
    {
        $socials     = array();
        $all_socials = ecotech_get_option('user_all_social');
        if (!empty($all_socials)) {
            foreach ($all_socials as $key => $social) {
                if ($reverse) {
                    $socials[$social['title_social']] = $key;
                } else {
                    $socials[$key] = $social['title_social'];
                }
            }
        }

        return $socials;
    }
}
if (!function_exists('ecotech_product_options')) {
    function ecotech_product_options($allow = 'Theme Option', $is_block = false)
    {
        $cache_key = '';
        $id_block  = $is_block ? 'block' : 'none-block';
        if (ecotech_get_option('enable_cache_option')) {
            $cache_key = sanitize_key(implode('-', array('ecotech-product-options', $allow, $id_block, ECOTECH)));
            $options   = get_transient($cache_key);
            if ($options) {
                return $options;
            }
        }
        $layoutDir       = get_template_directory().'/woocommerce/product-style/';
        $product_options = array();
        if (is_dir($layoutDir)) {
            $files = scandir($layoutDir);
            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $fileInfo  = pathinfo($file);
                        $file_data = get_file_data($layoutDir.$file, array(
                            'Name'         => 'Name',
                            'Theme Option' => 'Theme Option',
                            'Shortcode'    => 'Shortcode',
                        ));
                        $file_name = str_replace('content-product-', '', $fileInfo['filename']);
                        if ($fileInfo['extension'] == 'php' && $fileInfo['basename'] != 'index.php' && $file_data[$allow] == 'true') {
                            $preview = get_theme_file_uri('woocommerce/product-style/content-product-'.$file_name.'.jpg');
                            if ($file_data['Name'] != '') {
                                $file_title = $file_data['Name'];
                            } else {
                                $file_title = str_replace(array('_', '-', 'content'), array(
                                    ' ',
                                    ' ',
                                    ''
                                ), $fileInfo['filename']);
                            }
                            if ($is_block) {
                                $product_options[$file_name] = $file_title;
                            } else {
                                $product_options[$file_name] = array(
                                    'title'   => $file_title,
                                    'preview' => $preview,
                                );
                            }
                        }
                    }
                }
            }
        }
        if (empty($product_options)) {
            $product_options['no-product'] = array(
                'title' => esc_html__('No Product Found', 'ecotech'),
            );
        }

        if (!empty($cache_key)) {
            set_transient($cache_key, $product_options);
        }

        return $product_options;
    }
}
if (!function_exists('ecotech_page_layout')) {
    function ecotech_page_layout()
    {
        if (class_exists('WooCommerce') && is_woocommerce()) {
            $sidebar_layout = ecotech_get_option('sidebar_shop_layout', 'left');
            $sidebar_name   = ecotech_get_option('shop_used_sidebar', 'shop-widget-area');
            if (is_product()) {
                $sidebar_layout = ecotech_get_option('sidebar_product_layout', 'left');
                $sidebar_name   = ecotech_get_option('product_used_sidebar', 'product-widget-area');
                if (function_exists('dokan_is_product_edit_page') && dokan_is_product_edit_page()) {
                    $sidebar_name   = 'dokan-no-sidebar';
                    $sidebar_layout = 'full';
                }
            }
            if (is_product_taxonomy() && 0 === absint(get_query_var('paged'))) {
                $term = get_queried_object();
                if ($term && $term->taxonomy == 'dc_vendor_shop') {
                    $sidebar_name = ecotech_get_option('shop_vendor_used_sidebar', 'vendor-widget-area');
                }
            }
            if (!is_active_sidebar($sidebar_name)) {
                $sidebar_layout = 'full';
            }
        } elseif (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
            $sidebar_name   = 'dokan-no-sidebar';
            $sidebar_layout = 'full';
        } elseif (is_page()) {
            $sidebar_name   = ecotech_theme_option_meta('_custom_page_side_options', null, 'page_sidebar',
                'widget-area');
            $sidebar_layout = ecotech_theme_option_meta('_custom_page_side_options', null, 'sidebar_page_layout',
                'left');
            if (!is_active_sidebar($sidebar_name)) {
                $sidebar_layout = 'full';
            }
        } else {
            $sidebar_layout = ecotech_get_option('sidebar_blog_layout', 'left');
            $sidebar_name   = ecotech_get_option('blog_used_sidebar', 'widget-area');
            if (is_single()) {
                $sidebar_layout = ecotech_get_option('sidebar_single_layout', 'left');
                $sidebar_name   = ecotech_get_option('single_used_sidebar', 'widget-area');
            }
            if (!is_active_sidebar($sidebar_name)) {
                $sidebar_layout = 'full';
            }
        }

        return array(
            'sidebar' => $sidebar_name,
            'layout'  => $sidebar_layout,
        );
    }
}
if (!function_exists('ecotech_breadcrumb')) {
    function ecotech_breadcrumb()
    {
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            woocommerce_breadcrumb(
                array(
                    'delimiter'   => '<span class="delimiter"></span>',
                    'wrap_before' => '<nav class="woocommerce-breadcrumb">',
                    'wrap_after'  => '</nav>',
                )
            );
        } elseif ( class_exists( 'WeDevs_Dokan' ) && dokan_is_store_page() ) {
            woocommerce_breadcrumb(
                array(
                    'delimiter'   => '<span class="delimiter"></span>',
                    'wrap_before' => '<nav class="woocommerce-breadcrumb">',
                    'wrap_after'  => '</nav>',
                )
            );
        } else {
            ecotech_breadcrumb_trail(array(
                'show_browse' => false,
            ));
        }
    }
}
if (!function_exists('ecotech_page_title')) {
    function ecotech_page_title()
    {
        if (is_home()) : ?>
            <?php if (is_front_page()) : ?>
                <h1 class="page-title entry-title">
                    <span><?php esc_html_e('Latest Posts', 'ecotech'); ?></span>
                </h1>
            <?php else: ?>
                <h1 class="page-title entry-title">
                    <span><?php single_post_title(); ?></span>
                </h1>
            <?php endif; ?>
        <?php elseif (is_page()) : ?>
            <h1 class="page-title entry-title">
                <span><?php single_post_title(); ?></span>
            </h1>
        <?php elseif (is_single()) : ?>
            <h1 class="page-title entry-title">
                <span><?php single_post_title(); ?></span>
            </h1>
        <?php elseif (function_exists('is_woocommerce') && is_woocommerce()) : ?>
            <h1 class="page-title entry-title">
                <span><?php woocommerce_page_title(); ?></span>
            </h1>
        <?php else: ?>
            <?php if (is_search()) : ?>
                <h1 class="page-title entry-title">
                    <span><?php printf(esc_html__('Search Results for: "%s"', 'ecotech'),
                            '<span class="search-results">'.get_search_query().'</span>'); ?></span>
                </h1>
            <?php else: ?>
                <?php if ( class_exists( 'WeDevs_Dokan' ) && dokan_is_store_page() ) :
                    $store_user = dokan()->vendor->get( get_query_var( 'author' ) );
                    ?>
                    <h1 class="page-title entry-title">
                        <span><?php echo esc_html( $store_user->get_shop_name() ); ?></span>
                    </h1>
                <?php else: ?>
                    <h1 class="page-title entry-title">
                        <span><?php the_archive_title('', ''); ?></span>
                    </h1>
                    <?php the_archive_description('<div class="taxonomy-description">', '</div>'); ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif;
    }
}
if (!function_exists('ecotech_share_social')) {
    function ecotech_share_social($id = null)
    {
        if (function_exists('ovic_share_button')) {
            ovic_share_button($id);
        }
    }
}
if (!function_exists('ecotech_author_social')) {
    function ecotech_author_social($author_id)
    {
        ecotech_get_template(
            "templates-parts/author-social.php",
            array(
                'author_id' => $author_id,
            )
        );
    }
}
/**
 *
 * ACTION
 * $functions = array(
 *      array( {action},{tag}, {callback},{priority}, {arg} ),
 *      array( {action},{tag}, {callback},{priority}, {arg} ),
 * );
 */
if (!function_exists('ecotech_add_action')) {
    function ecotech_add_action($functions, $reverse = false)
    {
        if (!empty($functions)) {
            foreach ($functions as $function) {
                $actions  = $function[0];
                $priority = isset($function[3]) ? $function[3] : 10;
                $args     = isset($function[4]) ? $function[4] : 1;
                if ($reverse) {
                    $search  = 'add_';
                    $replace = 'remove_';
                    if (strpos($actions, 'add_') === false) {
                        $search  = 'remove_';
                        $replace = 'add_';
                    }
                    $actions = str_replace($search, $replace, $actions);
                }
                call_user_func($actions, $function[1], $function[2], $priority, $args);
            }
        }
    }
}
if (!function_exists('ecotech_set_post_views')) {
    function ecotech_set_post_views($postID = false, $post_type = 'post')
    {
        if (!$postID) {
            $postID = get_the_ID();
        }
        if (get_post_type($postID) === $post_type) {
            $count_key = "ecotech_{$post_type}_views_count";
            $count     = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                update_post_meta($postID, $count_key, '0');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    }
}
if (!function_exists('ecotech_get_post_views')) {
    function ecotech_get_post_views($postID = false, $post_type = 'post')
    {
        if (!$postID) {
            $postID = get_the_ID();
        }
        $count_key = "ecotech_{$post_type}_views_count";
        $count     = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            update_post_meta($postID, $count_key, '0');
            echo '0';
        }
        echo ecotech_number_format_short($count);
    }
}
if (!function_exists('ecotech_track_post_views')) {
    function ecotech_track_post_views($post_id)
    {
        global $post;

        if (is_single() && !empty($post->ID) && $post->post_type == 'post') {
            ecotech_set_post_views($post->ID, 'post');
        }

        if (function_exists('is_product') && is_product() && !empty($post->ID) && $post->post_type == 'product') {
            ecotech_set_post_views($post->ID, 'product');
        }
    }

    add_action('wp_head', 'ecotech_track_post_views');
}
/**
 * @param $n
 *
 * @return string
 * Use to convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
 */
if (!function_exists('ecotech_number_format_short')) {
    function ecotech_number_format_short($n)
    {
        if ($n >= 0 && $n < 1000) {
            // 1 - 999
            $n_format = floor($n);
            $suffix   = '';
        } elseif ($n >= 1000 && $n < 1000000) {
            // 1k-999k
            $n_format = floor($n / 1000);
            $suffix   = 'K+';
        } elseif ($n >= 1000000 && $n < 1000000000) {
            // 1m-999m
            $n_format = floor($n / 1000000);
            $suffix   = 'M+';
        } elseif ($n >= 1000000000 && $n < 1000000000000) {
            // 1b-999b
            $n_format = floor($n / 1000000000);
            $suffix   = 'B+';
        } elseif ($n >= 1000000000000) {
            // 1t+
            $n_format = floor($n / 1000000000000);
            $suffix   = 'T+';
        }

        return !empty($n_format) ? $n_format.$suffix : 0;
    }
}
if (!function_exists('ecotech_get_form_newsletter')) {
    function ecotech_get_form_newsletter()
    {
        $cache_key = '';
        if (ecotech_get_option('enable_cache_option')) {
            $cache_key = sanitize_key(implode('-', array('ecotech-form-newsletter', ECOTECH)));
            $options   = get_transient($cache_key);
            if ($options) {
                return $options;
            }
        }
        $default_id             = get_option('mc4wp_default_form_id', '0');
        $list_form[$default_id] = esc_html__('Default Form', 'ecotech');
        if (function_exists('mc4wp_show_form')) {
            $args  = array(
                'posts_per_page' => -1,
                'post_type'      => 'mc4wp-form',
                'post_status'    => 'publish',
                'fields'         => 'ids',
            );
            $posts = get_posts($args);
            if ($posts) {
                foreach ($posts as $post_id) {
                    $post_id             = intval($post_id);
                    $title               = get_the_title($post_id);
                    $list_form[$post_id] = $title;
                }
            }
        }

        if (!empty($cache_key)) {
            set_transient($cache_key, $list_form, 12 * HOUR_IN_SECONDS);
        }

        return $list_form;
    }
}
if (!function_exists('ecotech_mobile_menu')) {
    function ecotech_mobile_menu($menu_locations, $default = 'primary')
    {
        if (!empty($menu_locations)) {
            $count       = 0;
            $mobile_menu = '';
            $array_menus = array();
            $array_child = array();
            $mobile_menu .= "<div class='ovic-menu-clone-wrap'>";
            $mobile_menu .= "<div class='ovic-menu-panels-actions-wrap'>";
            $mobile_menu .= "<span class='ovic-menu-current-panel-title'>".esc_html__('Main Menu',
                    'ecotech')."</span>";
            $mobile_menu .= "<a href='#' class='ovic-menu-close-btn ovic-menu-close-panels'>x</a>";
            $mobile_menu .= "</div>";
            $mobile_menu .= "<div class='ovic-menu-panels'>";
            foreach ((array) $menu_locations as $location) {
                $menu_items = array();
                if (wp_get_nav_menu_items($location)) {
                    $menu_items = wp_get_nav_menu_items($location);
                } else {
                    $locations = get_nav_menu_locations();
                    if (isset($locations[$default])) {
                        $menu       = wp_get_nav_menu_object($locations[$default]);
                        $menu_items = wp_get_nav_menu_items($menu->name);
                    }
                }
                if (!empty($menu_items)) {
                    foreach ($menu_items as $key => $menu_item) {
                        $parent_id = $menu_item->menu_item_parent;
                        /* REND CLASS */
                        $classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
                        $classes[] = 'menu-item';
                        $classes[] = 'menu-item-'.$menu_item->ID;
                        /* REND ARGS */
                        $array_menus[$parent_id][$menu_item->ID] = array(
                            'url'   => $menu_item->url,
                            'class' => $classes,
                            'title' => $menu_item->title,
                        );
                        if ($parent_id > 0) {
                            $array_child[] = $parent_id;
                        }
                    }
                }
            }
            foreach ($array_menus as $parent_id => $menus) {
                $main_id = uniqid('main-');
                if ($count == 0) {
                    $mobile_menu .= "<div id='ovic-menu-panel-{$main_id}' class='ovic-menu-panel ovic-menu-panel-main'>";
                } else {
                    $mobile_menu .= "<div id='ovic-menu-panel-{$parent_id}' class='ovic-menu-panel ovic-menu-sub-panel ovic-menu-hidden'>";
                }
                $mobile_menu .= "<ul class='depth-{$count}'>";
                foreach ($menus as $id => $menu) {
                    $class_menu  = join(' ', $menu['class']);
                    $mobile_menu .= "<li id='ovic-menu-clone-menu-item-{$id}' class='{$class_menu}'>";
                    if (in_array($id, $array_child)) {
                        $mobile_menu .= "<a class='ovic-menu-next-panel' href='#ovic-menu-panel-{$id}' data-target='#ovic-menu-panel-{$id}'></a>";
                    }
                    $mobile_menu .= "<a href='{$menu['url']}'>{$menu['title']}</a>";
                    $mobile_menu .= "</li>";
                }
                $mobile_menu .= "</ul></div>";
                $count++;
            }
            $mobile_menu .= "</div></div>";
            /*
             * Export Html
             * */
            echo wp_specialchars_decode($mobile_menu);
        }
    }
}