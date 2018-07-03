<?php
return array(
    "name"                    => __( "Wishlist", "opal-theme-framework" ),
    "base"                    => "otf_header_wishlist",
    "category"                => __( "Header", "opal-theme-framework" ),
    'show_settings_on_create' => false,
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/wishlist.svg',
    'post_type'               => 'header',
    'params'                  => array(
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
        ),
    ),
);