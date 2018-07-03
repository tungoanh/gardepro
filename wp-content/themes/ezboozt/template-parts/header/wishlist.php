<?php
$classes = '';
if (!empty($atts['css'])) {
    $classes = ' ' . $atts['css'];
}
?>
<div class="site-header-wishlist d-inline-block <?php echo esc_attr($classes); ?>">
    <a class="opal-header-wishlist header-button"
       href="<?php echo esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))); ?>">
        <i class="icon icon-483" aria-hidden="true"></i>
        <span class="count"><?php echo esc_html(yith_wcwl_count_all_products()); ?></span>
    </a>
</div>
