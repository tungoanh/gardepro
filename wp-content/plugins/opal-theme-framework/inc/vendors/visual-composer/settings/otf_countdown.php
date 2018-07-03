<?php
if (!defined('ABSPATH')) {
    die('-1');
}
return array(
    "name"        => esc_html__("OTF Countdown", 'opal-theme-framework'),
    "base"        => "otf_countdown",
    'icon'        => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/countdown.svg',
    "description" => esc_html__('Display countdown', 'opal-theme-framework'),
    "category"    => 'Opal Theme',
    "params"      => array(
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Target Time For Countdown', 'opal-theme-framework'),
            'param_name'  => 'datetime',
            'description' => esc_html__('Date and time format (yyyy/mm/dd hh:mm:ss).', 'opal-theme-framework'),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
                esc_html__('Style 3', 'opal-theme-framework') => 'style-3',
                esc_html__('Style 4', 'opal-theme-framework') => 'style-4',
                esc_html__('Style 5', 'opal-theme-framework') => 'style-5',
            ),
            'std'        => 'style-1',
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
            "type"        => "textfield",
            "heading"     => esc_html__("Text Button", 'opal-theme-framework'),
            "param_name"  => "text_button",
            "std"         => 'Click here',
            "value"       => '',
            "admin_label" => true,
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__('Button Link', 'opal-theme-framework'),
            'param_name'  => 'btn_link',
            'description' => esc_html__('Enter link used as button of bar.', 'opal-theme-framework'),
            'value'       => '#',
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
    ),
);