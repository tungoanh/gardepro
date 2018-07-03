<?php
if (!defined('ABSPATH')) {
    die('-1');
}
$atts = shortcode_atts(
    array(
        'title'            => esc_html__('Vertical menu', 'ezboozt'),
        'menu'             => '',
        'bg_title'         => 'primary',
        'bg_title_custom'  => '#000',
        'show_on_hover'    => true,
        'type'             => '',
        'photo'            => '',
        'icon_fontawesome' => '',
        'icon_openiconic'  => '',
        'icon_typicons'    => '',
        'icon_entypo'      => '',
        'icon_linecons'    => '',
        'icon_monosocial'  => '',
        'icon_material'    => '',
    ), $atts, 'otf_vertical_menu'
);
extract($atts);

if (!has_nav_menu('vertical')) {
    return '';
}

$classes = $show_on_hover ? 'show-on-hover' : 'opened-menu';
$css     = '';
if ($bg_title === 'custom') {
    $css = "background-color: " . esc_attr($bg_title_custom);
}
$args = array(
    'container_class' => 'otf-vertical-menu mainmenu-container',
    'menu_class'      => 'nav navbar-nav navbar-vertical-mega',
    'theme_location'  => 'vertical'
);
if (class_exists('OTF_Nav_walker')) {
    $args['walker'] = new OTF_Nav_walker();
}

if ($type === 'custom') {
    $img_icon  = wp_get_attachment_url($photo);
    $html_icon = '<img src="' . esc_url_raw($img_icon) . '" alt="">';
} elseif ($type === '') {
    $html_icon = '';
} else {
    if (function_exists('vc_icon_element_fonts_enqueue')) {
        vc_icon_element_fonts_enqueue($type);
        $iconClass = isset(${'icon_' . $type}) ? esc_attr(${'icon_' . $type}) : 'fa fa-adjust';
        $html_icon = '<i class="' . esc_attr($iconClass) . '"></i>';
    }
}

?>
<div class="vertical-navigation <?php echo esc_attr($classes); ?>">
    <span class="menu-opener">
        <span class="menu-open-label typo-heading bg-<?php echo esc_attr($bg_title) ?>"<?php if ($css !== '') { ?> style="<?php echo esc_attr($css) ?>" <?php } ?>>
            <span class="burger-icon"></span>
            <?php echo wp_kses_post($html_icon) . esc_html($title); ?>
        </span>
        <span class="arrow-opener"></span>
    </span>
    <div class="vertical-menu-dropdown">
        <?php wp_nav_menu($args); ?>
    </div>
</div>