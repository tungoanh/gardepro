<?php
return array(
    "name"           => __("Brand Item", 'opal-theme-framework'),
    "base"           => "otf_brand_item",
    'icon'           => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/brand-item.svg',
    "category"       => 'Opal Theme',
    "as_child"       => array('only' => 'otf_brand'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "php_class_name" => 'WPBakeryShortCode_OTF_Base',
    "params"         => array(
        array(
            'type'       => 'textfield',
            'heading'    => __('Title', 'opal-theme-framework'),
            'param_name' => 'title',
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
            "heading"     => esc_html__("avatar", 'opal-theme-framework'),
            "param_name"  => "photo",
            'description' => esc_html__('Select your avatar.', 'opal-theme-framework'),
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
            'type'       => 'textfield',
            'heading'    => __('Link', 'opal-theme-framework'),
            'param_name' => 'link',
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'opal-theme-framework' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'opal-theme-framework' ),
        )
    )
);