<?php
if (ezboozt_is_woocommerce_activated()) {
    $classes = '';
    if (!empty($atts['style'])) {
        $classes = $atts['style'];
    }
    if (!empty($atts['css'])) {
        $classes .= ' ' . $atts['css'];
    }
    ?>
    <div class="site-header-cart menu <?php echo esc_attr($classes) ?>">
        <?php echo otf_cart_link(); ?>
        <ul class="shopping_cart <?php echo $atts['alignment'] ?>">
            <li>
                <?php the_widget('WC_Widget_Cart', 'title='); ?>
            </li>
        </ul>
    </div>
    <?php
}