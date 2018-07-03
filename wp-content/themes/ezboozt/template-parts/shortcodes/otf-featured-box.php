<?php
if (!defined('ABSPATH')) {
    die('-1');
}

//Shortcode: [otf_featured_box style="default" title="" subtitle="" information="" btn_text="" btn_link="" el_class="" type=""]
$atts = shortcode_atts(array(
    'style'            => 'style-1',
    'title'            => '',
//    'subtitle'         => '',
    'information'      => '',
    'text_align'       => 'text-left',
    'boxed'            => 'false',
    'hover_style'      => '',
    'color'            => '',
    'v_align'          => 'align-items-start',
    'title_size'       => '18px',
    'btn_text'         => esc_html__('Click here', 'ezboozt'),
    'btn_link'         => '#',
    'el_class'         => '',
    'position'         => '',
    'type'             => '',
    'photo'            => '',
    'icon_fontawesome' => '',
    'icon_openiconic'  => '',
    'icon_typicons'    => '',
    'icon_entypo'      => '',
    'icon_linecons'    => '',
    'icon_monosocial'  => '',
    'icon_material'    => '',
    'icon_webmod'      => '',
    'i_size'           => '30px',
    'i_shape'          => '',
    'i_color'          => '',
    'svg_color'        => '',
    'svg_width'        => '',
    'bg_icon_color'    => '',
    'css'              => '',
), $atts, 'otf_featured_box');
extract($atts);

$html_icon = '';
//parse link
$attributes = array();
$link = ('||' === $btn_link) ? '' : $btn_link;
$link = ezboozt_build_link($link);
$use_link = false;
if (strlen($link['url']) > 0) {
    $use_link = true;
    $a_href = $link['url'];
    $a_title = $link['title'];
    $a_target = $link['target'];
    $a_rel = $link['rel'];
}
if ($use_link) {
    $attributes[] = 'class="btn"';
    $attributes[] = 'href="' . trim($a_href) . '"';
    $attributes[] = 'title="' . esc_attr(trim($a_title)) . '"';
    if (!empty($a_target)) {
        $attributes[] = 'target="' . esc_attr(trim($a_target)) . '"';
    }
    if (!empty($a_rel)) {
        $attributes[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
    }
    if (empty($btn_text)) {
        $btn_text = $a_title;
    }
}
$attributes = implode(' ', $attributes);
if ($type === 'custom') {
    $img_icon = wp_get_attachment_url($photo);
    $filetype = wp_check_filetype($img_icon);
    if ($filetype['type'] === 'image/svg+xml') {
        $pathsvg = get_attached_file($photo);
        $html_icon = otf_get_icon_svg($pathsvg, $svg_color, $svg_width);
    } else {
        $html_icon = '<img src="' . esc_url_raw($img_icon) . '" alt="' . esc_attr($title) . '">';
    }
} elseif ($type === '') {
    $html_icon = '';
} else {
    if (function_exists('vc_icon_element_fonts_enqueue')) {
        vc_icon_element_fonts_enqueue($type);
        $iconClass = isset(${'icon_' . $type}) ? esc_attr(${'icon_' . $type}) : 'fa fa-adjust';
        $html_icon = '<i class="' . esc_attr($iconClass) . '"></i>';
    }
}
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_editor = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'otf_featured_box', $atts);
$class = $style . ' ' . $text_align . ' ' . $el_class . ' ' . $v_align . ' ' . $css_editor .' ' .$hover_style;
$id = 'otf' . wp_generate_uuid4();
?>
    <div id="<?php echo esc_attr($id); ?>" class="otf-feature-box <?php echo esc_attr($class); ?>">
        <div class="box-icon <?php echo esc_attr($i_shape); ?>">
            <div><?php echo trim($html_icon); ?></div>
        </div>
        <div class="meta <?php if ($position == 'right'): echo 'order-first'; endif; ?>">
            <?php if (!empty($title)): ?>
                <h4 class="title"><?php echo esc_html($title); ?></h4>
            <?php endif; ?>
            <?php if (!empty($content)): ?>
                <div class="information"><?php echo wp_kses_post(otf_sanitize_editor($content)); ?></div>
            <?php endif; ?>
            <?php if ($use_link): ?>
                <div>
                    <a <?php echo trim($attributes); ?>><?php echo esc_html($btn_text); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
$properti = 'background';
if ($i_shape == 'o-squal' || $i_shape == 'o-round') {
    $properti = 'border-color';
}
new OTF_CSS(array(
    $id . ' .title'    => array(
        'font-size' => $title_size,
        'color'     => $color,
    ),
    $id . ' .box-icon' => array(
        'font-size' => $i_size,
        $properti   => $bg_icon_color,
    ),
    $id . ' i'         => array(
        'color' => $i_color,
    ),
));
