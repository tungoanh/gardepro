<?php
return array(
    "name"                    => __("Header Cart", "opal-theme-framework"),
    "base"                    => "otf_header_cart",
    "category"                => __("Header", "opal-theme-framework"),
    'show_settings_on_create' => false,
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/cart.svg',
    'post_type'               => 'header',
    'params'                  => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
            ),
            'std'        => 'style-1',
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Dropdown Alignment", 'opal-theme-framework'),
            "param_name" => "alignment",
            'value' => array(
                esc_html__('Left', 'opal-theme-framework') => 'left',
                esc_html__('Right', 'opal-theme-framework') => 'right',
                esc_html__('Justify', 'opal-theme-framework') => 'justify',
            ),
            "std" => 'left',
        ),
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);