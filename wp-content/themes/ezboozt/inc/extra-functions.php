<?php
add_action('after_setup_theme', 'ezboozt_add_framework_supports');
function ezboozt_add_framework_supports(){
    // Opal Framework support
    add_theme_support( 'opal-admin-menu' );
    add_theme_support( 'opal-custom-page-field' );
    add_theme_support( 'opal-customize-css' );
    add_theme_support( 'opal-megamenu' );

    add_theme_support( 'opal-brand' );
    add_theme_support( 'opal-footer-builder' );
    add_theme_support( 'opal-header-builder' );
    add_theme_support( 'opal-testimonial' );
    add_theme_support( 'opal-woocommerce' );


    add_image_size( 'ezboozt-featured-image', 2000, 1200, true );
    add_image_size( 'ezboozt-thumbnail-avatar', 100, 100, true );
}

add_filter( 'otf_customize_colors', '_theme_custom_color_1', 10, 7 );
function _theme_custom_color_1($cssCode, $color_primary, $color_primary_hover, $color_secondary, $color_secondary_hover, $color_body, $color_heading) {
    $cssCode .= <<<CSS
.parallax-box-content > div.box-style-square:before{
    box-shadow: 70px -70px 70px {$color_secondary->toCss()};
}
.parallax-box-content > div.box-style-round:before {
    box-shadow: 100px -100px 190px 20px {$color_secondary->toCss()};
}
.bg-gradient {
    background-image: -moz-linear-gradient(45deg, {$color_primary->toCss()} 0%, {$color_secondary->toCss()} 75%);
    background-image: -webkit-linear-gradient(45deg, {$color_primary->toCss()} 0%, {$color_secondary->toCss()} 75%);
    background-image: -ms-linear-gradient(45deg, {$color_primary->toCss()} 0%, {$color_secondary->toCss()} 75%);
}
CSS;
    return $cssCode;
}

add_filter('otf_customize_grid', 'ezboozt_customizer_grid', 10 , 2);
function ezboozt_customizer_grid($cssCode, $gridGutter) {
    $cssCode .= <<<CSS
CSS;
    return $cssCode;
}


add_filter('otf_oneclick_config_url', 'ezboozt_get_one_click_url');
function ezboozt_get_one_click_url(){
    return 'http://demo3.wpopal.com/boost/sample_data/config.json';
}