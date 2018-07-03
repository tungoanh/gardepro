<?php
$bg_page = false;

// Property
if(function_exists('ore_is_property_archive') && ore_is_property_archive()){
    $bg_page = get_theme_mod('ore_property_archive_color_bg_page', false);
}elseif(is_singular('orealestate_property')){
    $bg_page = get_theme_mod('ore_property_single_color_bg_page', false);
}
//Woocommerce
elseif (otf_is_woocommerce_activated() && otf_is_product_archive()){
    $bg_page = get_theme_mod('ore_woocommerce_archive_color_bg_page', false);
}elseif(is_singular('product')){
    $bg_page = get_theme_mod('ore_woocommerce_single_color_bg_page', false);
}

if($bg_page){
    return <<<CSS
#page .site-content-contain{
    background-color: {$bg_page};
}
CSS;
}
return '';

/**
 * @see get_theme_mod()
 */