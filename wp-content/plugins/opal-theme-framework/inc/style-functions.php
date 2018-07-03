<?php
/**
 * @return string
 */
function otf_theme_custom_css() {
    $a1root = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/a1root.php';
    $grid = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/grid.php';
    $main_menu = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/main-menu.php';
    $vertical_menu = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/vertical-menu.php';
    $button_animation = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/button-animation.php';
    $button = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/button.php';
    $error_404 = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/error-404.php';
    $footer = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/footer.php';
    $header = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/header.php';
    $heading = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/heading.php';
    $main_layout = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/main-layout.php';
    $offcanvas_menu = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/offcanvas-menu.php';
    $page_bg = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/page-bg.php';
    $quote = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/quote.php';
//    $side_header         = include trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_DIR ) . 'inc/customize/side-header.php';
    $sidebar = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/sidebar.php';
    $widget = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/widget.php';
    $woocommerce_product = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/woocommerce-product.php';
    $css = <<<CSS
{$a1root}
{$grid}
{$main_menu}
{$vertical_menu}
{$button_animation}
{$error_404}
{$footer}
{$header}
{$heading}
{$main_layout}
{$offcanvas_menu}
{$page_bg}
{$quote}
{$sidebar}
{$widget}
{$woocommerce_product}
{$button}
CSS;

    $css = apply_filters('otf_theme_customizer_css', $css);
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}

/**
 * @return string
 */
function otf_theme_custom_css_no_cache($css) {
    $sidebar_width = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/sidebar-width.php';
    $css .= $sidebar_width;
    global $otf_header;
    if ($otf_header) {
        $header_css = get_post_meta($otf_header->ID, '_wpb_shortcodes_custom_css', true);
        $css .= $header_css;
    }

    // Footer Css
    $footer_id = get_theme_mod('otf_footer_layout');
    $page_id = get_the_ID();

    if (is_page() && otf_get_metabox(get_the_ID(), 'otf_enable_custom_footer', false)) {
        $footer_id = otf_get_metabox($page_id, 'otf_footer_layout', false);
        $footer_padding_top = otf_get_metabox(get_the_ID(), 'otf_footer_padding_top', 15);
        $css .= '.site-footer {padding-top:' . $footer_padding_top . 'px!important;}';
    }
    if ($footer_id) {
        $footer_css = get_post_meta($footer_id, '_wpb_shortcodes_custom_css', true);
        $css .= $footer_css;
    }

    // Padding Page
    if (is_page()) {
        $padding_top = otf_get_metabox($page_id, 'otf_padding_top', 0);
        $padding_bottom = otf_get_metabox($page_id, 'otf_padding_bottom', 0);
        if (is_front_page()) {
            $css .= '.panel-content .wrap{padding-top:' . $padding_top . 'px!important;}';
            $css .= '.panel-content .wrap{padding-bottom:' . $padding_bottom . 'px!important;}';
        } else {
            $css .= '.site-content{padding-top:' . $padding_top . 'px!important;}';
            $css .= '.site-content{padding-bottom:' . $padding_bottom . 'px!important;}';
        }
    }

    $page_title = include trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/customize/page-title.php';
    $css .= $page_title;

    return $css;
}

add_filter('otf_theme_custom_inline_css', 'otf_theme_custom_css_no_cache');