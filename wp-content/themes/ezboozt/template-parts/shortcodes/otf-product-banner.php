<?php
if (!defined('ABSPATH')) {
    die('-1');
}

$atts = shortcode_atts(array(
    'style'               => 'style-1',
    'el_class'            => '',
    'id'                  => '',
    'select_image_source' => 'library',
    'photo'               => '',
    'external_link_photo' => '',
    'image_size'          => 'full',
    'text_button'         => '',
    'css'                 => ''
), $atts, 'otf_product_banner');
extract($atts);
$_product = wc_get_product($id);
if (!$_product) {
    return;
}

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

if(!empty($text_button)){
    $text = $text_button;
}
$class_to_filter = vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'otf_product_banner', $atts);
$el_class .= ' ' . $style . ' ' . $css_class;
?>
<div class="otf-product-banner <?php echo esc_attr($el_class); ?>">
    <div class="product-banner-wrap text-center">
       <?php if (!empty($content)): ?>
        <div class="information">
            <?php echo wp_kses_post(otf_sanitize_editor($content)); ?>
        </div>
        <?php endif; ?>
        <div class="product-price pr-5 d-inline-block align-middle text-left">
            <div><?php echo esc_attr__('Intro price','ezboozt');?></div>
            <?php echo  $_product->get_price_html();?>
        </div>
        <?php
        echo sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button-primary button %s">%s</a>',
            esc_url( $_product->add_to_cart_url() ),
            esc_attr( $id ),
            esc_attr( $_product->get_sku() ),
            $_product->is_purchasable() ? 'add_to_cart_button ajax_add_to_cart' : '',
            $text ? $text : esc_html( $_product->add_to_cart_text() )
        );
        ?>
        <a href="<?php echo esc_url($_product->get_permalink()); ?>">
            <div class="banner-image">
                <img class="w-100" src="<?php echo esc_url_raw($main_image['url']); ?>"
                     width="<?php echo esc_attr($main_image['width']) ?>"
                     height="<?php echo esc_attr($main_image['height']) ?>" alt="">
            </div>
        </a>
    </div>

</div>
