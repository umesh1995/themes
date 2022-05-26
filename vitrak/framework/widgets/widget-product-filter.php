<?php
/**
 *
 * Ecotech Product Filter
 *
 */
if ( !class_exists( 'Ovic_Product_Filter_Widget' ) && class_exists( 'OVIC_Widget' ) ) {
    class Ovic_Product_Filter_Widget extends OVIC_Widget
    {
        public $attributes;

        function __construct()
        {
            global $wpdb;

            $attribute_array = array();
            $attributes      = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
            if ( !empty( $attributes ) ) {
                foreach ( $attributes as $attribute ) {
                    $attribute_array[ intval( $attribute->attribute_id ) ]  = $attribute->attribute_label;
                    $this->attributes[ intval( $attribute->attribute_id ) ] = $attribute;
                }
            }
            $this->widget_cssclass    = 'ovic-product-filter';
            $this->widget_description = esc_html__( 'Display the customer Product Filter.', 'ecotech' );
            $this->widget_id          = 'ovic_product_filter';
            $this->widget_name        = esc_html__( 'Ovic: Product Filter', 'ecotech' );
            $this->settings           = array(
                'title'            => array(
                    'type'  => 'text',
                    'title' => esc_html__( 'Title', 'ecotech' ),
                ),
                'choose_attribute' => array(
                    'type'     => 'select',
                    'chosen'   => true,
                    'multiple' => true,
                    'options'  => $attribute_array,
                    'title'    => esc_html__( 'Product attribute:', 'ecotech' ),
                ),
            );

            parent::__construct();
        }

        function widget( $args, $instance )
        {
            $price_title    = esc_html__( 'PRICE', 'ecotech' );
            $category_title = esc_html__( 'CATEGORIES', 'ecotech' );

            $this->widget_start( $args, $instance );
            ?>
            <div class="filter-content">
                <?php
                the_widget( 'WC_Widget_Product_Categories',
                    array(
                        'title'   => $category_title,
                        'count'   => 1,
                        'orderby' => 'order',
                    )
                );
                the_widget( 'WC_Widget_Price_Filter',
                    array(
                        'title' => $price_title,
                    )
                );
                if ( !empty( $instance[ 'choose_attribute' ] ) ) {
                    foreach ( $instance[ 'choose_attribute' ] as $value ) {
                        if ( !empty( $this->attributes[ $value ] ) ) {
                            $attribute = $this->attributes[ $value ];
                            if ( $attribute->attribute_type == 'color' || $attribute->attribute_type == 'image' ) {
                                $display_type = $attribute->attribute_type !== 'select' ? 'box' : 'select';
                            } else {
                                $display_type = $attribute->attribute_type !== 'select' ? 'list' : 'select';
                            }
                            the_widget( 'Ovic_Attribute_Product_Widget',
                                array(
                                    'title'        => $attribute->attribute_label,
                                    'attribute'    => $attribute->attribute_name,
                                    'query_type'   => 'AND',
                                    'display_type' => $display_type,
                                )
                            );
                        }
                    }
                }
                ?>
            </div>
            <?php
            $this->widget_end( $args );
        }
    }

    /**
     * Register Widgets.
     *
     * @since 2.3.0
     */
    add_action( 'widgets_init',
        function () {
            ovic_install_widget( 'Ovic_Product_Filter_Widget' );
        }
    );
}