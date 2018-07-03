<?php
/**
 * homefinder WooCommerce hooks
 *
 * @package homefinder
 */

add_action('woocommerce_register_form_start', 'otf_woocommerce_set_register_text', 10);
add_filter('wp_nav_menu_items', 'otf_woocommerce_add_woo_cart_to_nav', 12, 3);
// woocommerce_no_products_found

add_action('woocommerce_no_products_found', 'otf_active_filters', 20);

/**
 * Styles
 *
 * @see  otf_woocommerce_scripts()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_main_content', 'otf_before_content', 10);
add_action('woocommerce_after_main_content', 'otf_after_content', 10);
add_action('otf_content_top', 'otf_shop_messages', 15);
add_action('otf_content_top', 'woocommerce_breadcrumb', 10);

add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 30);
add_action('woocommerce_after_shop_loop', 'otf_product_columns_wrapper_close', 40);

add_filter('loop_shop_columns', 'otf_loop_columns');


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'otf_template_loop_product_thumbnail', 10);


//Config Style Single Product
$product_single_style = get_theme_mod('otf_woocommerce_single_product_style', 1);
add_action('woocommerce_single_product_summary', 'otf_woocommerce_single_product_summary_inner_start', -1);
add_action('woocommerce_single_product_summary', 'otf_woocommerce_single_product_summary_inner_end', 99999);
switch ($product_single_style) {
    case 1:
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 70);
        // Support lightbox
        add_action('after_setup_theme', array(OTF_WooCommerce::getInstance(), 'add_support_gallery_all'));
        break;
    case 2:
        // Supports Single Image
        add_action('after_setup_theme', array(OTF_WooCommerce::getInstance(), 'add_support_gallery_all'));
        break;
    case 3:
        // Supports Single Image
        add_action('after_setup_theme', array(OTF_WooCommerce::getInstance(), 'add_support_gallery_all'));
        break;
    case 4:
        // Supports Single Image
        add_action('after_setup_theme', array(OTF_WooCommerce::getInstance(), 'add_support_gallery_all'));
        break;
    case 5:
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        add_action('woocommerce_before_single_product_summary', 'otf_woocommerce_single_product_5_wrap_start', 9);
        add_action('woocommerce_after_single_product_summary', 'otf_woocommerce_single_product_add_to_cart_before', 1);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_price', 2);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_add_to_cart', 3);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 4);
        add_action('woocommerce_after_single_product_summary', 'otf_woocommerce_single_product_add_to_cart_after', 9);

        add_action('woocommerce_after_single_product_summary', 'otf_woocommerce_single_product_5_wrap_end', 9);
        // Support lightbox
        add_action('after_setup_theme', array(OTF_WooCommerce::getInstance(), 'add_support_lightbox'));
        add_filter('woocommerce_single_product_image_thumbnail_html', 'otf_woocommerce_single_product_image_thumbnail_html', 10 , 2);
        break;
}

/**
 * Header
 *
 * @see  otf_product_search()
 * @see  otf_header_cart()
 */
//add_action('otf_header', 'otf_product_search', 40);
//add_action('otf_header', 'otf_header_cart', 60);


if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {
    add_filter('woocommerce_add_to_cart_fragments', 'otf_cart_link_fragment');
} else {
    add_filter('add_to_cart_fragments', 'otf_cart_link_fragment');
}

/**
 * Checkout Page
 *
 * @see otf_checkout_before_customer_details_container
 * @see otf_checkout_after_customer_details_container
 * @see otf_checkout_after_order_review_container
 */

add_action('woocommerce_checkout_before_customer_details', 'otf_checkout_before_customer_details_container', 1);
add_action('woocommerce_checkout_after_customer_details', 'otf_checkout_after_customer_details_container', 1);
add_action('woocommerce_checkout_after_order_review', 'otf_checkout_after_order_review_container', 1);


