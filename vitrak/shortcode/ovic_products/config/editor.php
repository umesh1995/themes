<?php

class Editor_Ovic_Products
{
    public static function shortcode_config()
    {
        return array(
            'name'   => 'ovic_products',
            'title'  => 'Products',
            'fields' => array(
                array(
                    'id'    => 'title',
                    'type'  => 'text',
                    'title' => esc_html__('Title', 'ecotech'),
                ),
                array(
                    'id'      => 'is_editor',
                    'type'    => 'text',
                    'default' => 'yes',
                    'class'   => 'ovic-hidden',
                ),
                array(
                    'id'          => 'product_style',
                    'type'        => 'select_preview',
                    'title'       => esc_html__('Product style', 'ecotech'),
                    'options'     => ecotech_product_options('Shortcode'),
                    'default'     => 'style-01',
                    'description' => esc_html__('Select a style for product item', 'ecotech'),
                ),
                array(
                    'id'          => 'target',
                    'type'        => 'select',
                    'title'       => esc_html__('Target', 'ecotech'),
                    'options'     => array(
                        'recent_products'       => esc_html__('Recent Products', 'ecotech'),
                        'featured_products'     => esc_html__('Feature Products', 'ecotech'),
                        'sale_products'         => esc_html__('Sale Products', 'ecotech'),
                        'best_selling_products' => esc_html__('Best Selling Products', 'ecotech'),
                        'top_rated_products'    => esc_html__('Top Rated Products', 'ecotech'),
                        'products'              => esc_html__('Products', 'ecotech'),
                        'product_category'      => esc_html__('Products Category', 'ecotech'),
                        'related_products'      => esc_html__('Products Related', 'ecotech'),
                    ),
                    'attributes'  => array(
                        'data-depend-id' => 'target',
                    ),
                    'default'     => 'recent_products',
                    'description' => esc_html__('Choose the target to filter products', 'ecotech'),
                ),
                array(
                    'id'          => 'ids',
                    'type'        => 'select',
                    'chosen'      => true,
                    'multiple'    => true,
                    'sortable'    => true,
                    'ajax'        => true,
                    'options'     => 'posts',
                    'query_args'  => array(
                        'post_type' => 'product',
                    ),
                    'title'       => esc_html__('Products', 'ecotech'),
                    'description' => esc_html__('Enter List of Products', 'ecotech'),
                    'dependency'  => array('target', '==', 'products'),
                ),
                array(
                    'id'          => 'category',
                    'type'        => 'select',
                    'chosen'      => true,
                    'ajax'        => true,
                    'options'     => 'categories',
                    'placeholder' => esc_html__('Select Products Category', 'ecotech'),
                    'query_args'  => array(
                        'hide_empty' => true,
                        'taxonomy'   => 'product_cat',
                    ),
                    'title'       => esc_html__('Product Categories', 'ecotech'),
                    'description' => esc_html__('Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.',
                        'ecotech'),
                    'dependency'  => array('target', '!=', 'products'),
                ),
                array(
                    'id'          => 'limit',
                    'type'        => 'number',
                    'unit'        => 'items(s)',
                    'default'     => '6',
                    'title'       => esc_html__('Limit', 'ecotech'),
                    'description' => esc_html__('How much items per page to show', 'ecotech'),
                ),
                array(
                    'id'      => 'columns',
                    'type'    => 'number',
                    'unit'    => 'items(s)',
                    'default' => '4',
                    'title'   => esc_html__('Columns', 'ecotech'),
                ),
                array(
                    'id'          => 'orderby',
                    'type'        => 'select',
                    'title'       => esc_html__('Order by', 'ecotech'),
                    'options'     => array(
                        ''              => esc_html__('None', 'ecotech'),
                        'date'          => esc_html__('Date', 'ecotech'),
                        'ID'            => esc_html__('ID', 'ecotech'),
                        'author'        => esc_html__('Author', 'ecotech'),
                        'title'         => esc_html__('Title', 'ecotech'),
                        'modified'      => esc_html__('Modified', 'ecotech'),
                        'rand'          => esc_html__('Random', 'ecotech'),
                        'comment_count' => esc_html__('Comment count', 'ecotech'),
                        'menu_order'    => esc_html__('Menu order', 'ecotech'),
                        'price'         => esc_html__('Price: low to high', 'ecotech'),
                        'price-desc'    => esc_html__('Price: high to low', 'ecotech'),
                        'rating'        => esc_html__('Average Rating', 'ecotech'),
                        'popularity'    => esc_html__('Popularity', 'ecotech'),
                        'post__in'      => esc_html__('Post In', 'ecotech'),
                        'most-viewed'   => esc_html__('Most Viewed', 'ecotech'),
                    ),
                    'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.',
                        'ecotech'),
                        '<a href="'.esc_url('http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters').'" target="_blank">'.esc_html__('WordPress codex page',
                            'ecotech').'</a>'),
                ),
                array(
                    'id'          => 'order',
                    'type'        => 'select',
                    'title'       => esc_html__('Sort order', 'ecotech'),
                    'options'     => array(
                        ''     => esc_html__('None', 'ecotech'),
                        'DESC' => esc_html__('Descending', 'ecotech'),
                        'ASC'  => esc_html__('Ascending', 'ecotech'),
                    ),
                    'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.',
                        'ecotech'),
                        '<a href="'.esc_url('http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters').'" target="_blank">'.esc_html__('WordPress codex page',
                            'ecotech').'</a>'),
                ),
            ),
        );
    }
}