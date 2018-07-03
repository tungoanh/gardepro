<?php
return array(
    "name"      => __("Header Search Button", "opal-theme-framework"),
    "base"      => "otf_header_search_button",
    "category"  => __("Header", "opal-theme-framework"),
    'icon'      => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/search-button.svg',
    'post_type' => 'header',
    "params"    => array(
        array(
            "type"       => "dropdown",
            "heading"    => __("Skin", "opal-theme-framework"),
            "param_name" => "skin",
            'value'      => array(
                esc_html__('Default', 'opal-theme-framework')       => '',
                esc_html__('Top to bottom', 'opal-theme-framework') => 'top-to-bottom',
                esc_html__('Bottom to top', 'opal-theme-framework') => 'bottom-to-top',
                esc_html__('Popup', 'opal-theme-framework')         => 'popup',
            ),

        ),
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);