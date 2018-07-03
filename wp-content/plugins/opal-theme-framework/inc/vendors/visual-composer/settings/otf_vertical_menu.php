<?php
return
    array(
        "name"     => esc_html__("OTF Vertical MegaMenu", 'opal-theme-framework'),
        "base"     => "otf_vertical_menu",
        'icon'     => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/vertical-menu.svg',
        "category" => esc_html__('Opal Theme', 'opal-theme-framework'),
        "params"   =>
            array(
                array(
                    "type"        => "textfield",
                    "heading"     => esc_html__("Title", 'opal-theme-framework'),
                    "param_name"  => "title",
                    "value"       => 'Vertical Menu',
                    "admin_label" => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Icon before Title', 'opal-theme-framework'),
                    'value'       => array(
                        __('None', 'opal-theme-framework')         => '',
                        __('Font Awesome', 'opal-theme-framework') => 'fontawesome',
                        __('Open Iconic', 'opal-theme-framework')  => 'openiconic',
                        __('Typicons', 'opal-theme-framework')     => 'typicons',
                        __('Entypo', 'opal-theme-framework')       => 'entypo',
                        __('Linecons', 'opal-theme-framework')     => 'linecons',
                        __('Mono Social', 'opal-theme-framework')  => 'monosocial',
                        __('Material', 'opal-theme-framework')     => 'material',
                        __('Custom Image', 'opal-theme-framework') => 'custom',
                    ),
                    'admin_label' => true,
                    'param_name'  => 'type',
                    'description' => __('Select icon library.', 'opal-theme-framework'),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __('Icon', 'opal-theme-framework'),
                    'param_name'  => 'icon_fontawesome',
                    'value'       => 'fa fa-adjust',
                    // default value to backend editor admin_label
                    'settings'    => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                    ),
                    'dependency'  => array(
                        'element' => 'type',
                        'value'   => 'fontawesome',
                    ),
                    'description' => __('Select icon from library.', 'opal-theme-framework'),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __('Icon', 'opal-theme-framework'),
                    'param_name'  => 'icon_openiconic',
                    'value'       => 'vc-oi vc-oi-dial',
                    // default value to backend editor admin_label
                    'settings'    => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'type'         => 'openiconic',
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display
                    ),
                    'dependency'  => array(
                        'element' => 'type',
                        'value'   => 'openiconic',
                    ),
                    'description' => __('Select icon from library.', 'opal-theme-framework'),
                    'group'       => __('Icons', 'opal-theme-framework'),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __('Icon', 'opal-theme-framework'),
                    'param_name'  => 'icon_typicons',
                    'value'       => 'typcn typcn-adjust-brightness',
                    // default value to backend editor admin_label
                    'settings'    => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'type'         => 'typicons',
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display
                    ),
                    'dependency'  => array(
                        'element' => 'type',
                        'value'   => 'typicons',
                    ),
                    'description' => __('Select icon from library.', 'opal-theme-framework'),
                ),
                array(
                    'type'       => 'iconpicker',
                    'heading'    => __('Icon', 'opal-theme-framework'),
                    'param_name' => 'icon_entypo',
                    'value'      => 'entypo-icon entypo-icon-note',
                    // default value to backend editor admin_label
                    'settings'   => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'type'         => 'entypo',
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'type',
                        'value'   => 'entypo',
                    ),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __('Icon', 'opal-theme-framework'),
                    'param_name'  => 'icon_linecons',
                    'value'       => 'vc_li vc_li-heart',
                    // default value to backend editor admin_label
                    'settings'    => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'type'         => 'linecons',
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display
                    ),
                    'dependency'  => array(
                        'element' => 'type',
                        'value'   => 'linecons',
                    ),
                    'description' => __('Select icon from library.', 'opal-theme-framework'),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __('Icon', 'opal-theme-framework'),
                    'param_name'  => 'icon_monosocial',
                    'value'       => 'vc-mono vc-mono-fivehundredpx',
                    // default value to backend editor admin_label
                    'settings'    => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'type'         => 'monosocial',
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display
                    ),
                    'dependency'  => array(
                        'element' => 'type',
                        'value'   => 'monosocial',
                    ),
                    'description' => __('Select icon from library.', 'opal-theme-framework'),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __('Icon', 'opal-theme-framework'),
                    'param_name'  => 'icon_material',
                    'value'       => 'vc-material vc-material-cake',
                    // default value to backend editor admin_label
                    'settings'    => array(
                        'emptyIcon'    => false,
                        // default true, display an 'EMPTY' icon?
                        'type'         => 'material',
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display
                    ),
                    'dependency'  => array(
                        'element' => 'type',
                        'value'   => 'material',
                    ),
                    'description' => __('Select icon from library.', 'opal-theme-framework'),
                ),
                array(
                    'type'       => 'attach_image',
                    'heading'    => esc_html__('Photo', 'opal-theme-framework'),
                    'param_name' => 'photo',
                    'value'      => '',
                    'dependency' => array(
                        'element' => 'type',
                        'value'   => 'custom',
                    ),
                ),
                array(
                    "type"       => "dropdown",
                    "heading"    => esc_html__("Background Title", 'opal-theme-framework'),
                    "param_name" => "bg_title",
                    'value'      => array(
                        esc_html__('Primary', 'opal-theme-framework')      => 'primary',
                        esc_html__('Secondary', 'opal-theme-framework')    => 'secondary',
                        esc_html__('Custom Color', 'opal-theme-framework') => 'custom',
                    ),
                    "std"        => 'primary',
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Bg Custom Color', 'opal-theme-framework'),
                    'param_name'  => 'bg_title_custom',
                    'description' => esc_html__('Select color', 'opal-theme-framework'),
                    'dependency'  => array(
                        'element' => 'bg_title',
                        'value'   => array('custom'),
                    ),
                    'std'         => '#000'
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Show on hover', 'opal-theme-framework'),
                    'param_name' => 'show_on_hover',
                    'std'        => true,
                ),
            )
    );