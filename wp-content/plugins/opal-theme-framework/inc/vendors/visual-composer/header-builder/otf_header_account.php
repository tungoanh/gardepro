<?php
return array(
    "name" => __("Header Account", "opal-theme-framework"),
    "base" => "otf_header_account",
    "category" => __("Header", "opal-theme-framework"),
    'show_settings_on_create' => false,
    'icon' => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/account.svg',
    'post_type' => 'header',
    'params' => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value' => array(
                esc_html__('Style Label', 'opal-theme-framework') => 'menu',
                esc_html__('Style Icon', 'opal-theme-framework') => 'icon',
                esc_html__('Style Both', 'opal-theme-framework') => 'both',

            ),
            'std' => 'menu',
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
            'type' => 'css_editor',
            'heading' => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group' => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);