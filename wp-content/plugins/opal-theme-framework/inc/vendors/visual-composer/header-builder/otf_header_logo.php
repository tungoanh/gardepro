<?php
return array(
    "name"                    => __( "Header Logo", "opal-theme-framework" ),
    "base"                    => "otf_header_logo",
    "category"                => __( "Header", "opal-theme-framework" ),
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/logo.svg',
    'post_type'               => 'header',
    'params'                  => array(
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);