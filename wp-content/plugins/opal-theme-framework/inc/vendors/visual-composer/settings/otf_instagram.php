<?php
return array(
    'name'        => esc_html__('OTF Instagram', 'opal-theme-framework'),
    'base'        => 'otf_instagram',
    'icon'        => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/instagram.svg',
    'category'    => esc_html__('Opal Theme', 'opal-theme-framework'),
    'description' => esc_html__('Instagram photos', 'opal-theme-framework'),
    'params'      => array(
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Username', 'opal-theme-framework'),
            'param_name' => 'username',
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Number of photos', 'opal-theme-framework'),
            'param_name' => 'number',
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Photos per row', 'opal-theme-framework'),
            'param_name'  => 'per_row',
            'skip_in'     => 'widget',
            'description' => esc_html__('Number of photos per row for grid design or items in slider per view.', 'opal-theme-framework'),
            'value'       => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Photo size', 'opal-theme-framework'),
            'param_name' => 'size',
            'value'      => array(
                esc_html__('Thumbnail', 'opal-theme-framework') => 'thumbnail',
                esc_html__('Large', 'opal-theme-framework')     => 'large',
            ),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Open link in', 'opal-theme-framework'),
            'param_name' => 'target',
            'value'      => array(
                esc_html__('Current window (_self)', 'opal-theme-framework') => '_self',
                esc_html__('New window (_blank)', 'opal-theme-framework')    => '_blank',
            ),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Design', 'opal-theme-framework'),
            'param_name' => 'design',
            'value'      => array(
                esc_html__('Grid', 'opal-theme-framework')     => 'grid',
                esc_html__('Carousel', 'opal-theme-framework') => 'carousel',
            ),
            'std'        => 'grid'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Carousel Margin item', 'opal-theme-framework' ),
            'param_name' => 'margin_carousel',
            'value' => '0',
            'description' => __( 'margin-right(px) on item.', 'opal-theme-framework' ),
            'dependency'  => array(
                'element' => 'design',
                'value'   => array(
                    'carousel',
                ),
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Margin item', 'opal-theme-framework' ),
            'param_name' => 'margin',
            'value' => '0',
            'description' => __( 'margin-right(px) on item.', 'opal-theme-framework' ),
            'dependency'  => array(
                'element' => 'design',
                'value'   => array(
                    'grid',
                ),
            ),
        ),
        array(
            'type'        => 'textarea_html',
            'holder'      => 'div',
            'heading'     => esc_html__('Instagram text', 'opal-theme-framework'),
            'param_name'  => 'content',
            'skip_in'     => 'widget',
            'description' => esc_html__('Add here few words about your instagram profile.', 'opal-theme-framework'),
            'dependency'  => array(
                'element' => 'design',
                'value'   => array('grid'),
            )
        ),
        array(
            'type'       => 'checkbox',
            'heading'    => esc_html__('Hide likes and comments', 'opal-theme-framework'),
            'skip_in'    => 'widget',
            'param_name' => 'hide_mask',
            'value'      => array(esc_html__('Yes, please', 'opal-theme-framework') => 1)
        ),
    )
);
