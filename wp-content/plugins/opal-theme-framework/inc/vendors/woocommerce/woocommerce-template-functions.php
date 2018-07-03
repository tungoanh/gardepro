<?php

if (!function_exists('otf_before_content')) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @since   1.0.0
     * @return  void
     */
    function otf_before_content() {
        ?>
        <div class="wrap">
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
        if (is_product_category()) {
            $cate = get_queried_object();
            $cateID = $cate->term_id;
            $banner_id = get_term_meta($cateID, 'product_cat_banner_id', true);

            if ($banner_id) {
                echo '<div class="product-category-banner">';
                echo wp_get_attachment_image($banner_id, 'full');
                echo '</div>';
            }
        }
    }
}

if (!function_exists('otf_after_content')) {
    /**
     * After Content
     * Closes the wrapping divs
     *
     * @since   1.0.0
     * @return  void
     */
    function otf_after_content() {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
        </div>
        <?php
    }
}

if (!function_exists('otf_cart_link_fragment')) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     *
     * @return array            Fragments to refresh via AJAX
     */
    function otf_cart_link_fragment($fragments) {
        global $woocommerce;

        ob_start();
        $fragments['a.cart-contents'] = otf_cart_link();

        ob_start();
        otf_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean();

        return $fragments;
    }
}

if (!function_exists('otf_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return string
     * @since  1.0.0
     */
    function otf_cart_link() {
        if(!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            $items = '';
            $items .= '<a data-toggle="toggle" class="cart-contents header-button" href="' . esc_url(wc_get_cart_url()) . '" title="' . __("View your shopping cart", "opal-theme-framework") . '">';
            $items .= '<i class="fa fa-shopping-basket" aria-hidden="true"></i>';
            $items .= '<span class="title">' . esc_html__('Shopping Cart', 'opal-theme-framework') . '</span>';
            $items .= '<span class="amount">' . wp_kses_data(WC()->cart->get_cart_subtotal()) . '</span>';
            $items .= '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . ' </span>';
            $items .= '<span class="count-text">' . wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "opal-theme-framework")) . '</span>';
            $items .= '</a>';

            return $items;
        }
        return '';
    }
}


