<?php
return array(
    "name"        => __("OTF Product Category Banner", 'opal-theme-framework'),
    "base"        => "otf_product_category_banner",
    'icon'        => 'icon-wpb-woocommerce',
    "description" => esc_html__('Product Category Banner', 'opal-theme-framework'),
    "category"    => 'WooCommerce',
    "params"      => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('default', 'opal-theme-framework') => 'default',
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
                esc_html__('Style 3', 'opal-theme-framework') => 'style-3',
                esc_html__('Style 4', 'opal-theme-framework') => 'style-4',
                esc_html__('Style 5', 'opal-theme-framework') => 'style-5',
            ),
            'std'        => 'default',
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => __('Select identificator', 'opal-theme-framework'),
            'param_name'  => 'category',
            'description' => __('Input Category or product title to see suggestions', 'opal-theme-framework'),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Horizontal Align", 'opal-theme-framework'),
            "param_name" => "h_align",
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')   => '',
                esc_html__('Center', 'opal-theme-framework') => 'text-center',
                esc_html__('Right', 'opal-theme-framework')  => 'text-right',
            ),
            'std'        => '',
            'dependency' => array(
                'element' => 'style',
                'value'   => array(
                    'default',
                    'style-1',
                    'style-4'
                ),
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Vertical Align", 'opal-theme-framework'),
            "param_name" => "v_align",
            'value'      => array(
                esc_html__('Top', 'opal-theme-framework')      => 'justify-content-start',
                esc_html__('Middle', 'opal-theme-framework')   => 'justify-content-center',
                esc_html__('Bottom', 'opal-theme-framework')   => 'justify-content-end',
                esc_html__('Out side', 'opal-theme-framework') => 'outside-style',
            ),
            'std'        => '',
            'dependency' => array(
                'element' => 'style',
                'value'   => array(
                    'default',
                    'style-1',
                    'style-4'
                ),
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Hover Effect", 'opal-theme-framework'),
            "param_name" => "effect_inside",
            'value'      => array(
                esc_html__('Zoom image', 'opal-theme-framework')               => '',
                esc_html__('Text animate from bottom', 'opal-theme-framework') => 'effect-1',
                esc_html__('Animate image', 'opal-theme-framework')            => 'effect-2',
                esc_html__('Shine', 'opal-theme-framework')                    => 'effect-3',
            ),
            'dependency' => array(
                'element' => 'v_align',
                'value'   => array('justify-content-start', 'justify-content-center', 'justify-content-end'),
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Hover Effect", 'opal-theme-framework'),
            "param_name" => "effect_outside",
            'value'      => array(
                esc_html__('Zoom image', 'opal-theme-framework')    => '',
                esc_html__('Animate image', 'opal-theme-framework') => 'effect-2',
                esc_html__('Shine', 'opal-theme-framework')         => 'effect-3',

            ),
            'dependency' => array(
                'element' => 'v_align',
                'value'   => 'outside-style',
            ),
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => esc_html__('Disable subtitle', 'opal-theme-framework'),
            'param_name' => 'disable_subtitle',
            'std'        => 'false',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Schema Color", 'opal-theme-framework'),
            "param_name" => "color",
            'value'      => array(
                esc_html__('Dark', 'opal-theme-framework')  => 'color-schema-dark',
                esc_html__('Light', 'opal-theme-framework') => 'color-schema-light',
            ),
            'std'        => '',
            'dependency' => array(
                'element' => 'style',
                'value'   => array(
                    'default',
                    'style-1',
                    'style-4'
                ),
            ),
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
            'description' => esc_html__('Select your image used as promo banner.', 'opal-theme-framework'),
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