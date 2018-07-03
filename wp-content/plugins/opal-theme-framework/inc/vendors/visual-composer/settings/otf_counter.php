<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}

return array(
    "name"             => __("OTF Counter", 'opal-theme-framework'),
    "base"             => "otf_counter",
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/counter.svg',
    "description"      => esc_html__('Counter Number', 'opal-theme-framework'),
    "category"         => 'Opal Theme',
//    'front_enqueue_js' => array( get_theme_file_uri() . '/assets/js/libs/counter.js' ),
    "params"           => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__( "Style", 'opal-theme-framework' ),
            "param_name" => "style",
            'value'      => array(
                esc_html__( 'Center', 'opal-theme-framework' ) => 'default',
                esc_html__( 'Left', 'opal-theme-framework' ) => 'style-1',
                esc_html__( 'Right', 'opal-theme-framework' ) => 'style-2',
                esc_html__( 'Light', 'opal-theme-framework' ) => 'style-3',
            ),
            'std'        => 'default',
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Title", 'opal-theme-framework' ),
            "param_name" => "title",
            "value"      => '', "admin_label" => true,
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Sub Title", 'opal-theme-framework' ),
            "param_name" => "subtitle",
            "value"      => '',
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Number Counter", 'opal-theme-framework' ),
            "param_name" => "number",
            "value"      => '100',
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Speed", 'opal-theme-framework' ),
            "param_name" => "speed",
            "value"      => '2000',
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Extra class name", 'opal-theme-framework' ),
            "param_name"  => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework' ),
        ),

        //========================================================================================
        //========================================================================================
        //                              Icon Tab
        //========================================================================================
        //========================================================================================
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Icon library', 'opal-theme-framework' ),
            'value'       => array(
                __( 'None', 'opal-theme-framework' ) => '',
                __( 'Font Awesome', 'opal-theme-framework' ) => 'fontawesome',
                __( 'Open Iconic', 'opal-theme-framework' )  => 'openiconic',
                __( 'Typicons', 'opal-theme-framework' )     => 'typicons',
                __( 'Entypo', 'opal-theme-framework' )       => 'entypo',
                __( 'Linecons', 'opal-theme-framework' )     => 'linecons',
                __( 'Mono Social', 'opal-theme-framework' )  => 'monosocial',
                __( 'Material', 'opal-theme-framework' )     => 'material',
                __( 'Custom Image', 'opal-theme-framework' ) => 'custom',
            ),
            'admin_label' => true,
            'param_name'  => 'type',
            'description' => __( 'Select icon library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __( 'Icon', 'opal-theme-framework' ),
            'param_name'  => 'icon_fontawesome',
            'value'       => 'fa fa-adjust',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __( 'Icon', 'opal-theme-framework' ),
            'param_name'  => 'icon_openiconic',
            'value'       => 'vc-oi vc-oi-dial',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'type'         => 'openiconic',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __( 'Icon', 'opal-theme-framework' ),
            'param_name'  => 'icon_typicons',
            'value'       => 'typcn typcn-adjust-brightness',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'type'         => 'typicons',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'       => 'iconpicker',
            'heading'    => __( 'Icon', 'opal-theme-framework' ),
            'param_name' => 'icon_entypo',
            'value'      => 'entypo-icon entypo-icon-note',
            // default value to backend editor admin_label
            'settings'   => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'type'         => 'entypo',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value'   => 'entypo',
            ),
            'group'      => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __( 'Icon', 'opal-theme-framework' ),
            'param_name'  => 'icon_linecons',
            'value'       => 'vc_li vc_li-heart',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'type'         => 'linecons',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __( 'Icon', 'opal-theme-framework' ),
            'param_name'  => 'icon_monosocial',
            'value'       => 'vc-mono vc-mono-fivehundredpx',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'type'         => 'monosocial',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __( 'Icon', 'opal-theme-framework' ),
            'param_name'  => 'icon_material',
            'value'       => 'vc-material vc-material-cake',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an "EMPTY" icon?
                'type'         => 'material',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'material',
            ),
            'description' => __( 'Select icon from library.', 'opal-theme-framework' ),
            'group'       => __( 'Icons', 'opal-theme-framework' ),
        ),
        array(
            "type"       => "attach_image",
            "heading"    => esc_html__( "Photo", 'opal-theme-framework' ),
            "param_name" => "photo",
            "value"      => '',
            'group'      => __( 'Icons', 'opal-theme-framework' ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'custom',
            ),
        ),
    ),
);