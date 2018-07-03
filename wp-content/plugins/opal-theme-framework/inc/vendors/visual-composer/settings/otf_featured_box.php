<?php
return array(
    'name'            => __('OTF Feature Box', 'opal-theme-framework'),
    'icon'            => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/feature-box.svg',
    'base'            => 'otf_featured_box',
    'description'     => esc_html__('Feature Box', 'opal-theme-framework'),
    'category'        => 'Opal Theme',
    "content_element" => true,
    'params'          => array(
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Style', 'opal-theme-framework'),
            'param_name' => 'style',
            'value'      => array(
                esc_html__('Vertical', 'opal-theme-framework')  => 'style-1',
                esc_html__('Hoziontal', 'opal-theme-framework') => 'style-2',
            ),
            'std'        => 'style-1',
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => esc_html__('Enable boxed', 'opal-theme-framework'),
            'param_name' => 'boxed',
            'std'        => 'false',
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Align', 'opal-theme-framework'),
            'param_name' => 'text_align',
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')   => 'text-left',
                esc_html__('Center', 'opal-theme-framework') => 'text-center',
                esc_html__('Right', 'opal-theme-framework')  => 'text-right',
            ),
            'std'        => 'text-left',
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Hover Style', 'opal-theme-framework'),
            'param_name' => 'hover_style',
            'value'      => array(
                esc_html__('None', 'opal-theme-framework')    => '',
                esc_html__('Background primary', 'opal-theme-framework') => 'hover-background',
                esc_html__('Box shadow', 'opal-theme-framework') => 'hover-boxshadow',

            ),
            'std'        => ''
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Extra class name', 'opal-theme-framework'),
            'param_name'  => 'el_class',
            'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'opal-theme-framework'),
        ),
        //========================================================================================
        // Content tab
        //========================================================================================
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Title', 'opal-theme-framework'),
            'param_name'  => 'title',
            'value'       => '',
            'admin_label' => true,
            'group'       => __('Content', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Font size title', 'opal-theme-framework'),
            'param_name' => 'title_size',
            'value'      => '18px',
            'group'      => __('Content', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Title color', 'opal-theme-framework'),
            'param_name'  => 'color',
            'description' => esc_html__('Select font color', 'opal-theme-framework'),
            'group'       => __('Content', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'textarea_html',
            'heading'     => esc_html__('Description', 'opal-theme-framework'),
            'param_name'  => 'content',
            'value'       => 'Your Description Here',
            'description' => esc_html__('Allow  put html tags', 'opal-theme-framework'),
            'group'       => __('Content', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Button text', 'opal-theme-framework'),
            'param_name'  => 'btn_text',
            'description' => esc_html__('Enter text used as button of bar.', 'opal-theme-framework'),
            'value'       => 'Click here',
            'group'       => __('Content', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__('Button Link', 'opal-theme-framework'),
            'param_name'  => 'btn_link',
            'description' => esc_html__('Enter link used as button of bar.', 'opal-theme-framework'),
            'value'       => '',
            'group'       => __('Content', 'opal-theme-framework'),
        ),
        //========================================================================================
        //========================================================================================
        //                              Icon Tab
        //========================================================================================
        //========================================================================================
        array(
            'type'        => 'dropdown',
            'heading'     => __('Icon library', 'opal-theme-framework'),
            'value'       => array(
                __('None', 'opal-theme-framework')         => '',
                __('Font Awesome', 'opal-theme-framework') => 'fontawesome',
                __('Open Iconic', 'opal-theme-framework')  => 'openiconic',
                __('Typicons', 'opal-theme-framework')     => 'typicons',
                __('Entypo', 'opal-theme-framework')       => 'entypo',
                __('Linecons', 'opal-theme-framework')     => 'linecons',
                __('Mono Social', 'opal-theme-framework')  => 'monosocial',
                __('Material', 'opal-theme-framework')     => 'material',
                __('Web mod', 'opal-theme-framework')     => 'webmod',
                __('Custom Image', 'opal-theme-framework') => 'custom',
            ),
            'admin_label' => true,
            'param_name'  => 'type',
            'description' => __('Select icon library.', 'opal-theme-framework'),
            'group'       => __('Icons', 'opal-theme-framework'),
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
            'group'       => __('Icons', 'opal-theme-framework'),
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
            'group'       => __('Icons', 'opal-theme-framework'),
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
            'group'      => __('Icons', 'opal-theme-framework'),
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
            'group'       => __('Icons', 'opal-theme-framework'),
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
            'group'       => __('Icons', 'opal-theme-framework'),
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
            'group'       => __('Icons', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => __('Icon', 'opal-theme-framework'),
            'param_name'  => 'icon_webmod',
            'value'       => '',
            // default value to backend editor admin_label
            'settings'    => array(
                'emptyIcon'    => false,
                // default true, display an 'EMPTY' icon?
                'type'         => 'webmod',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'webmod',
            ),
            'description' => __('Select icon from library.', 'opal-theme-framework'),
            'group'       => __('Icons', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Icon Color', 'opal-theme-framework'),
            'param_name'  => 'i_color',
            'description' => esc_html__('Select font color', 'opal-theme-framework'),
            'group'       => __('Icons', 'opal-theme-framework'),
            'dependency'  => array(
                'element' => 'type',
                'value'   => array('material', 'monosocial', 'linecons', 'entypo', 'typicons', 'openiconic', 'fontawesome', 'webmod'),
            ),
        ),
        array(
            'type'       => 'attach_image',
            'heading'    => esc_html__('Photo', 'opal-theme-framework'),
            'param_name' => 'photo',
            'value'      => '',
            'group'      => __('Icons', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'type',
                'value'   => 'custom',
            ),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('SVG Color', 'opal-theme-framework'),
            'param_name'  => 'svg_color',
            'description' => esc_html__('Select color', 'opal-theme-framework'),
            'group'       => __('Icons', 'opal-theme-framework'),
            'dependency'  => array(
                'element' => 'type',
                'value'   => 'custom',
            ),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('SVG Width', 'opal-theme-framework'),
            'param_name' => 'svg_width',
            'group'      => __('Icons', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'type',
                'value'   => 'custom',
            ),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Font size', 'opal-theme-framework'),
            'param_name' => 'i_size',
            'value'      => '30px',
            'description' => esc_html__('Select font size icon, the height and width of the background are two times the font size', 'opal-theme-framework'),
            'group'      => __('Icons', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Background shape', 'opal-theme-framework'),
            'param_name' => 'i_shape',
            'value'      => array(
                esc_html__('None', 'opal-theme-framework')           => '',
                esc_html__('Squal', 'opal-theme-framework')          => 'squal',
                esc_html__('Circle', 'opal-theme-framework')         => 'round',
                esc_html__('Outline Squal', 'opal-theme-framework')  => 'o-squal',
                esc_html__('Outline Circle', 'opal-theme-framework') => 'o-round',

            ),
            'std'        => '',
            'group'      => __('Icons', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'colorpicker',
            'heading'    => esc_html__('Background  Color', 'opal-theme-framework'),
            'param_name' => 'bg_icon_color',
            'group'      => __('Icons', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'i_shape',
                'value'   => array(
                    'squal',
                    'round',
                    'o-squal',
                    'o-round',
                )
            ),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Vertical Align', 'opal-theme-framework'),
            'param_name' => 'v_align',
            'value'      => array(
                esc_html__('Top', 'opal-theme-framework')    => 'align-items-start',
                esc_html__('Middle', 'opal-theme-framework') => 'align-items-center',
                esc_html__('Bottom', 'opal-theme-framework') => 'align-items-end',

            ),
            'std'        => '',
            'group'      => __('Icons', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'style',
                'value'   => 'style-2'
            ),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Position', 'opal-theme-framework'),
            'param_name' => 'position',
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')  => '',
                esc_html__('Right', 'opal-theme-framework') => 'right',
            ),
            'std'        => '',
            'group'      => __('Icons', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'style',
                'value'   => 'style-2'
            ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'opal-theme-framework' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'opal-theme-framework' ),
        ),
    ),
);