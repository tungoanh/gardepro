<?php
if (!defined('ABSPATH')) {
    die('-1');
}

return array(
    "name"        => esc_html__("OTF Product Deals", 'opal-theme-framework'),
    "base"        => "otf_product_deal",
    "description" => esc_html__('Display products deal', 'opal-theme-framework'),
    'icon'        => 'icon-wpb-woocommerce',
//    'front_enqueue_js' => array(get_theme_file_uri() . '/assets/js/libs/counter.js'),
    "category"    => 'WooCommerce',
    "params"      => array(
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Per page", 'opal-theme-framework'),
            'description' => esc_html__('The "per_page" shortcode determines how many products to show on the page', 'opal-theme-framework'),
            "param_name"  => "per_page",
            'std'         => 4
        ),
        array(
            "type"        => "dropdown",
            "heading"     => esc_html__("Columns", 'opal-theme-framework'),
            'description' => esc_html__('The columns attribute controls how many columns wide the products should be before wrapping.', 'opal-theme-framework'),
            "param_name"  => "columns",
            'value'       => array(1, 2, 3, 4, 5, 6),
            'std'         => 2,
        ),
        array(
            "type"        => "dropdown",
            "heading"     => esc_html__("Layout", 'opal-theme-framework'),
            'description' => esc_html__('Select layout to show product deal', 'opal-theme-framework'),
            "param_name"  => "style",
            'value'       => array(
                esc_html__('Grid', 'opal-theme-framework')     => 'grid',
                esc_html__('List', 'opal-theme-framework')     => 'list',
                esc_html__('Carousel', 'opal-theme-framework') => 'carousel',
            ),
            "std"         => 'grid',
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => __('Show Rating', 'opal-theme-framework'),
            'param_name' => 'show_rating',
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => false,
            'dependency' => array(
                'element' => 'style',
                'value'   => array('list'),
            ),
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => __('Show Category', 'opal-theme-framework'),
            'param_name' => 'show_category',
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => true,
            'dependency' => array(
                'element' => 'style',
                'value'   => array('list'),
            ),
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => __('Show Short Description', 'opal-theme-framework'),
            'param_name' => 'show_except',
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => false,
            'dependency' => array(
                'element' => 'style',
                'value'   => array('list'),
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Image size', 'opal-theme-framework'),
            'param_name'  => 'image_size',
            'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
            'dependency'  => array(
                'element' => 'style',
                'value'   => array('list'),
            ),
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => __('Show Navigation', 'opal-theme-framework'),
            'param_name' => 'show_nav',
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => 'true',
            ),
            'std'        => false,
            'dependency' => array(
                'element' => 'style',
                'value'   => array('carousel'),
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Navigation Position", 'opal-theme-framework'),
            "param_name" => "nav_position",
            'value'      => array(
                esc_html__('Top - Center', 'opal-theme-framework')    => 'top-center',
                esc_html__('Top - Right', 'opal-theme-framework')     => 'top-right',
                esc_html__('Middle - Center', 'opal-theme-framework') => 'middle-center',
                esc_html__('Bottom - Center', 'opal-theme-framework') => 'bottom-center',
            ),
            'std'        => 'middle-center',
            'dependency' => array(
                'element' => 'show_nav',
                'value'   => array('true'),
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Navigation Style", 'opal-theme-framework'),
            "param_name" => "nav_style",
            'value'      => array(
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
            ),
            'std'        => 'style-1',
            'dependency' => array(
                'element' => 'show_nav',
                'value'   => array('true'),
            ),
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => __('Show Dot', 'opal-theme-framework'),
            'param_name' => 'show_dot',
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => 'true',
            ),
            'std'        => false,
            'dependency' => array(
                'element' => 'style',
                'value'   => array('carousel'),
            ),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
    ),
);