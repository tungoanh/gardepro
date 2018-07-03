<?php
if (!otf_is_woocommerce_activated()) {
    return '';
}
$cssCode = '';
if (get_theme_mod('otf_woocommerce_product_color_custom_enable', false)) {
    $AddToCart = get_theme_mod('otf_woocommerce_product_color_add_to_cart', '#fff');
    $bgAddToCart = get_theme_mod('otf_woocommerce_product_color_bg_add_to_cart', '#333');
    $borderAddToCart = get_theme_mod('otf_woocommerce_product_color_border_add_to_cart', '#333');
    $AddToCartHover = get_theme_mod('otf_woocommerce_product_color_add_to_cart_hover', '#fff');
    $bgAddToCartHover = get_theme_mod('otf_woocommerce_product_color_bg_add_to_cart_hover', '#333');
    $borderAddToCartHover = get_theme_mod('otf_woocommerce_product_color_border_add_to_cart_hover', '#333');

    $QuickView = get_theme_mod('otf_woocommerce_product_color_quick_view', '#fff');
    $bgQuickView = get_theme_mod('otf_woocommerce_product_color_bg_quick_view', '#333');
    $borderQuickView = get_theme_mod('otf_woocommerce_product_color_border_quick_view', '#333');
    $QuickViewHover = get_theme_mod('otf_woocommerce_product_color_quick_view_hover', '#fff');
    $bgQuickViewHover = get_theme_mod('otf_woocommerce_product_color_bg_quick_view_hover', '#333');
    $borderQuickViewHover = get_theme_mod('otf_woocommerce_product_color_border_quick_view_hover', '#333');

    $WishList = get_theme_mod('otf_woocommerce_product_color_wish_list', '#fff');
    $bgWishList = get_theme_mod('otf_woocommerce_product_color_bg_wish_list', '#333');
    $borderWishList = get_theme_mod('otf_woocommerce_product_color_border_wish_list', '#333');
    $WishListhover = get_theme_mod('otf_woocommerce_product_color_wish_list_hover', '#fff');
    $bgWishListHover = get_theme_mod('otf_woocommerce_product_color_bg_wish_list_hover', '#333');
    $borderWishListHover = get_theme_mod('otf_woocommerce_product_color_border_wish_list_hover', '#333');

    $Compare = get_theme_mod('otf_woocommerce_product_color_compare', '#fff');
    $bgCompare = get_theme_mod('otf_woocommerce_product_color_bg_compare', '#333');
    $borderCompare = get_theme_mod('otf_woocommerce_product_color_border_compare', '#333');
    $CompareHover = get_theme_mod('otf_woocommerce_product_color_compare_hover', '#fff');
    $bgCompareHover = get_theme_mod('otf_woocommerce_product_color_bg_compare_hover', '#333');
    $borderCompareHover = get_theme_mod('otf_woocommerce_product_color_border_compare_hover', '#333');


    $cssCode = <<<CSS
[class*="product-style-"] ul.products li.product .product-block a[class*="product_type_"]
{
    color: {$AddToCart};
    background-color: {$bgAddToCart};
    border-color: {$borderAddToCart};
}

[class*="product-style-"] ul.products li.product .product-block a[class*="product_type_"]:hover
{
    color: {$AddToCartHover};
    border-color: {$borderAddToCartHover};
    background-color: {$bgAddToCartHover};
}

[class*="product-style-"] ul.products li.product .product-block a[class*="product_type_"]:before 
{
    color: {$AddToCart};
}
[class*="product-style-"] ul.products li.product .product-block a[class*="product_type_"]:hover::before 
{
    color: {$AddToCartHover};
}

/*Wishlist*/
[class*="product-style-"] ul.products li.product .product-block .yith-wcwl-add-to-wishlist > div > a
{
    background-color: {$bgWishList};
}

[class*="product-style-"] ul.products li.product .product-block .yith-wcwl-add-to-wishlist > div > a:before {
    color: {$WishList};
}

[class*="product-style-"] ul.products li.product .product-block .yith-wcwl-add-to-wishlist > div > a, [class*="product-style-"] li.product .product-block .yith-wcwl-add-to-wishlist
{
    border-color: {$borderWishList};
}
[class*="product-style-"] ul.products li.product .product-block .yith-wcwl-add-to-wishlist > div > a:hover
{
    background-color: {$bgWishListHover};
    border-color: {$borderWishListHover};
}
[class*="product-style-"] ul.products li.product .product-block .yith-wcwl-add-to-wishlist > div > a:hover::before
{
    color: {$WishListhover};
}

/*commpare*/
[class*="product-style-"] ul.products li.product .product-block .compare {
    background-color: {$bgCompare};
}

[class*="product-style-"] ul.products li.product .product-block .compare:before
{
    color: {$Compare};
}

[class*="product-style-"] ul.products li.product .product-block .compare, [class*="product-style-"] li.product .product-block .compare-button
{
    border-color: {$borderCompare};
}

[class*="product-style-"] ul.products li.product .product-block .compare:hover
{
   background-color: {$bgCompareHover};
   border-color: {$borderCompareHover};
}

[class*="product-style-"] ul.products li.product .product-block .compare:hover::before
{
    color: {$CompareHover};
}
/*quick view*/
[class*="product-style-"] ul.products li.product .product-block .yith-wcqv-button
{
    background-color: {$bgQuickView};
}
[class*="product-style-"] ul.products li.product .product-block .yith-wcqv-button
{
    border-color: {$borderQuickView};
}
[class*="product-style-"] ul.products li.product .product-block .yith-wcqv-button:before, .product-style-2 li.product .product-block .yith-wcqv-button, .product-style-11 li.product .product-block .yith-wcqv-button 
{
    color: {$QuickView};
}
[class*="product-style-"] ul.products li.product .product-block .yith-wcqv-button:hover
{
    background-color: {$bgQuickViewHover};
    border-color: {$borderQuickViewHover};
}
[class*="product-style-"] ul.products li.product .product-block .yith-wcqv-button:hover::before, .product-style-2 li.product .product-block .yith-wcqv-button:hover, .product-style-11 li.product .product-block .yith-wcqv-button:hover 
{
    color: {$QuickViewHover};
}


CSS;

}
$SaleFlash = get_theme_mod('otf_woocommerce_product_color_label_sale', '#fff');
$bgSaleFlash = get_theme_mod('otf_woocommerce_product_color_bg_label_sale', '#000');
$borderSaleFlash = get_theme_mod('otf_woocommerce_product_color_border_label_sale', '#333');

$cssCode .= <<<CSS
/*sale*/
[class*="product-style-"] li.product .product-block .onsale,[class*="product-style-"] li.product .product-block .onsale:before 
{
    background-color: {$bgSaleFlash};
    color: {$SaleFlash};
    border-color: {$borderSaleFlash};
}
CSS;

return $cssCode;