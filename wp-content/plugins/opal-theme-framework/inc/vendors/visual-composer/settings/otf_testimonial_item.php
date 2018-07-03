<?php
return array(
    "name"            => __("Testimonial Item", 'opal-theme-framework'),
    "base"            => "otf_testimonial_item",
    'icon'            => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/testimonial-item.svg',
    "category"        => 'Opal Theme',
    "description"     => esc_html__('Testimonial Item', 'opal-theme-framework'),
    "as_child"        => array('only' => 'otf_testimonial'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "php_class_name"  => 'WPBakeryShortCode_OTF_Base',
    "params"          => array(
        array(
            'type'       => 'textfield',
            'heading'    => __('Name', 'opal-theme-framework'),
            'param_name' => 'name',
        ),
        array(
            'type'       => 'textarea',
            'heading'    => __('Content', 'opal-theme-framework'),
            'param_name' => 'content',
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
            "value"       => 'full',
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('Job', 'opal-theme-framework'),
            'param_name' => 'job',
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('website', 'opal-theme-framework'),
            'param_name' => 'website',
        ),
    )
);