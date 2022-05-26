<?php
/**
 * Price Filter Widget and related functions.
 *
 * Generates a range slider to filter products by price.
 *
 * @package WooCommerce/Widgets
 * @version 2.3.0
 */

defined('ABSPATH') || exit;

/**
 * Widget price filter class.
 */
if (!class_exists('Ovic_Price_Filter') && class_exists('OVIC_Widget')) {
    class Ovic_Price_Filter extends OVIC_Widget
    {
        /**
         * Constructor.
         */
        public function __construct()
        {
            $this->widget_cssclass    = 'ovic-price-filter';
            $this->widget_description = esc_html__('Display the customer Price Filter.', 'ecotech');
            $this->widget_id          = 'ovic_price_filter';
            $this->widget_name        = esc_html__('Ovic: Price Filter', 'ecotech');
            $this->settings           = array(
                'title' => array(
                    'type'  => 'text',
                    'title' => esc_html__('Title', 'ecotech'),
                ),
                'price' => array(
                    'type'    => 'group',
                    'title'   => esc_html__('Price list', 'ecotech'),
                    'fields'  => array(
                        array(
                            'id'    => 'text',
                            'type'  => 'text',
                            'title' => esc_html__('Price text', 'ecotech'),
                        ),
                        array(
                            'id'    => 'min',
                            'type'  => 'text',
                            'title' => esc_html__('Min value', 'ecotech'),
                            'after' => esc_html__('Price number or min | max. ( min: get min price, max: get max price )',
                                'ecotech'),
                        ),
                        array(
                            'id'    => 'max',
                            'type'  => 'text',
                            'title' => esc_html__('Max value', 'ecotech'),
                            'after' => esc_html__('Price number or min | max. ( min: get min price, max: get max price )',
                                'ecotech'),
                        ),
                    ),
                    'default' => array(
                        array(
                            'text' => esc_html__('Max and Min Price', 'ecotech'),
                            'min'  => 'min',
                            'max'  => 'max',
                        )
                    )
                ),
            );

            parent::__construct();
        }

        /**
         * Output widget.
         *
         * @param  array  $args
         * @param  array  $instance
         *
         * @see WP_Widget
         *
         */
        public function widget($args, $instance)
        {
            global $wp;

            // Requires lookup table added in 3.6.
            if (version_compare(get_option('woocommerce_db_version', null), '3.6', '<')) {
                return;
            }

            if (!is_shop() && !is_product_taxonomy()) {
                return;
            }

            // If there are not posts and we're not filtering, hide the widget.
            if (!WC()->query->get_main_query()->post_count && !isset($_GET['min_price']) && !isset($_GET['max_price'])) { // WPCS: input var ok, CSRF ok.
                return;
            }

            ob_start();

            if (!is_product() && !empty($instance['price'])) {

                // Round values to nearest 10 by default.
                $step = max(apply_filters('woocommerce_price_filter_widget_step', 10), 1);

                // Find min and max price in current result set.
                $prices    = $this->get_filtered_price();
                $min_price = $prices->min_price;
                $max_price = $prices->max_price;

                // Check to see if we should add taxes to the prices if store are excl tax but display incl.
                $tax_display_mode = get_option('woocommerce_tax_display_shop');

                if (wc_tax_enabled() && !wc_prices_include_tax() && 'incl' === $tax_display_mode) {
                    $tax_class = apply_filters('woocommerce_price_filter_widget_tax_class',
                        ''); // Uses standard tax class.
                    $tax_rates = WC_Tax::get_rates($tax_class);

                    if ($tax_rates) {
                        $min_price += WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($min_price, $tax_rates));
                        $max_price += WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max_price, $tax_rates));
                    }
                }

                $min_price = apply_filters('woocommerce_price_filter_widget_min_amount',
                    floor($min_price / $step) * $step);
                $max_price = apply_filters('woocommerce_price_filter_widget_max_amount',
                    ceil($max_price / $step) * $step);

                // If both min and max are equal, we don't need a slider.
                if ($min_price === $max_price) {
                    return;
                }

                $current_min_price = isset($_GET['min_price']) ? floor(floatval(wp_unslash($_GET['min_price'])) / $step) * $step : $min_price; // WPCS: input var ok, CSRF ok.
                $current_max_price = isset($_GET['max_price']) ? ceil(floatval(wp_unslash($_GET['max_price'])) / $step) * $step : $max_price;  // WPCS: input var ok, CSRF ok.

                $place_price = array();

                if (is_product_taxonomy() && 0 === absint(get_query_var('paged'))) {
                    $term = get_queried_object();

                    if ($term) {
                        $meta = get_term_meta($term->term_id, '_custom_taxonomy_options', true);
                        if (!empty($meta['price_filter'])) {
                            $instance['price'] = $meta['price_filter'];
                        }
                    }
                }

                if (!empty($instance['price'])) {
                    foreach ($instance['price'] as $price) {
                        $place_price[] = array(
                            'text' => $price['text'],
                            'min'  => $price['min'] == 'min' ? $min_price : $price['min'],
                            'max'  => $price['max'] == 'max' ? $max_price : $price['max'],
                        );
                    }
                }

                if ('' === get_option('permalink_structure')) {
                    $form_action = remove_query_arg(array(
                        'page',
                        'paged',
                        'product-page'
                    ), add_query_arg($wp->query_string, '', home_url($wp->request)));
                } else {
                    $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));
                }

                if (!empty($place_price)):

                    $this->widget_start($args, $instance);

                    $base_link = $this->get_current_page_url();
                    $base_link = remove_query_arg(array(
                        'min_price',
                        'max_price',
                    ), $base_link);

                    ?>
                    <div class="price-filter-inner">
                        <?php foreach ($place_price as $price) : ?>
                            <?php if ($current_min_price == $price['min'] && $current_max_price == $price['max']) : ?>
                                <div>
                                    <a href="<?php echo esc_url($base_link); ?>" class="price-item active">
                                        <?php echo wp_specialchars_decode($price['text']); ?>
                                    </a>
                                </div>
                            <?php else: ?>
                                <form class="woocommerce-price" method="get"
                                      action="<?php echo esc_attr($form_action); ?>">
                                    <button class="price-item" type="submit" value="">
                                        <?php echo wp_specialchars_decode($price['text']); ?>
                                    </button>
                                    <?php if ($price['min'] !== 0): ?>
                                        <input type="hidden" name="min_price"
                                               value="<?php echo esc_attr($price['min']); ?>"/>
                                    <?php endif; ?>
                                    <?php if ($price['max'] !== 0): ?>
                                        <input type="hidden" name="max_price"
                                               value="<?php echo esc_attr($price['max']); ?>"/>
                                    <?php endif; ?>
                                    <?php wc_query_string_form_fields(null, array(
                                        'min_price',
                                        'max_price'
                                    ), '', true); ?>
                                </form>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php

                    $this->widget_end($args);

                endif;
            }

            echo apply_filters('widget_ovic_price_filter', ob_get_clean(), $instance);
        }

        /**
         * Get filtered min price for current products.
         *
         * @return array|object|void|null
         */
        protected function get_filtered_price()
        {
            global $wpdb;

            $args       = WC()->query->get_main_query()->query_vars;
            $tax_query  = isset($args['tax_query']) ? $args['tax_query'] : array();
            $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

            if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
                $tax_query[] = WC()->query->get_main_tax_query();
            }

            foreach ($meta_query + $tax_query as $key => $query) {
                if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                    unset($meta_query[$key]);
                }
            }

            $meta_query = new WP_Meta_Query($meta_query);
            $tax_query  = new WP_Tax_Query($tax_query);
            $search     = WC_Query::get_main_search_query_sql();

            $meta_query_sql   = $meta_query->get_sql('post', $wpdb->posts, 'ID');
            $tax_query_sql    = $tax_query->get_sql($wpdb->posts, 'ID');
            $search_query_sql = $search ? ' AND '.$search : '';

            $sql = "
			SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
			FROM {$wpdb->wc_product_meta_lookup}
			WHERE product_id IN (
				SELECT ID FROM {$wpdb->posts}
				".$tax_query_sql['join'].$meta_query_sql['join']."
				WHERE {$wpdb->posts}.post_type IN ('".implode("','",
                    array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product'))))."')
				AND {$wpdb->posts}.post_status = 'publish'
				".$tax_query_sql['where'].$meta_query_sql['where'].$search_query_sql.'
			)';

            $sql = apply_filters('woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql);

            return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
        }
    }

    /**
     * Register Widgets.
     *
     * @since 2.3.0
     */
    add_action('widgets_init',
        function () {
            ovic_install_widget('Ovic_Price_Filter');
        }
    );
}