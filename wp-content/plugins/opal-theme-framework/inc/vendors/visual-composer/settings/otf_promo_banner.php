<?php
return array(
    "name"                    => __("OTF Promo Banner", 'opal-theme-framework'),
    "base"                    => "otf_promo_banner",
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/promo-banner.svg',
    "class"                   => "",
    "description"             => esc_html__('Promo Banner', 'opal-theme-framework'),
    "category"                => 'Opal Theme',
    "as_parent"               => array('only' => 'vc_btn,vc_custom_heading,vc_column_text,vc_empty_space,single_img,vc_wp_custommenu'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"         => true,
    "show_settings_on_create" => true,
    "is_container"            => true,
    "php_class_name"          => 'WPBakeryShortCode_OTF_Container_Base',
    "js_view"                 => 'VcColumnView',
    "params"                  => array(
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
            'dependency' => array(
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
            "type"       => "dropdown",
            "heading"    => esc_html__("Display", 'opal-theme-framework'),
            "param_name" => "display",
            'value'      => array(
                esc_html__('Full', 'opal-theme-framework')      => 'd-block',
                esc_html__('Inline', 'opal-theme-framework')   => 'd-inline-block',
            ),
            'std'        => 'd-block',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Align Wapper", 'opal-theme-framework'),
            "param_name" => "align",
            'value'      => array(
                esc_html__('None', 'opal-theme-framework')      => '',
                esc_html__('Left', 'opal-theme-framework')      => 'pull-left',
                esc_html__('Right', 'opal-theme-framework')   => 'pull-right',
            ),
            'std'        => '',
            'dependency'  => array(
                'element' => 'display',
                'value'   => 'd-inline-block'
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Horizontal Align Content", 'opal-theme-framework'),
            "param_name" => "h_align",
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')   => 'text-left',
                esc_html__('Center', 'opal-theme-framework') => 'text-center',
                esc_html__('Right', 'opal-theme-framework')  => 'text-right',
            ),
            'std'        => 'text-left',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Vertical Align Content", 'opal-theme-framework'),
            "param_name" => "v_align",
            'value'      => array(
                esc_html__('Top', 'opal-theme-framework')      => 'justify-content-start',
                esc_html__('Middle', 'opal-theme-framework')   => 'justify-content-center',
                esc_html__('Bottom', 'opal-theme-framework')   => 'justify-content-end',
                esc_html__('Out side', 'opal-theme-framework') => 'outside-style',
            ),
            'std'        => 'justify-content-start',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Schema Color", 'opal-theme-framework'),
            "param_name" => "color",
            'value'      => array(
                esc_html__('Dark', 'opal-theme-framework')  => 'color-schema-dark',
                esc_html__('Light', 'opal-theme-framework') => 'color-schema-light',
            ),
            'std'        => 'color-schema-dark',
        ),
        array(
            "type"        => "dropdown",
            "heading"     => esc_html__( "Hover Effect", 'opal-theme-framework' ),
            "param_name"  => "effect_outside",
            'value'      => array(
                esc_html__( 'Zoom image', 'opal-theme-framework' ) => '',
                esc_html__( 'Animate image', 'opal-theme-framework' ) => 'effect-2',
                esc_html__( 'Shine', 'opal-theme-framework' ) => 'effect-3',
                esc_html__( 'Show content', 'opal-theme-framework' ) => 'effect-4',

            ),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'opal-theme-framework' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'opal-theme-framework' ),
        ),
    ),
);