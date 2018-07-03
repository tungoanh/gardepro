<?php
if (!defined('ABSPATH')) {
    die('-1');
}

//Shortcode: [otf_featured_box style="default" title="" subtitle="" information="" btn_text="" btn_link="" el_class="" type=""]
$atts = shortcode_atts(array(
    'h_align'             => 'text-left',
    'v_align'             => 'justify-content-start',
    'display'             => 'd-block',
    'align'               => '',
    'el_class'            => '',
    'select_image_source' => 'library',
    'photo'               => '',
    'external_link_photo' => '',
    'effect_inside'       => '',
    'effect_outside'      => '',
    'color'               => 'color-schema-dark',
    'css'                 => '',
    'image_size'          => 'full'
), $atts, 'otf_promo_banner');
extract($atts);
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'otf_promo_banner', $atts);
$img_size = otf_get_image_size($image_size);
if($select_image_source == 'library') {
    $img_icon = wpb_resize($photo, null, $img_size[0], $img_size[1], true);
}elseif ($select_image_source == 'external'){
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $external_link_photo ) ) {
        $external_link_photo = 'http://' . $external_link_photo;
    }
    $img_icon['url'] = $external_link_photo;
    $img_icon['width'] = $img_size[0];
    $img_icon['height'] = $img_size[1];
}
?>
<div class="otf-promo-banner <?php echo esc_attr($display) . ' ' . esc_attr($el_class) . ' ' . esc_attr($align) . ' ' . esc_attr($css_class) . ' ' . esc_attr($color) . ' ' . esc_attr($effect_outside); ?>">
    <div class="banner-image">
        <div class="banner-image-inner">
            <img class="w-100 d-block" src="<?php echo esc_url_raw($img_icon['url']); ?>"
                 width="<?php echo esc_attr($img_icon['width']) ?>" height="<?php echo esc_attr($img_icon['height']) ?>"
                 alt="">
        </div>
    </div>
    <div class="meta d-flex flex-column <?php echo esc_attr($h_align); ?> <?php echo esc_attr($v_align); ?>">
        <?php echo apply_filters('the_content', $content); ?>
    </div>
</div>
