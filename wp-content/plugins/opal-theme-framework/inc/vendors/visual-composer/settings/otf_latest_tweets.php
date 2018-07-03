<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}

return array(
    "name"           => __("OTF Latest Tweets", 'opal-theme-framework'),
    "base"           => "otf_latest_tweets",
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/twitter.svg',
    "description"    => esc_html__('Display latest tweets', 'opal-theme-framework'),
    "category"       => 'Opal Theme',
    "params"         => array(
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Twitter Username", 'opal-theme-framework'),
            "param_name"  => "username",
            "value"       => '',
            "std"         => 'opalwordpress',
            "description" => esc_html__('Please enter your Username Twitter, ex: opalwordpress', 'opal-theme-framework'),
            "admin_label" => true,
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Limit", 'opal-theme-framework'),
            "param_name" => "number",
            "value"      => '',
            "std"        => 2
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Height", 'opal-theme-framework'),
            "param_name" => "height",
            "value"      => '',
            "std"        => 200
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Width", 'opal-theme-framework'),
            "param_name" => "width",
            "value"      => '',
            "std"        => 180
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__( "Style", 'opal-theme-framework' ),
            "param_name" => "style",
            'value'      => array(
                esc_html__( 'Light', 'opal-theme-framework' ) => 'light',
                esc_html__( 'Drak', 'opal-theme-framework' ) => 'drak',
            ),
            'std'        => 'light',
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
    ),
);