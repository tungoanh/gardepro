<?php
if (!defined('ABSPATH')) {
    die('-1');
}
$atts = shortcode_atts(array(
    'per_page'      => '4',
    'columns'       => '2',
    'style'         => 'grid',
    'show_category' => false,
    'show_rating'   => true,
    'show_except'   => false,
    'image_size'    => '',
    'show_nav'      => 'false',
    'show_dot'      => 'false',
    'nav_position'  => 'middle-center',
    'nav_style'     => 'style-1',
    'is_deal'       => true,
    'el_class'      => '',
), $atts, 'otf_product_deal');
extract($atts);

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => $per_page,
    'post_status'    => 'publish',
    'tax_query'      => WC()->query->get_tax_query(),
    'meta_query'     => array(
        array( // Variable products type
            'key'     => '_sale_price_dates_to',
            'value'   => time(),
            'compare' => '>',
            'type'    => 'numeric',
        ),
        WC()->query->get_meta_query()
    )
);

$loop = new WP_Query($args);
if ($loop->have_posts()) {
    echo '<div class="woocommerce otf-product-deal columns-' . $columns . '">';
    do_action("woocommerce_shortcode_before_otf_product_deal_loop", $atts);
    woocommerce_product_loop_start();
    while ($loop->have_posts()) : $loop->the_post();
        wc_get_template_part('content', 'product');
    endwhile;
    woocommerce_product_loop_end();
    do_action("woocommerce_shortcode_after_otf_product_deal_loop", $atts);
    echo '</div>';
}
wp_reset_postdata();