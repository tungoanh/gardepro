<?php
$cssCode = '';

// ==================================================
//  Container Width
// ==================================================
$containerSelector = '.container, #content ,.submenu-fullwidth .sub-menu-inner';
$containerType     = get_theme_mod('otf_layout_general_content_width_type', 'px');
if ('px' === $containerType) {
    $containerPx = get_theme_mod('otf_layout_general_content_width_px', 1170);
    $cssCode     .= <<<CSS
@media screen and (min-width: 1200px){
    {$containerSelector}{
        max-width: {$containerPx}px;
    }
}

@media (min-width: {$containerPx}px) {
  .vc_row[data-vc-full-width],
  section[data-vc-full-width] {
    left: calc((-100vw + {$containerPx}px) / 2); }
  .vc_row[data-vc-full-width]:not([data-vc-stretch-content]),
  section[data-vc-full-width]:not([data-vc-stretch-content]) {
    padding-left: calc((100vw - {$containerPx}px) / 2);
    padding-right: calc((100vw - {$containerPx}px) / 2); }
  .platform-windows .vc_row[data-vc-full-width],
  .platform-windows section[data-vc-full-width] {
    left: calc((-100vw + {$containerPx}px + 17px) / 2); }
  .platform-windows .vc_row[data-vc-full-width]:not([data-vc-stretch-content]),
  .platform-windows section[data-vc-full-width]:not([data-vc-stretch-content]) {
    padding-left: calc((100vw - {$containerPx}px - 17px) / 2);
    padding-right: calc((100vw - {$containerPx}px - 17px) / 2); } }
CSS;

} elseif ('%' === $containerType) {
    $containerPercent = get_theme_mod('otf_layout_general_content_width_percent', 100);
    $cssCode          .= <<<CSS
@media screen and (min-width: 768px){
    {$containerSelector}{
        width: {$containerPercent}%;
    }
}
CSS;
}
//
//// ==================================================
////  Boxed Container Width
//// ==================================================
$layoutMode             = get_theme_mod('otf_layout_general_layout_mode', 'wide');
$containerBoxedSelector = 'body.opal-layout-boxed';
if ('boxed' == $layoutMode) {
    $containerBoxedPx     = get_theme_mod('otf_layout_general_layout_boxed_width', 1170);
    $containerBoxedOffset = get_theme_mod('otf_layout_general_layout_boxed_offset', 20);
    $cssCode              .= <<<CSS
@media screen and (min-width: {$containerBoxedPx}px){
    {$containerBoxedSelector}{
        margin: ${containerBoxedOffset}px auto;
        width: {$containerBoxedPx}px;
    }
    
    {$containerBoxedSelector} #opal-header-sticky{
        left: auto!important;
        width: {$containerBoxedPx}px;
    }
}
CSS;

}

//// ==================================================
////  Gutter
//// ==================================================
$gutter_width = get_theme_mod('otf_layout_general_gutter_width', 30);
if ($gutter_width && $gutter_width != 30) {
    $gutter_width = $gutter_width / 2;
    $cssCode      .= <<<CSS
.col-1, .col-2, .col-3, .col-4, .opal-comment-form-2 .comment-form .comment-form-author, .opal-comment-form-3 .comment-form .comment-form-author, .opal-comment-form-2 .comment-form .comment-form-email, .opal-comment-form-3 .comment-form .comment-form-email, .opal-comment-form-2 .comment-form .comment-form-url, .opal-comment-form-3 .comment-form .comment-form-url, .col-5, .col-6, .opal-comment-form-4 .comment-form .comment-form-author, .opal-comment-form-4 .comment-form .comment-form-email, .opal-comment-form-4 .comment-form .comment-form-url, .opal-comment-form-6 .comment-form .comment-form-author, .opal-comment-form-6 .comment-form .comment-form-email, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .opal-comment-form-2 .comment-form .logged-in-as, .opal-comment-form-3 .comment-form .logged-in-as, .opal-comment-form-2 .comment-form .comment-notes, .opal-comment-form-3 .comment-form .comment-notes, .opal-comment-form-2 .comment-form .comment-form-comment, .opal-comment-form-3 .comment-form .comment-form-comment, .opal-comment-form-2 .comment-form .form-submit, .opal-comment-form-3 .comment-form .form-submit, .opal-comment-form-6 .comment-form .logged-in-as, .opal-comment-form-6 .comment-form .comment-notes, .opal-comment-form-6 .comment-form .comment-form-comment, .opal-comment-form-6 .comment-form .comment-form-url, .opal-comment-form-6 .comment-form .form-submit, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, body.blog:not(.opal-blog-layout-1c) #secondary, .site-footer .widget-area .widget-column, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, body.blog:not(.opal-blog-layout-1c) #primary, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto
{
    padding-left: {$gutter_width}px;
    padding-right: {$gutter_width}px;
}
CSS;

}

//==================================================
// Archive Property
//==================================================
$property_archive_padding_top    = get_theme_mod('otf_property_archive_padding_top', 60);
$property_archive_padding_bottom = get_theme_mod('otf_property_archive_padding_bottom', 60);

$cssCode .= '@media screen and (min-width: 48em) {';
$cssCode .= <<<CSS
    body.opal-property-archive .site-content {
        padding-top:{$property_archive_padding_top}px;
        padding-bottom:{$property_archive_padding_bottom}px;
    }
CSS;
$cssCode .= '}';

//==================================================
// Single Property
//==================================================
$property_archive_padding_top    = get_theme_mod('otf_property_single_padding_top', 60);
$property_archive_padding_bottom = get_theme_mod('otf_property_single_padding_bottom', 60);

$cssCode .= '@media screen and (min-width: 48em) {';
$cssCode .= <<<CSS
    body.opal-property-single .site-content {
        padding-top:{$property_archive_padding_top}px;
        padding-bottom:{$property_archive_padding_bottom}px;
    }
CSS;
$cssCode .= '}';


//Main layout config with page setting
//===============
//if(is_page()) {
//    $padding_top = otf_get_metabox( get_the_ID(), 'otf_padding_top', 15 );
//    $padding_bottom  = otf_get_metabox( get_the_ID(), 'otf_padding_bottom', 15);
//    $cssCode .= <<<CSS
//.site-content-contain .site-content{
//    padding-top: {$padding_top}px;
//    padding-bottom: {$padding_bottom}px;
//}
//CSS;
//}

return $cssCode;