if (!function_exists('otf_upsell_display')) {
    /**
     * Upsells
     * Replace the default upsell function with our own which displays the correct number product columns
     *
     * @since   1.0.0
     * @return  void
     * @uses    woocommerce_upsell_display()
     */
    function otf_upsell_display() {
        global $product;
        $number = count($product->get_upsell_ids());
        if ($number <= 0) {
            return;
        }
        $columns = absint(get_theme_mod('otf_woocommerce_single_upsell_columns', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        woocommerce_upsell_display();
        echo '</div>';
    }
}

if (!function_exists('otf_output_related_products')) {
    /**
     * Related
     *
     * @since   1.0.0
     * @return  void
     * @uses    woocommerce_related_products()
     */
    function otf_output_related_products() {
        $columns = absint(get_theme_mod('otf_woocommerce_single_related_columns', 3));
        $number = absint(get_theme_mod('otf_woocommerce_single_related_number', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        woocommerce_related_products($args = array(
            'posts_per_page' => $number,
            'columns'        => $columns,
            'orderby'        => 'rand',
        ));
        echo '</div>';
    }
}

if (!function_exists('otf_sorting_wrapper')) {
    /**
     * Sorting wrapper
     *
     * @since   1.4.3
     * @return  void
     */
    function otf_sorting_wrapper() {
        echo '<div class="otf-sorting">';
    }
}

if (!function_exists('otf_sorting_wrapper_close')) {
    /**
     * Sorting wrapper close
     *
     * @since   1.4.3
     * @return  void
     */
    function otf_sorting_wrapper_close() {
        echo '</div>';
    }
}

if (!function_exists('otf_sorting_group')) {
    /**
     * Sorting wrapper
     *
     * @since   1.4.3
     * @return  void
     */
    function otf_sorting_group() {
        echo '<div class="otf-sorting-group col-lg-6 col-sm-12">';
    }
}

if (!function_exists('otf_sorting_group_close')) {
    /**
     * Sorting wrapper close
     *
     * @since   1.4.3
     * @return  void
     */
    function otf_sorting_group_close() {
        echo '</div>';
    }
}


if (!function_exists('otf_product_columns_wrapper')) {
    /**
     * Product columns wrapper
     *
     * @since   2.2.0
     * @return  void
     */
    function otf_product_columns_wrapper() {
        $columns = otf_loop_columns();
        if (isset($_GET['display']) && $_GET['display'] === 'list') {
            $columns = 1;
        }
        echo '<div class="columns-' . intval($columns) . '">';
    }
}

if (!function_exists('otf_loop_columns')) {
    /**
     * Default loop columns on product archives
     *
     * @return integer products per row
     * @since  1.0.0
     */
    function otf_loop_columns() {
        $columns = get_theme_mod('otf_woocommerce_archive_columns', 3);

        return intval(apply_filters('otf_products_columns', $columns));
    }
}

if (!function_exists('otf_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close
     *
     * @since   2.2.0
     * @return  void
     */
    function otf_product_columns_wrapper_close() {
        echo '</div>';
    }
}

if (!function_exists('otf_shop_messages')) {
    /**
     * homefinder shop messages
     *
     * @since   1.4.4
     * @uses    otf_do_shortcode
     */
    function otf_shop_messages() {
        if (!is_checkout()) {
            echo wp_kses_post(otf_do_shortcode('woocommerce_messages'));
        }
    }
}

if (!function_exists('otf_woocommerce_pagination')) {
    /**
     * homefinder WooCommerce Pagination
     * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
     * but since homefinder adds pagination before that function is excuted we need a separate function to
     * determine whether or not to display the pagination.
     *
     * @since 1.4.4
     */
    function otf_woocommerce_pagination() {
        if (woocommerce_products_will_display()) {
            woocommerce_pagination();
        }
    }
}


if (!function_exists('otf_handheld_footer_bar_search')) {
    /**
     * The search callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function otf_handheld_footer_bar_search() {
        echo '<a href="">' . esc_attr__('Search', 'opal-theme-framework') . '</a>';
        otf_product_search();
    }
}

if (!function_exists('otf_handheld_footer_bar_cart_link')) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function otf_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'opal-theme-framework'); ?>">
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('otf_handheld_footer_bar_account_link')) {
    /**
     * The account callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function otf_handheld_footer_bar_account_link() {
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) . '">' . esc_attr__('My Account', 'opal-theme-framework') . '</a>';
    }
}


if (!function_exists('otf_checkout_before_customer_details_container')) {
    function otf_checkout_before_customer_details_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '<div class="row"><div class="col-lg-7 col-md-12 col-sm-12"><div class="inner">';
        }
    }
}

if (!function_exists('otf_checkout_after_customer_details_container')) {
    function otf_checkout_after_customer_details_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div><div class="col-lg-5 col-md-12 col-sm-12"><div class="inner"> ';
        }
    }
}

if (!function_exists('otf_checkout_after_order_review_container')) {
    function otf_checkout_after_order_review_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div></div>';
        }
    }
}

if (!function_exists('otf_woocommerce_single_product_add_to_cart_before')) {
    function otf_woocommerce_single_product_add_to_cart_before() {
        echo '<div class="woocommerce-cart"><div class="inner">';
    }
}

if (!function_exists('otf_woocommerce_single_product_add_to_cart_after')) {
    function otf_woocommerce_single_product_add_to_cart_after() {
        echo '</div></div>';
    }
}

if (!function_exists('otf_woocommerce_single_product_5_wrap_start')) {
    function otf_woocommerce_single_product_5_wrap_start() {
        echo '<div class="row single-style-5-wrap">';
    }
}

if (!function_exists('otf_woocommerce_single_product_5_wrap_end')) {
    function otf_woocommerce_single_product_5_wrap_end() {
        echo '</div>';
    }
}

if (!function_exists('otf_woocommerce_single_product_summary_inner_start')) {
    function otf_woocommerce_single_product_summary_inner_start() {
        echo '<div class="inner">';
    }
}

if (!function_exists('otf_woocommerce_single_product_summary_inner_end')) {
    function otf_woocommerce_single_product_summary_inner_end() {
        echo '</div>';
    }
}


if (!function_exists('otf_template_loop_product_thumbnail')) {
    /**
     * Get the product thumbnail, or the placeholder if not set.
     *
     * @subpackage    Loop
     *
     * @param string $size        (default: 'shop_catalog')
     * @param int    $deprecated1 Deprecated since WooCommerce 2.0 (default: 0)
     * @param int    $deprecated2 Deprecated since WooCommerce 2.0 (default: 0)
     *
     * @return string
     */
    function otf_template_loop_product_thumbnail($size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0) {
        global $product;
        if (!$product) {
            return '';
        }
        $image_size = $size;
        $gallery = $product->get_gallery_image_ids();
        $hover_skin = get_theme_mod('otf_woocommerce_product_hover', 'none');
        if ($hover_skin == '0' || count($gallery) <= 0) {
            echo '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';

            return '';
        }
        $image_featured = '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';
        $image_featured .= '<div class="product-image second-image">' . wp_get_attachment_image($gallery[0], 'shop_catalog') . '</div>';

        echo <<<HTML
<div class="product-img-wrap {$hover_skin}">
    <div class="inner">
        {$image_featured}
    </div>
</div>
HTML;

    }
}

if (!function_exists('otf_woocommerce_product_loop_image_start')) {
    function otf_woocommerce_product_loop_image_start() {
        echo '<div class="product-transition">';
    }
}

if (!function_exists('otf_woocommerce_product_loop_image_end')) {
    function otf_woocommerce_product_loop_image_end() {
        echo '</div>';
    }
}

if (!function_exists('otf_woocommerce_product_loop_action_start')) {
    function otf_woocommerce_product_loop_action_start() {
        echo '<div class="product-caption"><div class="shop-action">';
    }
}


if (!function_exists('otf_woocommerce_product_loop_action_end')) {
    function otf_woocommerce_product_loop_action_end() {
        echo '</div></div>';
    }
}

if (!function_exists('otf_woocommerce_product_loop_wishlist_button')) {
    function otf_woocommerce_product_loop_wishlist_button() {
        if (otf_is_woocommerce_extension_activated('YITH_WCWL')) {
            echo otf_do_shortcode('yith_wcwl_add_to_wishlist');
        }
    }
}

if (!function_exists('otf_woocommerce_product_loop_compare_button')) {
    function otf_woocommerce_product_loop_compare_button() {
        if (otf_is_woocommerce_extension_activated('YITH_Woocompare')) {
            echo otf_do_shortcode('yith_compare_button');
        }
    }
}


if (!function_exists('otf_woocommerce_change_path_shortcode')) {
    function otf_woocommerce_change_path_shortcode($template, $slug, $name) {
        wc_get_template( 'content-widget-product.php', array( 'show_rating' => false ) );
    }
}


if (!function_exists('otf_woocommerce_group_action_loop_start')) {
    function otf_woocommerce_group_action_loop_start() {
        echo '<div class="group-action shop-action">';
    }
}

if (!function_exists('otf_woocommerce_group_action_loop_end')) {
    function otf_woocommerce_group_action_loop_end() {
        echo '</div>';
    }
}

if (!function_exists('otf_woocommerce_product_loop_start')) {
    function otf_woocommerce_product_loop_start() {
        echo '<div class="product-block">';
    }
}

if (!function_exists('otf_woocommerce_product_loop_end')) {
    function otf_woocommerce_product_loop_end() {
        echo '</div>';
    }
}
if (!function_exists('otf_woocommerce_product_loop_caption_start')) {
    function otf_woocommerce_product_loop_caption_start() {
        echo '<div class="caption">';
    }
}

if (!function_exists('otf_woocommerce_product_rating')) {
    function otf_woocommerce_product_rating() {
        global $product;
        if (get_option('woocommerce_enable_review_rating') === 'no') {
            return;
        }
        if ($rating_html = wc_get_rating_html($product->get_average_rating())) {
            echo apply_filters('otf_woocommerce_rating_html', $rating_html);
        } else {
            echo '<div class="star-rating"></div>';
        }
    }
}
if (!function_exists('oft_woocommerce_template_loop_product_excerpt')) {

    /**
     * Show the excerpt in the product loop.
     */
    function otf_woocommerce_template_loop_product_excerpt() {
        global $product;
        echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
    }
}
if (!function_exists('woocommerce_template_loop_product_title')) {

    /**
     * Show the product title in the product loop.
     */
    function woocommerce_template_loop_product_title() {
        echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url_raw(get_the_permalink()) . '">' . get_the_title() . '</a></h3>';
    }
}


if (!function_exists('otf_woocommerce_get_product_category')) {
    function otf_woocommerce_get_product_category() {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in">', '</span>');
    }
}
if (!function_exists('otf_woocommerce_get_product_label_stock')) {
    function otf_woocommerce_get_product_label_stock() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->get_stock_status() == 'outofstock') {
            echo '<span class="out-of-stock">' . esc_html__('Out Of Stock', 'opal-theme-framework') . '</span>';
        }
    }
}

if (!function_exists('otf_woocommerce_get_product_label_sale')) {
    function otf_woocommerce_get_product_label_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->is_on_sale() && $product->is_type('simple')) {
            $ratio = round($product->get_sale_price() / $product->get_regular_price() * 10);
            echo '<span class="onsale"> - ' . esc_html($ratio) . ' % </span>';
        }
    }
}

if (!function_exists('otf_woocommerce_set_register_text')) {
    function otf_woocommerce_set_register_text() {
        echo '<div class="user-text">' . __("Creating an account is quick and easy, and will allow you to move through our checkout quicker.", "opal-theme-framework") . '</div>';
    }
}


if (!function_exists('otf_header_cart_nav')) {
    /**
     * Display Header Cart
     *
     * @since  1.0.0
     * @uses   otf_is_woocommerce_activated() check if WooCommerce is activated
     * @return string
     */
    function otf_header_cart_nav() {
        if (otf_is_woocommerce_activated()) {
            $items = '';
            $items .= '<li class="megamenu-item menu-item  menu-item-has-children menu-item-cart site-header-cart " data-level="0">';
            $items .= otf_cart_link();
            if (!is_cart() && !is_checkout()) {
                $items .= '<ul class="shopping_cart_nav shopping_cart"><li><div class="widget_shopping_cart_content"></div></li></ul>';
            }
            $items .= '</li>';

            return $items;
        }

        return '';
    }
}

if (!function_exists('otf_woocommerce_add_woo_cart_to_nav')) {
    function otf_woocommerce_add_woo_cart_to_nav($items, $args) {

        if ('top' == $args->theme_location) {
            global $otf_header;
            if ($otf_header && $otf_header instanceof WP_Post) {
                if (otf_get_metabox($otf_header->ID, 'otf_enable_cart', false)) {
                    $items .= otf_header_cart_nav();
                }

                return $items;
            }

            if (get_theme_mod('otf_header_layout_enable_cart_in_menu', true)) {
                $items .= otf_header_cart_nav();
            }
        }

        return $items;
    }
}

if(!function_exists('otf_woocommerce_list_get_excerpt')){
    function otf_woocommerce_list_show_excerpt(){
        echo '<div class="product-excerpt">'.get_the_excerpt().'</div>';
    }
}

if(!function_exists('otf_woocommerce_list_get_category')){
    function otf_woocommerce_list_show_category(){
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<div class="posted_in">', '</div>');
    }
}

if(!function_exists('otf_woocommerce_list_get_rating')){
    function otf_woocommerce_list_show_rating(){
        global $product;
        echo wc_get_rating_html( $product->get_average_rating() );
    }
}


if (!function_exists('otf_woocommerce_time_sale')) {
    function otf_woocommerce_time_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        if ($time_sale) {
            $time_sale += (get_option('gmt_offset') * 3600);
            echo '<div class="time">
                    <div class="opal-countdown clearfix"
                        data-countdown="countdown"
                        data-days="' . esc_html__("days", "opal-theme-framework") . '" 
                        data-hours="' . esc_html__("hours", "opal-theme-framework") . '"
                        data-minutes="' . esc_html__("mins", "opal-theme-framework") . '"
                        data-seconds="' . esc_html__("secs", "opal-theme-framework") . '"
                        data-Message="' . esc_html__('Expired', 'opal-theme-framework') . '"
                        data-date="' . date('m', $time_sale) . '-' . date('d', $time_sale) . '-' . date('Y', $time_sale) . '-' . date('H', $time_sale) . '-' . date('i', $time_sale) . '-' . date('s', $time_sale) . '">
                    </div>
            </div>';
        }
    }
}
if (!function_exists('otf_output_product_data_accordion')) {
    function otf_output_product_data_accordion() {
        $tabs = apply_filters('woocommerce_product_tabs', array());
        if (!empty($tabs)) : ?>
            <div id="otf-accordion-container" class="woocommerce-tabs wc-tabs-wrapper">
                <?php $_count = 0; ?>
                <?php foreach ($tabs as $key => $tab) : ?>
                    <div data-accordion<?php echo $_count == 0 ? ' class="accordion open"' : ''; ?>>
                        <div data-control class="<?php echo esc_attr($key); ?>_tab"
                             id="tab-title-<?php echo esc_attr($key); ?>">
                            <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
                        </div>
                        <div data-content>
                            <?php call_user_func($tab['callback'], $key, $tab); ?>
                        </div>
                    </div>
                    <?php $_count++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }
}

