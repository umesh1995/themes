<?php
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Add_To_Cart"
 * @version 1.0.0
 */
class Shortcode_Ovic_Add_To_Cart extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode      = 'ovic_add_to_cart';
    public $is_woocommerce = true;
}