<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract($atts);
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
$style .= ' '. $css_class;
echo otf_do_shortcode('mc4wp_form', array(
    'id'=> $form_id,
    'element_class' => $style
));