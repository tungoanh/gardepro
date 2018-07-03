<?php
return array(
    "name"                    => __("Header Search Form", "opal-theme-framework"),
    "base"                    => "otf_header_search",
    "category"                => __("Header", "opal-theme-framework"),
    'show_settings_on_create' => false,
    'post_type'               => 'header',
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/search.svg',
    'params'                  => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('Default', 'opal-theme-framework') => 'opal-style-default',
                esc_html__('Style 1', 'opal-theme-framework') => 'opal-style-1',
            ),
            "std"        => '',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Button color", 'opal-theme-framework'),
            "param_name" => "button_color",
            'value'      => array(
                esc_html__('Primary', 'opal-theme-framework')   => 'primary',
                esc_html__('Secondary', 'opal-theme-framework') => 'secondary',
            ),
            "std"        => 'primary',
            'dependency' => array(
                'element' => 'style',
                'value'   => 'opal-style-default'
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Border wapper", 'opal-theme-framework'),
            "param_name" => "border_color",
            'value'      => array(
                esc_html__('Primary', 'opal-theme-framework')   => 'primary',
                esc_html__('Secondary', 'opal-theme-framework') => 'secondary',
                esc_html__('None', 'opal-theme-framework')      => 'none',
            ),
            "std"        => 'primary',
            'dependency' => array(
                'element' => 'style',
                'value'   => 'opal-style-default'
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Extra class name', 'opal-theme-framework'),
            'param_name'  => 'el_class',
            'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);