if (!function_exists('otf_woocommerce_switch_layout')) {
    function otf_woocommerce_switch_layout() {
        $woo_display = 'grid';
        if (isset($_GET['display'])) {
            $woo_display = $_GET['display'];
        }
        echo '<form class="display-mode" method="get">';
        echo '<button class=" ' . ($woo_display == 'grid' ? 'active' : '') . '" value="grid" name="display" type="submit"><i class="fa fa-th"></i><span class="screen-reader-text">' . esc_html__("Grid", 'opal-theme-framework') . '</span></button>';
        echo '<button class=" ' . ($woo_display == 'list' ? 'active' : '') . '" value="list" name="display" type="submit"><i class="fa fa-th-list"></i><span class="screen-reader-text">' . esc_html__("List", 'opal-theme-framework') . '</span></button>';
        // Keep query string vars intact
        foreach ($_GET as $key => $val) {
            if ('display' === $key || 'submit' === $key) {
                continue;
            }
            if (is_array($val)) {
                foreach ($val as $innerVal) {
                    echo '<input type="hidden" name="' . esc_attr($key) . '[]" value="' . esc_attr($innerVal) . '" />';
                }
            } else {
                echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
            }
        }
        echo '</form>';
    }
}

if (!function_exists('otf_woocommerce_cross_sell_display')) {
    function otf_woocommerce_cross_sell_display() {
        woocommerce_cross_sell_display(get_theme_mod('otf_woocommerce_cart_cross_sells_limit', 4), get_theme_mod('otf_woocommerce_cart_cross_sells_columns', 4));
    }
}

