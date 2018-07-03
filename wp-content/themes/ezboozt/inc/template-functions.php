<?php
/**
 * Checks to see if we're on the homepage or not.
 */
if (!function_exists('ezboozt_is_frontpage')) {

    function ezboozt_is_frontpage() {
        return (is_front_page() && !is_home());
    }
}

if (!function_exists('ezboozt_page_enable_breadcrumb')) {
    /**
     * @return bool
     */
    function ezboozt_page_enable_breadcrumb() {
        if (!is_page()) {
            return true;
        }
        $check = ezboozt_get_metabox(get_the_ID(), 'otf_enable_breadcrumb', true);
        return $check;
    }
}

if (!function_exists('ezboozt_get_query')) {

    /**
     * @param $args
     *
     * @return WP_Query
     */
    function ezboozt_get_query($args) {
        global $wp_query;
        $default = array(
            'post_type' => 'post',
        );
        $args = wp_parse_args($args, $default);
        $wp_query = new WP_Query($args);

        return $wp_query;
    }
}

if (!function_exists('ezboozt_get_placeholder_image')) {

    /**
     * @return string
     */
    function ezboozt_get_placeholder_image() {
        return get_parent_theme_file_uri('/assets/images/placeholder.png');
    }

}

if (!function_exists('ezboozt_is_woocommerce_activated')) {
    /**
     * Query WooCommerce activation
     */
    function ezboozt_is_woocommerce_activated() {
        return class_exists('WooCommerce') ? true : false;
    }
}

if (!function_exists('ezboozt_is_opalrealestate_activated')) {
    function ezboozt_is_opalrealestate_activated() {
        return class_exists('OpalRealEstate') ? true : false;
    }
}

if (!function_exists('ezboozt_is_idx_activated')) {
    function ezboozt_is_idx_activated() {
        return class_exists('dsIdxGlobals') ? true : false;
    }
}

if (!function_exists('ezboozt_is_vc_activated')) {
    function ezboozt_is_vc_activated() {
        return class_exists('Vc_Manager') ? true : false;
    }
}

if (!function_exists('ezboozt_is_one_click_import_activated')) {
    function ezboozt_is_one_click_import_activated() {
        return class_exists('OCDI_Plugin') ? true : false;
    }
}

if (!function_exists('ezboozt_get_metabox')) {

    /**
     * @param int    $id
     * @param string $key
     * @param bool   $default
     *
     * @return bool|mixed
     */
    function ezboozt_get_metabox($id, $key, $default = false) {
        $value = get_post_meta($id, $key, true);
        if ($value === '') {
            return $default;
        } else {
            return $value;
        }
    }
}

if (!function_exists('ezboozt_is_header_builder')) {
    /**
     * @return bool
     */
    function ezboozt_is_header_builder() {
        global $otf_header;
        if ($otf_header && $otf_header instanceof WP_Post) {
            return true;
        }
        return false;
    }
}

if (!function_exists('ezboozt_is_footer_builder')) {
    /**
     * @return bool
     */
    function ezboozt_is_footer_builder() {
        global $otf_footer;

        if ($otf_footer && $otf_footer instanceof WP_Post) {
            return true;
        }
        return false;
    }
}

