<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}
$params = array(
    array(
        "type"        => "textfield",
        "heading"     => esc_html__("Title", 'opal-theme-framework'),
        "param_name"  => "title",
        "std"         => 'Text Title',
        "value"       => '',
        "admin_label" => true,
    ),
    array(
        "type"       => "textfield",
        "heading"    => esc_html__( "Sub Title", 'opal-theme-framework' ),
        "param_name" => "subtitle",
        "value"      => '', "admin_label" => true,
    ),
    array(
        "type"       => "dropdown",
        "heading"    => esc_html__("Style", 'opal-theme-framework'),
        "param_name" => "style",
        'value'      => array(
            esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
            esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
            esc_html__('Style 3', 'opal-theme-framework') => 'style-3',
            esc_html__('Style 4', 'opal-theme-framework') => 'style-4',
        ),
        'std'        => 'style-1',
    ),
    array(
        "type"        => "textfield",
        "heading"     => esc_html__("Price", 'opal-theme-framework'),
        "param_name"  => "price",
        "std"         => '$99',
        "value"       => '',
        "admin_label" => true,
    ),
    array(
        "type"        => "textfield",
        "heading"     => esc_html__("Per", 'opal-theme-framework'),
        "param_name"  => "per",
        "std"         => '/month',
        "admin_label" => true,
    ),
    array(
        'type'        => 'param_group',
        'heading'     => __('Attributes', 'opal-theme-framework'),
        'param_name'  => 'attributes',
        'description' => __('Enter values', 'opal-theme-framework'),
        'value' => urlencode( json_encode( array(
            array(
                'label' => __( 'Unlimited Web Space', 'opal-theme-framework' ),
                'active' => 'true',
            ),
            array(
                'label' => __( 'FREE Site Building Tools ', 'opal-theme-framework' ),
                'active' => 'true',
            ),
            array(
                'label' => __( 'FREE Domain Registar ', 'opal-theme-framework' ),
                'active' => 'true',
            ),
            array(
                'label' => __( '24/7/365 Support', 'opal-theme-framework' ),
                'active' => 'true',
            ),
            array(
                'label' => __( 'FREE Marketing & SEO Tools ', 'opal-theme-framework' ),
                'active' => 'true',
            ),
        ) ) ),
        'group' => __( 'Attributes', 'opal-theme-framework' ),
        'params'      => array(
            array(
                'type'        => 'textfield',
                'heading'     => __('Label', 'opal-theme-framework'),
                'param_name'  => 'label',
                'description' => __('Enter text used as title of bar.', 'opal-theme-framework'),
                'admin_label' => true,
            ),
            array(
                "type"       => "checkbox",
                "heading"    => esc_html__("Active", 'opal-theme-framework'),
                "param_name" => "active",
                'value'      => array(
                    esc_html__('Yes', 'opal-theme-framework') => 'true',
                ),
                'std'        => 'true',
            ),
        ),
    ),
    array(
        "type"       => "checkbox",
        "heading"    => esc_html__("Display Button ", 'opal-theme-framework'),
        "param_name" => "show_button",
        'value'      => array(
            esc_html__('Yes', 'opal-theme-framework') => 'true',
        ),
        'std'        => 'true',
    ),
    array(
        "type"        => "textfield",
        "heading"     => esc_html__("Text Button", 'opal-theme-framework'),
        "param_name"  => "text_button",
        "std"         => 'Get Started',
        "value"       => '',
        "admin_label" => true,
        'dependency'  => array(
            'element' => 'show_button',
            'value'   => 'true',
        ),
    ),
);
if(otf_is_woocommerce_activated() && otf_is_opal_membership_activated()) {
    $values = array();
    $args = array(
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => 'opal_membership',
            ),
        ),
    );
    $products = new WP_Query($args);
    if ($products->have_posts()) {
        $products = $products->posts;
        foreach ($products as $product) {
            $product = wc_get_product($product->ID);
            $values[$product->get_name().' - Price: ' . $product->get_price()] = $product->get_id();
        }
    }
    $params = wp_parse_args(
        array(
            array(
                "type"       => "dropdown",
                "heading"    => esc_html__("Link config", 'opal-theme-framework'),
                "param_name" => "link_config",
                'value'      => array(
                    esc_html__('Customize link', 'opal-theme-framework') => 'customize',
                    esc_html__('Select membership page', 'opal-theme-framework') => 'membership',
                ),
                'std'        => 'customize',
                'dependency'  => array(
                    'element' => 'show_button',
                    'value'   => 'true',
                ),
            ),
            array(
                "type"       => "dropdown",
                "heading"    => esc_html__("Select Membership page", 'opal-theme-framework'),
                "param_name" => "membership",
                'value'      =>  $values,
                'std'        => '',
                'dependency'  => array(
                    'element' => 'link_config',
                    'value'   => 'membership',
                ),
            ),
            array(
                'type'        => 'vc_link',
                'heading'     => esc_html__('Button Link', 'opal-theme-framework'),
                'param_name'  => 'btn_link',
                'description' => esc_html__('Enter link used as button of bar.', 'opal-theme-framework'),
                'value'       => '',
                'dependency'  => array(
                    'element' => 'link_config',
                    'value'   => 'customize',
                ),
            ),

            array(
                "type"       => "checkbox",
                "heading"    => esc_html__("Recommend", 'opal-theme-framework'),
                "param_name" => "recommend",
                'value'      => array(
                    esc_html__('Yes', 'opal-theme-framework') => 'true',
                ),
                'std'        => 'true',
            ),
            array(
                "type"        => "textfield",
                "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
                "param_name"  => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
            ),
        ), $params
    );
}else{
    $params = wp_parse_args(
        array(
            array(
                'type'        => 'vc_link',
                'heading'     => esc_html__('Button Link', 'opal-theme-framework'),
                'param_name'  => 'btn_link',
                'description' => esc_html__('Enter link used as button of bar.', 'opal-theme-framework'),
                'value'       => '',
                'dependency'  => array(
                    'element' => 'show_button',
                    'value'   => 'true',
                ),
            ),

            array(
                "type"       => "checkbox",
                "heading"    => esc_html__("Recommend", 'opal-theme-framework'),
                "param_name" => "recommend",
                'value'      => array(
                    esc_html__('Yes', 'opal-theme-framework') => 'true',
                ),
                'std'        => 'true',
            ),
            array(
                "type"        => "textfield",
                "heading"     => esc_html__("Extra class name", 'opal-theme-framework'),
                "param_name"  => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'opal-theme-framework'),
            ),
        ), $params

    );
}

return array(
    "name"             => __("OTF Pricing", 'opal-theme-framework'),
    "base"             => "otf_pricing",
    'icon'                    => trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'inc/vendors/visual-composer/icons/pricing.svg',
    "class"            => "",
    "description"      => esc_html__('Show pricing', 'opal-theme-framework'),
    "category"         => 'Opal Theme',
    "params"           => $params
);