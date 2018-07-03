<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}

return array(
    "name"           => esc_html__("OTF Product parallax", 'opal-theme-framework'),
    "base"           => "otf_product_parallax",
    "class"          => "",
    "description"    => esc_html__('Display products paralax', 'opal-theme-framework'),
    //'front_enqueue_js' => array( get_theme_file_uri( '/assets/js/libs/parallax.js' ) ),
    "category"       => 'WooCommerce',
    "params"         => array(
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Select identificator', 'opal-theme-framework' ),
            'param_name' => 'id',
            'description' => __( 'Input product ID or product SKU or product title to see suggestions', 'opal-theme-framework' ),
        ),
        array(
            'type' => 'hidden',
            // This will not show on render, but will be used when defining value for autocomplete
            'param_name' => 'sku',
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Product Display Name', 'opal-theme-framework'),
            'param_name' => 'product_name',
        ),
        array(
            "type"        => "attach_image",
            "heading"     => esc_html__("Thumbnail Product", 'opal-theme-framework'),
            'description' => esc_html__('Upload main image for parallax', 'opal-theme-framework'),
            "param_name"  => "product_image",
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Duration", 'opal-theme-framework'),
            'description' => esc_html__('Fill duration for main image parallax. Min = 0 and max= 1, Ex: 0.5', 'opal-theme-framework'),
            "param_name"  => "main_duration",
            "std"         => '0.5',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Enable Reverse ", 'opal-theme-framework' ),
            "param_name" => "enable_reverse",
            'value'      => array(
                esc_html__( 'Yes', 'opal-theme-framework' ) => true,
            ),
            'std'        => true,
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textarea_html',
            'heading'    => esc_html__('Background Content', 'opal-theme-framework'),
            'param_name' => 'content',
            'value'      => esc_html__('', 'opal-theme-framework'),
            'group'      => __('Background', 'opal-theme-framework'),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Duration", 'opal-theme-framework'),
            'description' => esc_html__('Fill duration for main image parallax. Min = 0 and max= 1, Ex: 0.5', 'opal-theme-framework'),
            "param_name"  => "bg_duration",
            "std"         => '0.5',
            'group'      => __('Background', 'opal-theme-framework'),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Enable Reverse ", 'opal-theme-framework' ),
            "param_name" => "bg_enable_reverse",
            'value'      => array(
                esc_html__( 'Yes', 'opal-theme-framework' ) => true,
            ),
            'std'        => true,
            'group'      => __('Background', 'opal-theme-framework'),
        ),
    ),
);