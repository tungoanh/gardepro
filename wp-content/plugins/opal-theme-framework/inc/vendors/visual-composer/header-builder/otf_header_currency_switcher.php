<?php
return array(
    "name"                    => esc_html__('OTF Currency Switcher', 'opal-theme-framework'),
    "base"                    => "otf_header_currency_switcher",
    "category"                => __("Header", "opal-theme-framework"),
    'show_settings_on_create' => false,
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/currency.svg',
    "php_class_name"          => 'WPBakeryShortCode_OTF_Base',
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