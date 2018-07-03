<?php
return array(
    "name"            => __("Slider Item", 'opal-theme-framework'),
    "base"            => "otf_team_item",
    "category"        => 'Opal Theme',
    "description"     => esc_html__('Team Item', 'opal-theme-framework'),
    "as_child"        => array('only' => 'otf_slider'),
    "content_element" => true,
    "php_class_name"  => 'WPBakeryShortCode_OTF_Base',
    "params"          => array(
        array(
            "type"        => "attach_image",
            "heading"     => esc_html__("Select Images", 'opal-theme-framework'),
            "param_name"  => "photo",
            'description' => esc_html__('Select your image', 'opal-theme-framework'),
            "value"       => '',
            'admin_label' => true,
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Image size', 'opal-theme-framework'),
            'param_name'  => 'image_size',
            "value"       => 'full',
            'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('Title', 'opal-theme-framework'),
            'param_name' => 'title',
            'group' => 'Heading'
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Font size', 'opal-theme-framework'),
            'param_name' => 't_size',
            'value'      => '30px',
            'group'      => __('Heading', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Color', 'opal-theme-framework'),
            'param_name'  => 't_color',
            'group'       => __('Heading', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Font weigth', 'opal-theme-framework'),
            'param_name' => 't_fontweight',
            'description' => esc_html__('lighter, normal, bold, 100, 300, 500..', 'opal-theme-framework'),
            'value'        => 'normal',
            'group'      => __('Heading', 'opal-theme-framework'),
        ),
        array(
            "type"        => "dropdown",
            "heading"     => esc_html__( "Alignment", 'opal-theme-framework' ),
            "param_name"  => "t_alignment",
            'value'      => array(
                esc_html__( 'center', 'opal-theme-framework' ) => 'center',
                esc_html__( 'left', 'opal-theme-framework' ) => 'left',
                esc_html__( 'right', 'opal-theme-framework' ) => 'right',
            ),
            'std'        => 'left',
            'group'      => __('Heading', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Extra class', 'opal-theme-framework'),
            'param_name' => 'css_class',
            'group'      => __('Heading', 'opal-theme-framework'),
        ),
        array(
            'type'       => 'textarea_html',
            'heading'    => __('Description', 'opal-theme-framework'),
            'param_name' => 'content',
            "value"      => '<h3>HEADING</h3><p>write any text and make custom design that you want to show.</p>',
            'group' => 'Description'
        ),
    )
);