/**
 * Remove Action
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product_summary', 'otf_upsell_display', 15);
add_action('woocommerce_after_single_product_summary', 'otf_output_related_products', 20);

// Layout Product
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

add_action('woocommerce_before_shop_loop_item', 'otf_woocommerce_product_loop_start', -1);
add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_end', 999);

add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_get_product_label_stock', 7);
add_action('woocommerce_before_shop_loop', 'otf_sorting_wrapper', 1);
add_action('woocommerce_before_shop_loop', 'otf_sorting_group', 1);
if (!is_active_sidebar('sidebar-woocommerce-shop-filters')) {
    add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 2);
}
add_action('woocommerce_before_shop_loop', 'otf_sorting_group_close', 3);
add_action('woocommerce_before_shop_loop', 'otf_sorting_group', 5);
add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 7);
add_action('woocommerce_before_shop_loop', 'otf_woocommerce_switch_layout', 7);
add_action('woocommerce_before_shop_loop', 'otf_sorting_group_close', 7);
add_action('woocommerce_before_shop_loop', 'otf_sorting_wrapper_close', 7);
add_action('woocommerce_before_shop_loop', 'otf_active_filters', 8);
add_action('woocommerce_before_shop_loop', 'otf_product_columns_wrapper', 40);
if (isset($_GET['display']) && $_GET['display'] === 'list') {
    add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
    add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_rating', 15);
    add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_template_loop_product_excerpt', 20);
    add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_action_start', 10);
    add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

    if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
        remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
        add_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
    }
    // Wishlist
    add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_wishlist_button', 25);

    // Compare
    add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_compare_button', 30);
    add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_action_end', 99);
    add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_end', 100);
} else {
    $product_style = get_theme_mod('otf_woocommerce_product_style', 1);
    switch ($product_style) {
        case 2:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 60);
            break;

        case 3:
            //remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
            //add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_get_product_label_sale', 7);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable

            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 60);
            break;

        case 4:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);

            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 30);
            }
            // Wishlist
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_wishlist_button', 20);

            // Compare
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_compare_button', 25);

            //WC_Product_Variable
            // add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_render_variable', 6);
            break;
        case 5:
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 1);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_group_action_loop_start', 10);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20);
            // Wishlist
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_compare_button', 30);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_group_action_loop_end', 50);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 55);
            break;
        case 6:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_group_action_loop_start', 25);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_group_action_loop_end', 45);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 1);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 30);
            }

            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 35);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 40);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 55);
            break;
        case 7:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 1);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 5);
            }

            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 35);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 40);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

            //WC_Product_Variable
            // add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_render_variable', 4);
            break;
        case 8:

            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_title', 5);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_rating', 15);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 30);
            }

            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 35);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 40);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

            //WC_Product_Variable
            // add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_render_variable', 14);
            break;
        case 9:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 30);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_rating', 15);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable
            // add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_render_variable', 14);
            break;
        case 10:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 55);
            break;
        case 11:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_group_action_loop_end', 7);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Compare
            add_action( 'woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 5 );
            // Wishlist
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 5);

            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_group_action_loop_start', 0);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 55);
            break;
        case 12:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_rating', 5);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_end', 100);

            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_wishlist_button', 20);
            // Compare
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_compare_button', 30);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_group_action_loop_start', 10);

            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_group_action_loop_end', 50);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 20);

            break;
        case 13:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable
            // add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_render_variable', 5);
            break;
        case 14:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 100);
            break;
        case 15:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_end', 100);

            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_wishlist_button', 20);
            // Compare
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_compare_button', 30);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_group_action_loop_start', 10);

            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_group_action_loop_end', 50);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 20);
            break;
        case 16:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 5);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_product_rating', 5);
            add_action('woocommerce_shop_loop_item_title', 'otf_woocommerce_product_loop_caption_start', 0);
            add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_product_loop_end', 100);

            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);
            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_group_action_loop_start', 10);

            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_group_action_loop_end', 50);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 20);
            break;
        default:
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_start', 5);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_start', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_action_end', 50);
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_image_end', 100);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 99);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 99);
            add_action('woocommerce_after_shop_loop_item_title', 'otf_woocommerce_get_product_category', 30);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            // QuickView
            if (otf_is_woocommerce_extension_activated('YITH_WCQV')) {
                remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
                add_action('woocommerce_before_shop_loop_item_title', array(YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 20);
            }
            // Wishlist
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_wishlist_button', 25);

            // Compare
            add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_product_loop_compare_button', 30);

            //WC_Product_Variable
            // add_action('woocommerce_before_shop_loop_item_title', 'otf_woocommerce_render_variable', 55);
            break;
    }
}



$product_single_tab_style = get_theme_mod('otf_woocommerce_single_product_tab_style', 'tab');
if ($product_single_tab_style == 'accordion') {
    if ($product_single_style == 1) {
        remove_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 70);
        add_action('woocommerce_single_product_summary', 'otf_output_product_data_accordion', 70);
    } else {
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        add_action('woocommerce_after_single_product_summary', 'otf_output_product_data_accordion', 10);
    }
}

// Cart Page
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'otf_woocommerce_cross_sell_display');

