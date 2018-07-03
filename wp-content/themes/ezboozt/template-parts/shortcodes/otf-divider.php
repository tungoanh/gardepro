<?php
/**
 * @var $this OTF_Shortcode
 */
$atts = shortcode_atts(array(
    'position'        => 'top',
    'color'           => '#e1e1e1',
    'style'           => 'waves-small',
    'custom_height'   => '',
    'css'             => '',
    'el_class'        => '',
), $atts, 'otf_divider');

extract($atts);

$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$classes = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'otf_divider', $atts);
$divider = $this->get_svg_divider($style . '-' . $position, $color, $custom_height);

$classes .= ' dvr-position-' . $position;
$classes .= ' dvr-style-' . $style;

($el_class != '') ? $classes .= ' ' . $el_class : false;
?>
    <div class="opal-row-divider <?php echo esc_attr($classes); ?>">
        <?php echo($divider); ?>
    </div>
<?php

