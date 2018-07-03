<?php

return array(
    "name"           => __( "OTF Blog", 'opal-theme-framework' ),
    "base"           => "otf_vc_post",
    "class"          => "",
    "category"       => 'Opal Theme',
    "params"         => array(
        array(
            'type'               => 'autocomplete',
            'heading'            => __( 'Narrow data source', 'opal-theme-framework' ),
            'param_name'         => 'taxonomies',
            'settings'           => array(
                'multiple'       => true,
                'min_length'     => true,
                'groups'         => true,
                'unique_values'  => true,
                'display_inline' => true,
                'delay'          => 500,
                'auto_focus'     => true,
            ),
            'param_holder_class' => 'vc_not-for-custom',
            'description'        => __( 'Enter categories, tags or custom taxonomies.', 'opal-theme-framework' ),
        ),
        array(
            'type'               => 'textfield',
            'heading'            => __( 'Total items', 'opal-theme-framework' ),
            'param_name'         => 'max_items',
            'param_holder_class' => 'vc_not-for-custom',
            'description'        => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'opal-theme-framework' ),
            'std'                => 10,
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Grid elements per row', 'opal-theme-framework' ),
            'param_name'  => 'element_width',
            'value'       => array(
                array(
                    'label' => '6',
                    'value' => 6,
                ),
                array(
                    'label' => '4',
                    'value' => 4,
                ),
                array(
                    'label' => '3',
                    'value' => 3,
                ),
                array(
                    'label' => '2',
                    'value' => 2,
                ),
                array(
                    'label' => '1',
                    'value' => 1,
                ),
            ),
            'std'         => '4',
            'description' => __( 'Select number of single grid elements per row.', 'opal-theme-framework' ),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'No Gutters', 'opal-theme-framework' ),
            'param_name'  => 'no_gutters',
            'value'       => array(
                array(
                    'label' => __('No', 'opal-theme-framework'),
                    'value' => '',
                ),
                array(
                    'label' => __('Yes', 'opal-theme-framework'),
                    'value' => 'no-gutters',
                ),
            ),
            'std'         => '',
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Style', 'opal-theme-framework' ),
            'param_name'  => 'style',
            'value'       => array(
                array(
                    'label' => 'Classic',
                    'value' => 'classic',
                ),
                array(
                    'label' => 'Reverse',
                    'value' => 'style-1',
                ),
                array(
                    'label' => 'Grid',
                    'value' => 'style-2',
                ),
                array(
                    'label' => 'Small list',
                    'value' => 'style-3',
                ),
            ),
            'std'         => 'classic',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => __( "Hidden Thumbnail", "opal-theme-framework" ),
            "param_name" => "thumbnail",
            'std'        => 'false',
            'dependency' => array(
                'element' => 'style',
                'value'   => array( 'style-2' ),
            ),
        ),
    ),
    "php_class_name" => 'WPBakeryShortCode_OTF_Base',
);