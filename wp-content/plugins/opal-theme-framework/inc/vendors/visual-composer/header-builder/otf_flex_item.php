<?php
return array(
    "name"                    => esc_html__('OTF Flex Item', 'opal-theme-framework'),
    "base"                    => "otf_flex_item",
    "category"                => __("Header", "opal-theme-framework"),
    'show_settings_on_create' => false,
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/flex-item.svg',
    "php_class_name"          => 'WPBakeryShortCode_OTF_Base',
    'post_type'               => 'header',
);