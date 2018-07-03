<?php
return array(
    "name"        => __("OTF Product Banner", 'opal-theme-framework'),
    "base"        => "otf_product_banner",
    'icon'        => 'icon-wpb-woocommerce',
    "description" => esc_html__('Product Banner', 'opal-theme-framework'),
    "category"    => 'WooCommerce',
    "params"      => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
                esc_html__('Style 3', 'opal-theme-framework') => 'style-3',
            ),
            'std'        => 'style-1',
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => __('Select identificator', 'opal-theme-framework'),
            'param_name'  => 'id',
            'description' => __('Input product ID or product SKU or product title to see suggestions', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Image source', 'opal-theme-framework'),
            'param_name'  => 'select_image_source',
            'description' => esc_html__('Select Image source', 'opal-theme-framework'),
            'value'       => array(
                esc_html__('Media Library', 'opal-theme-framework') => 'library',
                esc_html__('External link', 'opal-theme-framework') => 'external',
            ),
            'std'         => 'library',
        ),
        array(
            "type"        => "attach_image",
            "heading"     => esc_html__("Photo", 'opal-theme-framework'),
            "param_name"  => "photo",
            'description' => esc_html__('Select your image used as product banner.', 'opal-theme-framework'),
            "value"       => '',
            'dependency'  => array(
                'element' => 'select_image_source',
                'value'   => 'library'
            ),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('External link', 'opal-theme-framework'),
            'param_name' => 'external_link_photo',
            'dependency' => array(
                'element' => 'select_image_source',
                'value'   => 'external'
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Image size', 'opal-theme-framework'),
            'param_name'  => 'image_size',
            'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),

        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('Text button', 'opal-theme-framework'),
            'param_name' => 'text_button',
            'group' => 'Description'
        ),
        array(
            'type'       => 'textarea_html',
            'heading'    => __('Description', 'opal-theme-framework'),
            'param_name' => 'content',
            "value"      => '<p>write any text and make custom design that you want to show.</p>',
            'group' => 'Description'
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);