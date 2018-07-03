<?php

$atts = shortcode_atts(array(
    'style'        => 'style-1',
    'columns'      => 4,
    'layout'       => 'grid',
    'columns_grid' => 3,
    'show_dot'     => false,
    'show_nav'     => true,
    'el_class'     => '',
    'css'          => ''
), $atts, 'otf_team');
extract($atts);

$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$start_wrap = '';
if ($layout === 'grid') {
    $start_wrap = '<div class="row" data-opal-columns="' . esc_attr($columns_grid) . '">';
} else if ($layout === 'carousel') {
    $dot = ($show_dot) ? 'true' : 'false';
    $nav = ($show_nav) ? 'true' : 'false';
    $start_wrap = '<div class="owl-carousel owl-theme" data-opal-carousel data-items="' . esc_attr($columns) . '" data-dots="' . esc_attr($dot) . '" data-nav="' . esc_attr($nav) . '">';
}
?>
<div class="otf-teams otf-teams-<?php echo esc_attr($style) . ' ' . esc_attr($el_class) . ' ' . esc_attr($css_class); ?>">
    <?php echo apply_filters('themebase_otf_team_start', $start_wrap); ?>
    <?php echo do_shortcode($content); ?>
</div>
</div>

