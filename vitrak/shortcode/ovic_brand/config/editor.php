<?php

class Editor_Ovic_Brand
{
    public static function shortcode_config()
    {
        return array(
            'name'   => 'ovic_brand',
            'title'  => 'Brand',
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
                    'id'      => 'style',
                    'type'    => 'text',
                    'default' => 'style-02',
                    'class'   => 'ovic-hidden',
                ),
                array(
                    'id'          => 'slide_item',
                    'type'        => 'number',
                    'unit'        => 'items(s)',
                    'default'     => '6',
                    'title'       => esc_html__('slidesToShow', 'ecotech'),
                    'description' => esc_html__('How much items per page to show', 'ecotech'),
                ),
                array(
                    'id'          => 'brands',
                    'type'        => 'select',
                    'chosen'      => true,
                    'multiple'    => true,
                    'options'     => 'categories',
                    'placeholder' => esc_html__('Select Products Brand', 'ecotech'),
                    'query_args'  => array(
                        'data-slug'  => true,
                        'hide_empty' => false,
                        'taxonomy'   => 'product_brand',
                    ),
                    'title'       => esc_html__('Product Brand', 'ecotech'),
                ),
            ),
        );
    }
}