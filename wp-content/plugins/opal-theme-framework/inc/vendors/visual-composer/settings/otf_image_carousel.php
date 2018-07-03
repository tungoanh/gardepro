<?php
return array(
    'name' => __( 'OTF Image Carousel', 'opal-theme-framework' ),
    'base' => 'otf_image_carousel',
    'category' => __( 'Opal Theme', 'opal-theme-framework' ),
    'description' => __( 'Animated carousel with images', 'opal-theme-framework' ),
    'params' => array(
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Image source', 'opal-theme-framework'),
            'param_name'  => 'select_image_source',
            'description' => esc_html__('Select Image source', 'opal-theme-framework'),
            'value'       => array(
                esc_html__('Media Library', 'opal-theme-framework') => 'library',
                esc_html__('External link', 'opal-theme-framework') => 'external',
            ),
            'std'         => 'library',
        ),
        array(
            'type' => 'attach_images',
            'heading' => __( 'Images', 'opal-theme-framework' ),
            'param_name' => 'images',
            'value' => '',
            'description' => __( 'Select images from media library.', 'opal-theme-framework' ),
            'dependency' => array(
                'element' => 'select_image_source',
                'value'   => 'library'
            ),
        ),
        array(
            'type'        => 'param_group',
            'heading'     => __('External link', 'opal-theme-framework'),
            'param_name'  => 'images_link',
            'description' => __('Enter images link', 'opal-theme-framework'),
            'value'       => urlencode(json_encode(array(
                array(
                    'link' => __('http://example.com/image.jpg', 'opal-theme-framework'),
                )
            ))),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => __('Link', 'opal-theme-framework'),
                    'param_name'  => 'link',
                    'admin_label' => true,
                ),
            ),
            'dependency' => array(
                'element' => 'select_image_source',
                'value'   => 'external'
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Carousel Margin', 'opal-theme-framework' ),
            'param_name' => 'margin',
            'value' => '30',
            'description' => __( 'margin-right(px) on item.', 'opal-theme-framework' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Carousel Stage Padding', 'opal-theme-framework' ),
            'param_name' => 'padding',
            'value' => '0',
            'description' => __( 'Padding left and right on stage (can see neighbours).', 'opal-theme-framework' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Slider speed', 'opal-theme-framework' ),
            'param_name' => 'speed',
            'value' => '5000',
            'description' => __( 'Duration of animation between slides (in ms).', 'opal-theme-framework' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Slides per view', 'opal-theme-framework' ),
            'param_name' => 'slides_per_view',
            'value' => '1',
            'description' => __( 'Enter number of slides to display at the same time.', 'opal-theme-framework' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Slider autoplay', 'opal-theme-framework' ),
            'param_name' => 'autoplay',
            'description' => __( 'Enable autoplay mode.', 'opal-theme-framework' ),
            'value' => array( __( 'Yes', 'opal-theme-framework' ) => 'yes' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Show pagination control', 'opal-theme-framework' ),
            'param_name' => 'show_pagination_control',
            'description' => __( 'If checked, pagination controls will be show.', 'opal-theme-framework' ),
            'value' => array( __( 'Yes', 'opal-theme-framework' ) => 'yes' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Show prev/next buttons', 'opal-theme-framework' ),
            'param_name' => 'show_prev_next_buttons',
            'description' => __( 'If checked, prev/next buttons will be show.', 'opal-theme-framework' ),
            'value' => array( __( 'Yes', 'opal-theme-framework' ) => 'yes' ),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => __('Style', 'opal-theme-framework'),
            'param_name' => 'style_nav',
            'value'      => array(
                __('Style 1', 'opal-theme-framework') => '',
                __('Style 2', 'opal-theme-framework') => 'nav-style-2',
                __('Style 3', 'opal-theme-framework') => 'nav-style-3',
                __('Style 4', 'opal-theme-framework') => 'nav-style-4',
            ),
            'std'        => '',
            'dependency'  => array(
                'element' => 'show_prev_next_buttons',
                'value'   => array(
                    'yes',
                ),
            ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Partial view', 'opal-theme-framework' ),
            'param_name' => 'partial_view',
            'description' => __( 'If checked, part of the next slide will be visible.', 'opal-theme-framework' ),
            'value' => array( __( 'Yes', 'opal-theme-framework' ) => 'yes' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Slider loop', 'opal-theme-framework' ),
            'param_name' => 'wrap',
            'description' => __( 'Enable slider loop mode.', 'opal-theme-framework' ),
            'value' => array( __( 'Yes', 'opal-theme-framework' ) => 'yes' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'opal-theme-framework' ),
            'param_name' => 'el_class',
            'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'opal-theme-framework' ),
        ),
    ),
);
