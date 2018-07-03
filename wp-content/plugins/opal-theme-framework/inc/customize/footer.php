<?php
$cssCode     = '';
$footer_skin = get_theme_mod( 'otf_colors_footer_skin', 'light' );


$footer_background_color    = ariColor::new_color( get_theme_mod( 'otf_colors_footer_bg', '#fff' ) );
$footer_color               = ariColor::new_color( get_theme_mod( 'otf_colors_footer_color', '#000' ) );
$footer_text_color          = $footer_color->get_new( 'lightness', $footer_color->lightness - 20 )->toCSS();
$footer_link_hover_color    = $footer_color->get_new( 'lightness', $footer_color->lightness - 40 )->toCSS();
$footer_border_color        = $footer_color->get_new( 'lightness', $footer_color->lightness - 70 )->toCSS();
$copyright_background_color = get_theme_mod( 'otf_colors_copyright_bg', '#fff' );
$copyright_color            = get_theme_mod( 'otf_colors_copyright_color', '#000' );


if ($footer_skin === 'custom'):
    $cssCode
        .= <<<CSS
.opal-footer-skin-custom .site-footer {
    background-color: {$footer_background_color->toCSS( 'rgba' )};
}
    
.opal-footer-skin-custom .site-footer a, .opal-footer-skin-custom .site-footer h2.widget-title, .opal-footer-skin-custom .site-footer h2.widgettitle, .opal-footer-skin-custom .site-footer .vc_custom_heading {
    color: {$footer_color->toCSS()};
}
.opal-footer-skin-custom .site-footer, .opal-footer-skin-custom .site-footer a {
    color: {$footer_color->toCSS()};
}
.opal-footer-skin-custom .site-footer a:hover {
    color: $footer_link_hover_color;
}
.opal-footer-skin-custom .site-footer .widget ul li {
    border-color: $footer_border_color;
}
.opal-footer-skin-custom .site-footer .social-navigation li a:hover {
    color: #fff;
}

.opal-footer-skin-custom .site-info {
    background-color: $copyright_background_color;
}

.opal-footer-skin-custom .site-info {
    color: $copyright_color;
}
CSS;
endif;


// Typography
$heading_font_size      = get_theme_mod( 'otf_typography_footer_widget_title_font_size', 16 );
$heading_letter_spacing = get_theme_mod( 'otf_typography_footer_widget_title_letter_spacing', 2 );
$heading_padding_top = get_theme_mod( 'otf_typography_footer_widget_title_padding_top', 15 );
$heading_padding_bottom = get_theme_mod( 'otf_typography_footer_widget_title_padding_bottom', 15);
$heading_margin_top  = get_theme_mod( 'otf_typography_footer_widget_title_margin_top', 0 );
$heading_margin_bottom  = get_theme_mod( 'otf_typography_footer_widget_title_margin_bottom', 20 );
$footer_font_style      = get_theme_mod( 'otf_typography_footer_widget_title_font_style' );
$footer_padding_top = get_theme_mod( 'otf_footer_padding_top', 50 );
$footer_font_style_css  = '';
$footer_css = '';
$footer_font = get_theme_mod('otf_typography_footer_font_family');
if (is_array($footer_font)) {
    if ($footer_font['family']) {
        $footer_css .= "font-family:\"{$footer_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset($footer_font['fontWeight'])) {
        $footer_css .= "font-weight:{$footer_font['fontWeight']};";
    }
}
if (is_array( $footer_font_style )){
    if ($footer_font_style['italic']){
        $footer_font_style_css .= "font-style:italic;";
    }
    if ($footer_font_style['underline']){
        $footer_font_style_css .= "text-decoration:underline;";
    }
    if ($footer_font_style['fontWeight']){
        $footer_font_style_css .= "font-weight:bold;";
    }
    if ($footer_font_style['uppercase']){
        $footer_font_style_css .= "text-transform:uppercase;";
    }
}
$cssCode .= <<<CSS
.site-footer {
  padding-top: {$footer_padding_top}px;
}
.site-footer .vc_custom_heading,.site-footer .widget-title,.site-footer .widgettitle{
    font-size: {$heading_font_size}px;
    letter-spacing: {$heading_letter_spacing}px;
    padding-top: {$heading_padding_top}px;
    padding-bottom: {$heading_padding_bottom}px;
    margin-top: {$heading_margin_top}px;
    margin-bottom: {$heading_margin_bottom}px;
    {$footer_font_style_css}
    {$footer_css}
}
CSS;


return $cssCode;
