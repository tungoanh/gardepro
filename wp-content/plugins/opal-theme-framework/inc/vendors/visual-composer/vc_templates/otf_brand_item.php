<?php
$atts = shortcode_atts(array(
    'link'                => '#',
    'select_image_source' => 'library',
    'photo'               => '',
    'external_link_photo' => '',
    'title'               => '',
    'image_size'          => 'full',
    'css'                 => ''
), $atts, 'otf_brand_item');
extract($atts);
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
$thumb_size = otf_get_image_size($image_size);

if ($select_image_source == 'library') {
    $thumbnail = wpb_resize($photo, null, $thumb_size[0], $thumb_size[1], true);
} elseif ($select_image_source == 'external') {
    if (!preg_match('/^(https?\:\/\/|\/\/)/', $external_link_photo)) {
        $external_link_photo = 'http://' . $external_link_photo;
    }
    $thumbnail['url'] = $external_link_photo;
}
?>
<div class="item brand column-item <?php echo esc_attr($css_class); ?>">
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" target="_blank">
        <img src="<?php echo esc_url($thumbnail['url']) ?>" width="<?php echo esc_attr($thumbnail['width']); ?>"
             height="<?php echo esc_attr($thumbnail['height']); ?>" alt="<?php echo esc_attr($title) ?>">
    </a>
</div>