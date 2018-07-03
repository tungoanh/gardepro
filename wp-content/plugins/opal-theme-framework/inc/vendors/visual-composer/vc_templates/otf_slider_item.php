<?php
$atts = shortcode_atts(array(
    'photo' => '',
    'title' => '',
    't_size' => '30',
    't_color' => '',
    't_fontweight' => 'normal',
    't_alignment' => 'left',
    'css_class' => '',
    'image_size' => 'full',
), $atts, 'otf_slider_item');
extract($atts);
$values = array();
$thumb_size = otf_get_image_size($image_size);
$thumbnail = wpb_resize($photo, null, $thumb_size[0], $thumb_size[1], true);
$css = 'style="';
if (!empty($t_size)) {
    $size = preg_replace('/[^0-9]/', '', $t_size);
    $css .= 'font-size:' . esc_attr($size) . 'px;';
}
if (!empty($t_color)) {
    $css .= 'color:' . $t_color . ';';
}
if (!empty($t_fontweight)) {
    $css .= 'font-weight:' . $t_fontweight . ';';
}
$css .= 'text-align:' . esc_attr($t_alignment) . ';"';
?>

<div class="item-slider column-item">
    <div class="slider-wrapper row">
        <div class="col-md-6">
            <img class="img-responsive" src="<?php echo esc_url($thumbnail['url']) ?>"
                 width="<?php echo esc_attr($thumbnail['width']); ?>"
                 height="<?php echo esc_attr($thumbnail['height']); ?>" alt="<?php echo esc_attr($name) ?>">
        </div>
        <div class="slider-content col-md-6 d-flex align-items-center">
            <?php
            if (!empty($content)): ?>
                <div class="information p-lg-5 py-4">
                    <?php
                    if (!empty($title)):
                        echo '<h2 class="item-slider-title typo-heading '. esc_attr($css_class).'" ' . $css . ' >' . esc_attr($title) . '</h2>';
                    endif;
                    echo wp_kses_post(otf_sanitize_editor($content)); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>