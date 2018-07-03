<?php
//Shortcode: [otf_testimonial columns="1" total_items="6" style="style1" class=""]
$atts = shortcode_atts(array(
    'columns'          => 1,
    'total_items'      => 6,
    'style'            => 'style1',
    'color'            => 'color-schema-dark',
    'show_dot'         => false,
    'auto_play'        => true,
    'show_nav'         => true,
    'loop'             => true,
    'interval_timeout' => 5000,
    'el_class'         => '',
    'css'              => ''
), $atts, 'otf_testimonial');
extract($atts);
$nav = ($show_nav) ? 'true' : 'false';
$dot = ($show_dot) ? 'true' : 'false';
$play = ($auto_play) ? 'true' : 'false';
$loop = ($loop) ? 'true' : 'false';
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="otf-testimonials <?php echo esc_attr($style) . ' ' . esc_attr($color) . ' ' . esc_attr($el_class) . ' ' . esc_attr($css_class); ?>">
    <div class="owl-carousel owl-theme" id="opal-carousel-testimonial" data-opal-carousel
         data-items="<?php echo esc_attr($columns); ?>" data-dots="<?php echo esc_attr($dot); ?>"
         data-nav="<?php echo esc_attr($nav); ?>"
         data-loop="<?php echo esc_attr($loop); ?>" data-autoplay="<?php echo esc_attr($play); ?>"
         data-autoplay-timeout="<?php echo esc_attr($interval_timeout); ?>">
        <?php echo do_shortcode($content); ?>
    </div>
</div>