if (!function_exists('ezboozt_is_product_archive')) {

    /**
     * Checks if the current page is a product archive
     * @return boolean
     */
    function ezboozt_is_product_archive() {
        if (ezboozt_is_woocommerce_activated()) {
            if (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('ezboozt_is_blog_archive')) {
    function ezboozt_is_blog_archive() {
        return (is_home() && is_front_page()) || is_category() || is_tag() || is_post_type_archive('post');
    }
}

if (!function_exists('ezboozt_get_excerpt')) {
    function ezboozt_get_excerpt($excerpt_length = 55) {
        global $post;
        $text = $post->post_content;
        $text = strip_shortcodes($text);
        /** This filter is documented in wp-includes/post-template.php */
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);

        /**
         * Filters the string in the "more" link displayed after a trimmed excerpt.
         *
         * @since 2.9.0
         *
         * @param string $more_string The string shown within the more link.
         */
        $excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]');

        return wp_trim_words($text, $excerpt_length, $excerpt_more);
    }
}

if (!function_exists('ezboozt_do_shortcode')) {

    /**
     * Call a shortcode function by tag name.
     *
     * @since  1.4.6
     *
     * @param string $tag     The shortcode whose function to call.
     * @param array  $atts    The attributes to pass to the shortcode function. Optional.
     * @param array  $content The shortcode's content. Default is null (none).
     *
     * @return string|bool False on failure, the result of the shortcode on success.
     */
    function ezboozt_do_shortcode($tag, array $atts = array(), $content = null) {
        global $shortcode_tags;

        if (!isset($shortcode_tags[$tag])) {
            return false;
        }

        return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
    }
}

if (!function_exists('ezboozt_nav_menu_social_icons')) {

    /**
     * Display SVG icons in social links menu.
     *
     * @param  string  $item_output The menu item output.
     * @param  WP_Post $item        Menu item object.
     * @param  int     $depth       Depth of the menu.
     * @param  object  $args        wp_nav_menu() arguments.
     *
     * @return string  $item_output The menu item output with social icon.
     */
    function ezboozt_nav_menu_social_icons($item_output, $item, $depth, $args) {
        // Get supported social icons.
        $social_icons = ezboozt_social_links_icons();

        // Change SVG icon inside social links menu if there is supported URL.
        if ('social' === $args->theme_location) {
            foreach ($social_icons as $attr => $value) {
                if (false !== strpos($item_output, $attr)) {
                    $item_output = str_replace($args->link_after, '</span><i class="' . esc_attr($value) . '" aria-hidden="true"></i>', $item_output);
                }
            }
        }

        return $item_output;
    }
}
add_filter('walker_nav_menu_start_el', 'ezboozt_nav_menu_social_icons', 10, 4);

if (!function_exists('ezboozt_dropdown_icon_to_menu_link')) {

    /**
     * Add dropdown icon if menu item has children.
     *
     * @param  string $title The menu item's title.
     * @param  object $item  The current menu item.
     * @param  object $args  An array of wp_nav_menu() arguments.
     * @param  int    $depth Depth of menu item. Used for padding.
     *
     * @return string $title The menu item's title with dropdown icon.
     */
    function ezboozt_dropdown_icon_to_menu_link($title, $item, $args, $depth) {
        if ('top' === $args->theme_location) {
            foreach ($item->classes as $value) {
                if ('menu-item-has-children' === $value || 'page_item_has_children' === $value) {
                    $title = $title . '<i class="fa fa-angle-down"></i>';
                }
            }
        }

        return $title;
    }
}
add_filter('nav_menu_item_title', 'ezboozt_dropdown_icon_to_menu_link', 10, 4);

if (!function_exists('ezboozt_social_links_icons')) {

    /**
     * Returns an array of supported social links (URL and icon name).
     *
     * @return array $social_links_icons
     */
    function ezboozt_social_links_icons() {
        // Supported social links icons.
        $social_links_icons = array(
            'behance.net'     => 'fa fa-behance',
            'codepen.io'      => 'fa fa-codepen',
            'deviantart.com'  => 'fa fa-deviantart',
            'digg.com'        => 'fa fa-digg',
            'dribbble.com'    => 'fa fa-dribbble',
            'dropbox.com'     => 'fa fa-dropbox',
            'facebook.com'    => 'fa fa-facebook',
            'flickr.com'      => 'fa fa-flickr',
            'foursquare.com'  => 'fa fa-foursquare',
            'plus.google.com' => 'fa fa-google-plus',
            'github.com'      => 'fa fa-github',
            'instagram.com'   => 'fa fa-instagram',
            'linkedin.com'    => 'fa fa-linkedin',
            'mailto:'         => 'fa fa-envelope-o',
            'medium.com'      => 'fa fa-medium',
            'pinterest.com'   => 'fa fa-pinterest-p',
            'getpocket.com'   => 'fa fa-get-pocket',
            'reddit.com'      => 'fa fa-reddit-alien',
            'skype.com'       => 'fa fa-skype',
            'skype:'          => 'fa fa-skype',
            'slideshare.net'  => 'fa fa-slideshare',
            'snapchat.com'    => 'fa fa-snapchat-ghost',
            'soundcloud.com'  => 'fa fa-soundcloud',
            'spotify.com'     => 'fa fa-spotify',
            'stumbleupon.com' => 'fa fa-stumbleupon',
            'tumblr.com'      => 'fa fa-tumblr',
            'twitch.tv'       => 'fa fa-twitch',
            'twitter.com'     => 'fa fa-twitter',
            'vimeo.com'       => 'fa fa-vimeo',
            'vine.co'         => 'fa fa-vine',
            'vk.com'          => 'fa fa-vk',
            'wordpress.org'   => 'fa fa-wordpress',
            'wordpress.com'   => 'fa fa-wordpress',
            'yelp.com'        => 'fa fa-yelp',
            'youtube.com'     => 'fa fa-youtube',
        );

        return apply_filters('ezboozt_social_links_icons', $social_links_icons);
    }
}

if (!function_exists('ezboozt_get_header_builder_html')) {

    /**
     * @return string
     */
    function ezboozt_get_header_builder_html() {
        global $otf_header;
        if ($otf_header && $otf_header instanceof WP_Post) {
            $header_content = '<div class="container">';
            $header_content .= do_shortcode($otf_header->post_content);
            $header_content .= '</div>';

            return $header_content;
        }
        return '';
    }
}

if (!function_exists('ezboozt_the_header_builder')) {
    /**
     * @return void
     */
    function ezboozt_the_header_builder() {
        echo ezboozt_get_header_builder_html();
    }
}


if (!function_exists('ezboozt_get_header_metabox')) {
    function ezboozt_get_header_metabox($key, $default = false) {
        /**
         * @var $otf_header WP_Post
         */
        global $otf_header;
        if (ezboozt_is_header_builder()) {
            return ezboozt_get_metabox($otf_header->ID, $key, $default);
        }
        return $default;
    }
}


if (!function_exists('ezboozt_the_footer_builder')) {
    /**
     * @return void
     */
    function ezboozt_the_footer_builder() {
        echo ezboozt_get_footer_builder_html();
    }
}


if (!function_exists('ezboozt_get_footer_builder_html')) {
    function ezboozt_get_footer_builder_html() {
        /**
         * @var $otf_footer WP_Post
         */
        global $otf_footer;
        $header_content = '<div class="wrap"><div class="container">';
        $header_content .= do_shortcode($otf_footer->post_content);
        $header_content .= '</div></div>';

        return $header_content;
    }
}
if (!function_exists('ezboozt_license_get_option')) {
    function ezboozt_license_get_option($key = '', $default = false) {
        if (function_exists('cmb2_get_option')) {
            // Use cmb2_get_option as it passes through some key filters.
            return cmb2_get_option('opal-theme-license', $key, $default);
        }
        // Fallback to get_option if CMB2 is not loaded yet.
        $opts = get_option('opal-theme-license', $default);
        $val  = $default;
        if ('all' == $key) {
            $val = $opts;
        } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
            $val = $opts[$key];
        }
        return $val;
    }
}