function otf_woocommerce_render_variable() {
    /**
     * @var $product WC_Product_Variable
     */
    if (!function_exists('TA_WCVS')) {
        return;
    }
        global $product;
    if ($product->is_type('variable')) {
        $attr_name = 'pa_color';
        $variables = $product->get_variation_attributes()[$attr_name];
        $attr = TA_WCVS()->get_tax_attribute($attr_name);
        $options = $product->get_available_variations();
        $html = '<div class="otf-wrap-swatches"><div class="inner">';
        $terms = wc_get_product_terms($product->get_id(), $attr_name, array('fields' => 'all'));
        foreach ($terms as $term) {
            if (in_array($term->slug, $variables)) {
                $html .= otf_woocommerce_get_swatch_html($term, $attr, $options, $attr_name);
            }
        }
        $html .= '</div></div>';
        echo $html;
    }
}

function otf_woocommerce_get_swatch_html($term, $attr, $options, $attr_name) {
    $html = '';
    $selected = '';
    $attr_name = 'attribute_' . $attr_name;
    $name = esc_html(apply_filters('woocommerce_variation_option_name', $term->name));
    $image = array();
    foreach ($options as $option) {
        foreach ($option['attributes'] as $_k => $_v) {
            if ($_k === $attr_name && $_v === $term->slug) {
                $image = $option['image'];
                break;
            }
            if (count($image) > 0) {
                break;
            }
        }
    }
    switch ($attr->attribute_type) {
        case 'color':
            $color = get_term_meta($term->term_id, 'color', true);
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            $html = sprintf(
                '<span class="swatch swatch-color otf-tooltip swatch-%s %s" data-image="%s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($color),
                "rgba($r,$g,$b,0.5)",
                esc_attr($name),
                esc_attr($term->slug),
                $name
            );
            break;

        case 'image':
            $image = get_term_meta($term->term_id, 'image', true);
            $image = $image ? wp_get_attachment_image_src($image) : '';
            $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
            $html = sprintf(
                '<span class="swatch swatch-image swatch-%s otf-tooltip %s" data-image="%s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($name),
                esc_attr($term->slug),
                esc_url($image),
                esc_attr($name),
                esc_attr($name)
            );
            break;

        case 'label':
            $label = get_term_meta($term->term_id, 'label', true);
            $label = $label ? $label : $name;
            $html = sprintf(
                '<span class="swatch swatch-label swatch-%s %s" data-image="%s" title="%s" data-value="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($name),
                esc_attr($term->slug),
                esc_html($label)
            );
            break;
    }

    return $html;
}


function otf_woocommerce_single_product_image_thumbnail_html($image, $attachment_id){
    return wc_get_gallery_image_html( $attachment_id , true );
}

if (!function_exists('otf_active_filters')) {
    function otf_active_filters() {
        $link_remove_all = $_SERVER['REQUEST_URI'];
        $link_remove_all = strtok( $link_remove_all, '?' );
        echo '<div class="otf-active-filters">';
        the_widget('WC_Widget_Layered_Nav_Filters');
        echo '<span class="otf_active_filters_label">' . esc_html__('Active Filters: ', 'opal-theme-framework') . '</span>
    <a class="clear-all" href="'.esc_url($link_remove_all).'">'.__('Clear Filters').'</a>
</div>';
    }
}