<?php
if (!defined('ABSPATH')) {
    die('-1');
}

$atts = shortcode_atts(array(
    'style'               => 'default',
    'h_align'             => '',
    'v_align'             => '',
    'el_class'            => '',
    'category'            => '',
    'disable_subtitle'    => 'false',
    'select_image_source' => 'library',
    'photo'               => '',
    'external_link_photo' => '',
    'image_size'          => 'full',
    'effect_inside'       => '',
    'effect_outside'      => '',
    'color'               => 'color-schema-dark',
    'css'                 => ''
), $atts, 'otf_promo_banner');
extract($atts);
$product_cat = get_term_by('slug', $category, 'product_cat');
if (!$product_cat) {
    return;
}
$query = new WP_Query(array(
    'tax_query' => array(
        array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => $category,
            'include_children' => true,
        ),
    ),
    'nopaging'  => true
));
$args = array(
    'hierarchical'     => 1,
    'show_option_none' => '',
    'hide_empty'       => 0,
    'parent'           => $product_cat->term_id,
    'taxonomy'         => 'product_cat'
);
$subcats = get_categories($args);
$image_size = otf_get_image_size($image_size);

if ($select_image_source == 'library') {
    $main_image = wpb_resize($photo, null, $image_size[0], $image_size[1], true);
} elseif ($select_image_source == 'external') {
    if (!preg_match('/^(https?\:\/\/|\/\/)/', $external_link_photo)) {
        $external_link_photo = 'http://' . $external_link_photo;
    }
    $main_image['url'] = $external_link_photo;
    $main_image['width'] = $image_size[0];
    $main_image['height'] = $image_size[1];

}
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'otf_promo_banner', $atts);
$el_class .= ' ' . $style . ' ' . $effect_inside . ' ' . $effect_outside . ' ' . $color . ' ' . $css_class;

?>

<div class="otf-product-category otf-promo-banner <?php echo esc_attr($el_class); ?>">
    <a href="<?php echo get_term_link($product_cat->term_taxonomy_id); ?>">
        <div class="banner-image">
            <div class="banner-image-inner">
                <img class="w-100" src="<?php echo esc_url_raw($main_image['url']); ?>"
                     width="<?php echo esc_attr($main_image['width']) ?>"
                     height="<?php echo esc_attr($main_image['height']) ?>" alt="">
            </div>

        </div>
        <div class="meta d-flex flex-column <?php echo esc_attr($h_align); ?> <?php echo esc_attr($v_align); ?>">
            <h2 class="title">
                <?php echo esc_html($product_cat->name); ?>
            </h2>
            <?php if ($disable_subtitle == false): ?>
                <div class="subtitle">
                    <?php echo esc_html($query->post_count); ?><span><?php esc_html_e('products', 'ezboozt') ?></span>
                </div>
            <?php endif; ?>
        </div>
    </a>
    <?php if ($style == 'style-5'): ?>
        <ul class="sub-categories">
            <?php
            foreach ($subcats as $subcat) {
                echo '<li class="sub-categories-item"><a href="' . get_term_link($subcat->slug, $subcat->taxonomy) . '">' . $subcat->name . '</a></li>';
            }
            ?>
        </ul>
    <?php endif; ?>
</div>
