<?php
if (!defined('ABSPATH')) {
    die('-1');
}
//global $woocommerce;
$atts = shortcode_atts(array(
    'id'                => '',
    'product_name'      => '',
    'product_image'     => '',
    'main_duration'     => 0.5,
    'enable_reverse'    => true,
    'bg_duration'       => 0.5,
    'bg_enable_reverse' => true,

), $atts, 'otf_product_parallax');
extract($atts);

$main_image = wp_get_attachment_image_src( $product_image, 'full' );
if (!empty($id)) {
    $_product = wc_get_product($id);
    ?>
    <div class="oft_product_parallax text-center">
        <div class="opal-parallax" data-reverse="<?php echo esc_attr( $enable_reverse ); ?>"
             data-duration="<?php echo esc_attr(floatval( $main_duration )); ?>">
                <h3 class="product_title">
                    <a href="<?php echo esc_url($_product->get_permalink()); ?>"><?php if(!empty($product_name)){
                        echo esc_attr($product_name);
                    }
                    else {
                        echo esc_attr($_product->get_name());
                    }
                    ?></a>
                </h3>
            <a href="<?php echo esc_url($_product->get_permalink()); ?>">
            <?php
            if (!empty( $main_image ) && isset( $main_image[0] )){
                ?>
                <img src="<?php echo esc_url_raw( $main_image[0] ); ?>">
            <?php
            }
            else {
                echo wp_kses_post($_product->get_image());
            }
            ?></a>
        </div>
        <div class="parallax-background-content">
            <div class="opal-parallax pl-absolute" data-reverse="<?php echo esc_attr(floatval( $bg_enable_reverse )); ?>"
                 data-duration="<?php echo esc_attr(floatval( $bg_duration )); ?>">
                <div><?php echo wp_kses_post($content) ?></div>
            </div>
        </div>
    </div>

    <?php
}
?>