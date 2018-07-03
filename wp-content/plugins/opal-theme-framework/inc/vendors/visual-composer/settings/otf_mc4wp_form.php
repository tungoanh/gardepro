<?php
return array(
    "name"        => esc_html__('MailChimp Form', 'opal-theme-framework'),
    "base"        => "otf_mc4wp_form",
    "category"    => 'Opal Theme',
//    'description' => esc_html__('Divider for sections', 'woodmart'),
    "php_class_name"  => 'WPBakeryShortCode_OTF_Base',
    "params"      => array(
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Form ID", 'opal-theme-framework'),
            "param_name" => "form_id",
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Style", 'opal-theme-framework'),
            "param_name" => "style",
            'value'      => array(
                esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
                esc_html__('Style 3', 'opal-theme-framework') => 'style-3',
            ),
            'std'        => 'style-1',
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'opal-theme-framework' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'opal-theme-framework' ),
        ),
    ),
);