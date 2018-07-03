<?php
return array(
    "name"        => esc_html__('Opal divider', 'opal-theme-framework'),
    "base"        => "opal_divider",
    "category"    => 'Opal Theme',
    'icon'        => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/divider.svg',
    'description' => esc_html__('Divider for sections', 'opal-theme-framework'),
    "params"      => array(
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Position', 'opal-theme-framework'),
            'param_name' => 'position',
            'value'      => array(
                esc_html__('Top', 'opal-theme-framework')    => 'top',
                esc_html__('Bottom', 'opal-theme-framework') => 'bottom',
            ),
        ),
        array(
            'type'       => 'colorpicker',
            'heading'    => esc_html__('Color', 'opal-theme-framework'),
            'param_name' => 'color',
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Style', 'opal-theme-framework'),
            'param_name' => 'style',
            'value'      => array(
                esc_html__('Waves Small', 'opal-theme-framework')    => 'waves-small',
                esc_html__('Waves Wide', 'opal-theme-framework')     => 'waves-wide',
                esc_html__('Curved Line', 'opal-theme-framework')    => 'curved-line',
                esc_html__('Triangle', 'opal-theme-framework')       => 'triangle',
                esc_html__('Clouds', 'opal-theme-framework')         => 'clouds',
                esc_html__('Diagonal Right', 'opal-theme-framework') => 'diagonal-right',
                esc_html__('Diagonal Left', 'opal-theme-framework')  => 'diagonal-left',
                esc_html__('Half Circle', 'opal-theme-framework')    => 'half-circle',
                esc_html__('Half Circle 2', 'opal-theme-framework')  => 'half-circle2',
                esc_html__('Paint Stroke', 'opal-theme-framework')   => 'paint-stroke',
                esc_html__('Grime', 'opal-theme-framework')          => 'grime',
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Custom height', 'opal-theme-framework'),
            'param_name'  => 'custom_height',
            'dependency'  => array(
                'element' => 'style',
                'value'   => array('curved-line', 'diagonal-right', 'half-circle', 'diagonal-left')
            ),
            'description' => esc_html__('Enter divider height (Note: CSS measurement units allowed).', 'opal-theme-framework')
        ),

        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Extra class name', 'opal-theme-framework'),
            'param_name'  => 'el_class',
            'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'opal-theme-framework')
        ),
        array(
            'type'       => 'css_editor',
            'heading'    => __('CSS box', 'opal-theme-framework'),
            'param_name' => 'css',
            'group'      => __('Design Options', 'opal-theme-framework'),
        ),
    ),
);