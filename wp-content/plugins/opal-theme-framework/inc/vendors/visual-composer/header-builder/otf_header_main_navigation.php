<?php
return array(
    "base"     => "otf_header_main_navigation",
    "name"     => __("Main navigation", "opal-theme-framework"),
    'icon'     => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/navigation.svg',
    "category" => __("Header", "opal-theme-framework"),
    'post_type'               => 'header',
    "params"   => array(
        array(
            "type"       => "dropdown",
            "heading"    => __("Display", "opal-theme-framework"),
            "param_name" => "display",
            'value'      => array(
                esc_html__('Inline', 'opal-theme-framework') => 'inline',
                esc_html__('Full', 'opal-theme-framework')   => 'full',
            ),
            'std'        => 'inline',

        ),
        array(
            "type"       => "dropdown",
            "heading"    => __("Position", "opal-theme-framework"),
            "param_name" => "align",
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')   => 'left',
                esc_html__('Right', 'opal-theme-framework')  => 'right',
                esc_html__('Center', 'opal-theme-framework') => 'center',
            ),
            'std'        => 'left',
            'dependency' => array(
                'element' => 'display',
                'value'   => array('full'),
            ),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => __("Enable Logo Center", "opal-theme-framework"),
            "param_name" => "logo",
            'std'        => 'false',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => __("Skin", "opal-theme-framework"),
            "param_name" => "skin",
            'value'      => array(
                esc_html__('Default', 'opal-theme-framework') => '',
                esc_html__('Dark', 'opal-theme-framework')    => 'dark',
            ),
            'std'        => '',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => __("Enable Smooth Menu", "opal-theme-framework"),
            "param_name" => "smooth_menu",
            'std'        => 'false',
        ),
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);