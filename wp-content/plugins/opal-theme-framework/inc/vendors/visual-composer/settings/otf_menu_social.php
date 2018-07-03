<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}

return array(
    'name'                    => esc_html__( 'OTF Menu Social', 'opal-theme-framework' ),
    'base'                    => 'otf_menu_social',
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/social.svg',
    'description'             => esc_html__( 'Show Menu Social with image and content', 'opal-theme-framework' ),
    'category'                => 'Opal Theme',
    'show_settings_on_create' => false,
    "params"         => array(
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Title", 'opal-theme-framework'),
            "param_name"  => "title",
            "std"         => esc_html__('Connect with us: ', 'opal-theme-framework'),
            "value"       => '',
            "admin_label" => true,
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Shape", 'opal-theme-framework'),
            "param_name" => "shape",
            "description" => esc_html__("Select social shape.", 'opal-theme-framework'),
            'value'      => array(
                esc_html__('Default', 'opal-theme-framework') => 'default',
                esc_html__('Square', 'opal-theme-framework') => 'square',
                esc_html__('Round', 'opal-theme-framework') => 'round',
                esc_html__('Outline Square', 'opal-theme-framework') => 'o-square',
                esc_html__('Outline Round', 'opal-theme-framework') => 'o-round',
                esc_html__('Border', 'opal-theme-framework') => 's-border',
            ),
            'std'        => 'square',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Color", 'opal-theme-framework'),
            "param_name" => "color",
            "description" => esc_html__("Select social items color.", 'opal-theme-framework'),
            'value'      => array(
                esc_html__('Default', 'opal-theme-framework') => 'default',
                esc_html__('Color icons', 'opal-theme-framework') => 'color-icons',
                esc_html__('Color background icons', 'opal-theme-framework') => 'color-background-icons',

            ),
            'std'        => 'default',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Alignment", 'opal-theme-framework'),
            "param_name" => "align",
            "description" => esc_html__("Select social alignment", 'opal-theme-framework'),
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework') => 'text-left',
                esc_html__('Center', 'opal-theme-framework') => 'text-center',
                esc_html__('Right', 'opal-theme-framework') => 'text-right',
            ),
            'std'        => 'text-left',
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
    )
);