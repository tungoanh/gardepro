<?php
//Shortcode: [otf_brand columns="6" total_items="6" layout="grid" class=""]
$atts = shortcode_atts(array(
    'columns'      => 6,
    'total_items'  => 6,
    'layout'       => 'grid',
    'columns_grid' => 3,
    'margin'       => 10,
    'show_dot'     => false,
    'show_nav'     => true,
    'css'            => '',
), $atts, 'otf_brand');
extract($atts);
$start_wrap = $end_wrap = '';
if ($layout === 'grid') {
    $start_wrap = '<div class="row" data-opal-columns="' . esc_attr($columns_grid) . '">';
    $end_wrap = '</div>';
} else {
    if ($layout === 'carousel') {
        $dot = ($show_dot) ? 'true' : 'false';
        $nav = ($show_nav) ? 'true' : 'false';
        $start_wrap = '<div class="owl-carousel owl-theme" data-opal-carousel data-items="' . esc_attr($columns) . '" data-dots="' . esc_attr($dot) . '" data-nav="' . esc_attr($nav) . '" data-margin="' . esc_attr($margin) . '">';
        $end_wrap = '</div>';
    }
}
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="otf-brands <?php echo esc_attr($css_class);?>">
    <?php echo $start_wrap; ?>
    <?php echo do_shortcode($content); ?>
    <?php echo $end_wrap ?>
</div>
