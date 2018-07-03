<?php
if (!defined('ABSPATH')) {
    die('-1');
}

$atts = shortcode_atts(array(
    'select_image_source'     => 'library',
    'images'                  => '',
    'images_link'             => '',
    'margin'                  => '30',
    'padding'                 => '0',
    'speed'                   => '5000',
    'slides_per_view'         => '1',
    'autoplay'                => false,
    'show_pagination_control' => false,
    'show_prev_next_buttons'  => false,
    'style_nav'               => '',
    'partial_view'            => false,
    'wrap'                    => false,
    'el_class'                => '',

), $atts, 'otf_image_carousel');
extract($atts);
$values = array();
if ($select_image_source == 'library') {
    $images = explode(',', $images);
} elseif ($select_image_source == 'external') {
    if (function_exists('vc_param_group_parse_atts')) {
        $values = (array)vc_param_group_parse_atts($images_link);
    }
}

?>

<div class="otf-slider <?php echo esc_attr($el_class);
if ($partial_view): echo ' slider-visible'; endif; ?>">
    <div class="owl-carousel owl-theme <?php if ($show_prev_next_buttons): echo ' ' . $style_nav; endif; ?>"
         id="opal-carousel-slider" data-opal-carousel
         data-items="<?php echo esc_attr($slides_per_view); ?>"
         data-dots="<?php echo esc_attr($show_pagination_control); ?>"
         data-nav="<?php echo esc_attr($show_prev_next_buttons); ?>"
         data-loop="<?php echo esc_attr($wrap); ?>" data-autoplay="<?php echo esc_attr($autoplay); ?>"
         data-autoplay-timeout="<?php echo esc_attr($speed); ?>" data-margin="<?php echo esc_attr($margin); ?>"
         data-stage-padding="<?php echo esc_attr($padding); ?>">
        <?php
        if ($select_image_source == 'library'):
            foreach ($images as $img) {
                echo wp_get_attachment_image($img, 'full');
            }
        else:
            foreach ($values as $img) {
                if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $img['link'] ) ) {
                    $img['link'] = 'http://' . $img['link'];
                }
                echo '<img src =' . esc_html($img['link']) . ' alt="' . esc_html($img['link']) . '">';
            }
        endif;
        ?>
    </div>
</div>