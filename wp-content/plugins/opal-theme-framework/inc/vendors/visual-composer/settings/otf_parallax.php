<?php
if (!defined('ABSPATH')) {
    die('-1');
}

return array(
    "name"        => esc_html__("OTF Parallax", 'opal-theme-framework'),
    "base"        => "otf_parallax",
    'icon'        => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/parallax.svg',
    "description" => esc_html__('Show parallax with image and content', 'opal-theme-framework'),
    "category"    => 'Opal Theme',
//    'front_enqueue_js' => array( get_theme_file_uri( '/assets/js/libs/parallax.js' ) ),
    "params"      => array(
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__("Enable Box Content ", 'opal-theme-framework'),
            "param_name" => "enable_box_content",
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => true,
        ),
        array(
            'type'       => 'textarea_html',
            'heading'    => esc_html__('Content', 'opal-theme-framework'),
            'param_name' => 'content',
            'value'      => esc_html__('I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opal-theme-framework'),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Box Style", 'opal-theme-framework'),
            "param_name" => "box_style",
            'value'      => array(
                esc_html__('None', 'opal-theme-framework')   => 'none',
                esc_html__('Square', 'opal-theme-framework') => 'square',
                esc_html__('Round', 'opal-theme-framework')  => 'round',
            ),
            'std'        => 'square',
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Position", 'opal-theme-framework'),
            "param_name" => "position",
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')  => 'left',
                esc_html__('Right', 'opal-theme-framework') => 'right',
            ),
            'std'        => 'right',
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Duration box content", 'opal-theme-framework'),
            'description' => esc_html__('Fill duration for box content parallax. Min = 0 and max= 1, Ex: 0.5', 'opal-theme-framework'),
            "param_name"  => "content_duration",
            "std"         => '0.5',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__("Enable reverse box content", 'opal-theme-framework'),
            "param_name" => "content_enable_reverse",
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => true,
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
            "param_name"  => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Image source', 'opal-theme-framework'),
            'param_name'  => 'select_main_image_source',
            'description' => esc_html__('Select Image source', 'opal-theme-framework'),
            'group'       => __('Image 1', 'opal-theme-framework'),
            'value'       => array(
                esc_html__('Media Library', 'opal-theme-framework') => 'main_image_library',
                esc_html__('External link', 'opal-theme-framework') => 'main_image_external',
            ),
            'std'         => 'main_image_library',
        ),
        array(
            "type"        => "attach_image",
            "heading"     => esc_html__("Main Image", 'opal-theme-framework'),
            'description' => esc_html__('Upload main image for parallax', 'opal-theme-framework'),
            "param_name"  => "main_image",
            'group'       => __('Image 1', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'select_main_image_source',
                'value'   => 'main_image_library'
            ),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('External link', 'opal-theme-framework'),
            'param_name' => 'external_link_main_image',
            'group'       => __('Image 1', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'select_main_image_source',
                'value'   => 'main_image_external'
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Image size', 'opal-theme-framework'),
            'param_name'  => 'main_image_size',
            'group'      => __('Image 1', 'opal-theme-framework'),
            'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'select_main_image_source',
                'value'   => 'main_image_library'
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Position", 'opal-theme-framework'),
            "param_name" => "position_image",
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')  => 'position_left',
                esc_html__('Right', 'opal-theme-framework') => 'position_right',
            ),
            'std'        => 'position_right',
            'group'      => __('Image 1', 'opal-theme-framework'),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Duration", 'opal-theme-framework'),
            'description' => esc_html__('Fill duration for main image parallax. Min = 0 and max= 1, Ex: 0.5', 'opal-theme-framework'),
            "param_name"  => "main_duration",
            "std"         => '0.5',
            'group'       => __('Image 1', 'opal-theme-framework'),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__("Enable Reverse ", 'opal-theme-framework'),
            "param_name" => "enable_reverse",
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => true,
            'group'      => __('Image 1', 'opal-theme-framework'),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Image source', 'opal-theme-framework'),
            'param_name'  => 'select_image2_source',
            'description' => esc_html__('Select Image source', 'opal-theme-framework'),
            'group'       => __('Image 2', 'opal-theme-framework'),
            'value'       => array(
                esc_html__('Media Library', 'opal-theme-framework') => 'image2_library',
                esc_html__('External link', 'opal-theme-framework') => 'image2_external',
            ),
            'std'         => 'image2_library',
        ),
        array(
            "type"        => "attach_image",
            "heading"     => esc_html__("Image 2", 'opal-theme-framework'),
            'description' => esc_html__('Upload image background for parallax', 'opal-theme-framework'),
            "param_name"  => "image2",
            'group'       => __('Image 2', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'select_image2_source',
                'value'   => 'image2_library'
            ),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => __('External link', 'opal-theme-framework'),
            'param_name' => 'external_link_image2',
            'group'       => __('Image 2', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'select_image2_source',
                'value'   => 'image2_external'
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Image size', 'opal-theme-framework'),
            'param_name'  => 'image2_size',
            'group'      => __('Image 2', 'opal-theme-framework'),
            'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
            'dependency' => array(
                'element' => 'select_image2_source',
                'value'   => 'image2_library'
            ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Position", 'opal-theme-framework'),
            "param_name" => "position_image2",
            'value'      => array(
                esc_html__('Left', 'opal-theme-framework')  => 'position_left',
                esc_html__('Right', 'opal-theme-framework') => 'position_right',
            ),
            'std'        => 'position_right',
            'group'      => __('Image 2', 'opal-theme-framework'),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__("Duration", 'opal-theme-framework'),
            'description' => esc_html__('Fill duration for background image parallax. Min = 0 and max= 1, Ex: 0.5', 'opal-theme-framework'),
            "param_name"  => "image2_duration",
            "std"         => '0.5',
            'group'       => __('Image 2', 'opal-theme-framework'),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__("Enable Reverse ", 'opal-theme-framework'),
            "param_name" => "enable_reverse2",
            'value'      => array(
                esc_html__('Yes', 'opal-theme-framework') => true,
            ),
            'std'        => true,
            'group'      => __('Image 2', 'opal-theme-framework'),
        ),
        /*array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'homefinder' ),
            'param_name' => 'css',
            'group' => __( 'Design Options', 'homefinder' ),
        ),*/
    ),
);