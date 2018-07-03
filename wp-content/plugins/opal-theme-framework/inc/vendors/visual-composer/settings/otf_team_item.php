<?php
return array(
    "name"            => __("Team Item", 'opal-theme-framework'),
    "base"            => "otf_team_item",
    //'icon'            => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/testimonial-item.svg',
    "category"        => 'Opal Theme',
    "description"     => esc_html__('Team Item', 'opal-theme-framework'),
    "as_child"        => array('only' => 'otf_team'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "php_class_name"  => 'WPBakeryShortCode_OTF_Base',
    "params"          => array(
        array(
            'type'        => 'textfield',
            'heading'     => __('Name', 'opal-theme-framework'),
            'param_name'  => 'name',
            'admin_label' => true
        ),
        array(
            'type'       => 'textarea',
            'heading'    => __('Description', 'opal-theme-framework'),
            'param_name' => 'content',
            "value"      => ''
        ),
        array(
            "type"        => "attach_image",
            "heading"     => esc_html__("avatar", 'opal-theme-framework'),
            "param_name"  => "photo",
            'description' => esc_html__('Select your avatar.', 'opal-theme-framework'),
            "value"       => '',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Image size', 'opal-theme-framework'),
            'param_name'  => 'image_size',
            'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('Job', 'opal-theme-framework'),
            'param_name' => 'job',
        ),
        array(
            'type'        => 'param_group',
            'heading'     => __('Social', 'opal-theme-framework'),
            'param_name'  => 'social',
            'description' => __('Enter values', 'opal-theme-framework'),
            'value'       => urlencode(json_encode(array(
                array(
                    'link' => __('http://facebook.com', 'opal-theme-framework'),
                ),
                array(
                    'link' => __('http://instagram.com', 'opal-theme-framework'),
                ),
                array(
                    'link' => __('https://plus.google.com', 'opal-theme-framework'),
                ),
                array(
                    'link' => __('https://twitter.com', 'opal-theme-framework'),
                ),
            ))),
            'group'       => __('Social', 'opal-theme-framework'),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => __('Social link', 'opal-theme-framework'),
                    'param_name'  => 'link',
                    'admin_label' => true,
                ),
            ),
        ),
    )
);