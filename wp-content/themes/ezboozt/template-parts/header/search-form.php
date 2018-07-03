<?php
$classes = '';

if (!empty($atts['button_color'])) {
    $classes .= ' ' . $atts['button_color'].'-button';
}
if (!empty($atts['border_color'])) {
    $classes .= ' ' . $atts['border_color'].'-border';
}
if (!empty($atts['css'])) {
    $classes .= ' ' . $atts['css'];
}
if (!empty($atts['el_class'])) {
    $classes .= ' ' . $atts['el_class'];
}
if(!empty($atts['style'])) {
    $classes .= ' ' . $atts['style'];
}

echo '<div class="search-form-wapper' . esc_attr($classes) . '">';
if (class_exists('DGWT_WC_Ajax_Search')) {
    $_id = wp_generate_uuid4();
    echo preg_replace('#(id|for)="dgwt-wcas-search"#', '$1="dgwt-wcas-search-' . $_id . '"', ezboozt_do_shortcode('wcas-search-form') . '');
} else {
    get_search_form();
}
echo '</div>';
