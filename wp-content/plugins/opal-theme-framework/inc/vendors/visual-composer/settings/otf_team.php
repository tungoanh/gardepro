<?php
return array(
    "name" => __("OTF Team", 'opal-theme-framework'),
    "base" => "otf_team",
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/team.svg',
    "category" => 'Opal Theme',
    "description"    => esc_html__( 'Show Team', 'opal-theme-framework' ),
    "as_parent"               => array('only' => 'otf_team_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "as_child"                => array('except' => 'vc_column_inner'),
    "content_element"         => true,
    "show_settings_on_create" => false,
    "is_container"            => true,
    "php_class_name"          => 'WPBakeryShortCode_OTF_Container_Base',
    "js_view"                 => 'VcColumnView',
    "params" => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
                esc_html__('Style 3', 'opal-theme-framework') => 'style-3',
                esc_html__('Style 4', 'opal-theme-framework') => 'style-4',
            ),
            'std'        => 'style-1',
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'opal-theme-framework' ),
            'param_name' => 'layout',
            'value' => array(
                __( 'Grid', 'opal-theme-framework' ) => 'grid',
                __( 'Carousel', 'opal-theme-framework' ) => 'carousel',
            ),
            'save_always' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Columns', 'opal-theme-framework' ),
            'value' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '6' => 6,
            ),
            'save_always' => true,
            'param_name' => 'columns_grid',
            'std' => 3,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array( 'grid' ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Columns', 'opal-theme-framework' ),
            'value' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
            ),
            'save_always' => true,
            'param_name' => 'columns',
            'std' => 3,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array( 'carousel' ),
            ),
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => __( 'Show Navigation', 'opal-theme-framework' ),
            'save_always' => true,
            'param_name'  => 'show_nav',
            'std'         => true,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array( 'carousel' ),
            ),
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => __( 'Show Dot', 'opal-theme-framework' ),
            'save_always' => true,
            'param_name'  => 'show_dot',
            'std'         => true,
            'dependency'  => array(
                'element' => 'layout',
                'value'   => array( 'carousel' ),
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => __('Extra class name', 'opal-theme-framework'),
            'param_name'  => 'el_class',
            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'opal-theme-framework'),
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'opal-theme-framework' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'opal-theme-framework' ),
        ),
    )
);