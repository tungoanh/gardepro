<?php
return array(
    "name"                    => __("OTF Brand", 'opal-theme-framework'),
    "base"                    => "otf_brand",
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/brand.svg',
    "category"                => 'Opal Theme',
    "description"             => esc_html__('Show Brand', 'opal-theme-framework'),
    "as_parent"               => array('only' => 'otf_brand_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"         => true,
    "show_settings_on_create" => false,
    "is_container"            => true,
    "php_class_name"          => 'WPBakeryShortCode_OTF_Container_Base',
    "js_view"                 => 'VcColumnView',
    "params"                  => array(
        array(
            'type'        => 'dropdown',
            'heading'     => __('Layout', 'opal-theme-framework'),
            'param_name'  => 'layout',
            'value'       => array(
                __('Grid', 'opal-theme-framework')     => 'grid',
                __('Carousel', 'opal-theme-framework') => 'carousel',
            ),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __('Columns', 'opal-theme-framework'),
            'value'       => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '6' => 6,
            ),
            'save_always' => true,
            'param_name'  => 'columns_grid',
            'std'         => 3,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array('grid'),
            ),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __('Columns', 'opal-theme-framework'),
            'value'       => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
            ),
            'save_always' => true,
            'param_name'  => 'columns',
            'std'         => 3,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array('carousel'),
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Carousel gutter', 'opal-theme-framework' ),
            'param_name' => 'margin',
            'value' => '10',
            'description' => __( 'Gutter(px) on item.', 'opal-theme-framework' ),
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array('carousel'),
            ),
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => __('Show Navigation', 'opal-theme-framework'),
            'save_always' => true,
            'param_name'  => 'show_nav',
            'std'         => true,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array('carousel'),
            ),
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => __('Show Dot', 'opal-theme-framework'),
            'save_always' => true,
            'param_name'  => 'show_dot',
            'std'         => true,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array('carousel'),
            ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'opal-theme-framework' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'opal-theme-framework' ),
        ),
    )
);