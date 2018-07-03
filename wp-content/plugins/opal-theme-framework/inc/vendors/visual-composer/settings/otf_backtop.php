<?php
if (!defined('ABSPATH')) {
    die('-1');
}

return array(
    "name"        => __("OTF Back to top", 'opal-theme-framework'),
    "base"        => "otf_backtop",
    "class"       => "",
    "description" => esc_html__('Back top top', 'opal-theme-framework'),
    "category"    => 'Opal Theme',
    'icon'        => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/back-to-top.svg',
    "params"      => array(
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Title", 'opal-theme-framework'),
            "param_name" => "title",
            "value"      => '', "admin_label" => true,
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
    ),

);