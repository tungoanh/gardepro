<?php
return array(
    "name"                    => __( "Main navigation button", "opal-theme-framework" ),
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/menu-button.svg',
    "base"                    => "otf_header_navigation_button",
    "category"                => __( "Header", "opal-theme-framework" ),
    'show_settings_on_create' => false,
    'post_type'               => 'header',
    'params'                  => array(
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
        ),
    ),
);