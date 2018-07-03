<?php

$atts = shortcode_atts(array(
    'columns'      => 4,
    'show_dot'     => false,
    'show_nav'     => true,
    'style_nav'        => 'nav-style-1',
    'el_class'     => '',
    'css'          => ''
), $atts, 'otf_slider');
extract($atts);

$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
$dot = ($show_dot) ? 'true' : 'false';
$nav = ($show_nav) ? 'true' : 'false';

?>
<div class="otf-slider <?php echo esc_attr($css_class);?>">
    <?php echo '<div class="owl-carousel owl-theme '. esc_attr($style_nav).'" data-opal-carousel data-items="' . esc_attr($columns) . '" data-dots="' . esc_attr($dot) . '" data-nav="' . esc_attr($nav) . '">'; ?>
    <?php echo do_shortcode($content); ?>
</div>
</div>

