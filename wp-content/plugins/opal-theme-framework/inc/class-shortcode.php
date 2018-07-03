<?php

if (!defined('ABSPATH')) {
    exit;
}

class OTF_Shortcode {
    public function __construct() {
        add_filter('otf_list_shortcodes', array($this, 'add_shortcodes'), 1);
        add_action('init', array($this, 'init_shortcodes'));
    }

    /**
     * @return array
     */
    public function add_shortcodes($shortCodes = array()) {
        $shortCodes = wp_parse_args($shortCodes, array(
            'otf_backtop',
            'otf_countdown',
            'otf_counter',
            'otf_featured_box',
            'otf_latest_tweets',
            'otf_menu_social',
            'otf_parallax',
            'otf_pricing',
            'otf_image_carousel',
            'otf_promo_banner',
            'otf_vertical_menu',
            'otf_instagram',
            'otf_divider',
        ));
        if (otf_is_woocommerce_activated()) {
            $shortCodes[] = 'otf_product_deals';
            $shortCodes[] = 'otf_product_parallax';
            $shortCodes[] = 'otf_product_category_banner';
            $shortCodes[] = 'otf_product_banner';
        }

        return $shortCodes;
    }

    public function init_shortcodes() {
        $shortCodes = apply_filters('otf_add_shortcode', apply_filters('otf_list_shortcodes', array()));
        foreach ($shortCodes as $shortCode) {
            $method = str_replace('otf_', '', $shortCode . '_shortcode');
            if (method_exists($this, $method)) {
                add_shortcode($shortCode, array($this, $method));
            }
        }
    }

    public function divider_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_divider', $atts, $content);
        return ob_get_clean();
    }

    public function instagram_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_instagram', $atts, $content);
        return ob_get_clean();
    }

    public function product_category_banner_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_product_category_banner', $atts, $content);

        return ob_get_clean();
    }

    public function product_banner_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_product_banner', $atts, $content);

        return ob_get_clean();
    }

    public function vertical_menu_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_vertical_menu', $atts, $content);

        return ob_get_clean();
    }

    public function counter_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_counter', $atts, $content);

        return ob_get_clean();
    }

    public function backtop_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_backtop', $atts, $content);

        return ob_get_clean();
    }

    public function countdown_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_countdown', $atts, $content);

        return ob_get_clean();
    }

    public function featured_box_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_featured_box', $atts, $content);

        return ob_get_clean();
    }

    public function latest_tweets_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_latest_tweets', $atts, $content);

        return ob_get_clean();
    }

    public function menu_social_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_menu_social', $atts, $content);

        return ob_get_clean();
    }

    public function parallax_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_parallax', $atts, $content);

        return ob_get_clean();
    }

    public function pricing_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_pricing', $atts, $content);

        return ob_get_clean();
    }

    public function product_deals_shortcode($atts = array(), $content = '') {
        ob_start();
        add_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_time_sale', 20);
        add_action('otf_product_list_after_price', 'otf_woocommerce_time_sale', 20);
        $this->render_shortcode('otf_product_deal', $atts, $content);
        remove_action('woocommerce_after_shop_loop_item', 'otf_woocommerce_time_sale', 20);
        remove_action('otf_product_list_after_price', 'otf_woocommerce_time_sale', 20);

        return ob_get_clean();
    }

    public function product_parallax_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_product_parallax', $atts, $content);

        return ob_get_clean();
    }

    public function image_carousel_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_image_carousel', $atts, $content);

        return ob_get_clean();
    }

    public function promo_banner_shortcode($atts = array(), $content = '') {
        ob_start();
        $this->render_shortcode('otf_promo_banner', $atts, $content);

        return ob_get_clean();
    }

    function render_shortcode($name, $atts = array(), $content = '') {
        $name = preg_replace('/_/', '-', $name);
        $path = get_theme_file_path('template-parts/shortcodes/' . $name . '.php');
        if (file_exists($path)) {
            include $path;
        }

        return '';
    }

    public function get_svg_divider($name, $color, $custom_height = '') {
        $folder = trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'assets/images/svg';
        $file = $folder . '/' . $name . '.svg';
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $style = 'fill:  ' . esc_html($color) . ';';
            if ($name === 'grime-top') {
                $style .= 'margin-top: -1px;';
            }

            if($name === 'half-circle2-top'){
                $style .= 'transform: translateY(1px);';
            }

            $style .= ($custom_height) ? 'height: ' . esc_html($custom_height) . ';' : '';
            return preg_replace("/<svg/", "<svg style=\"" . $style . "\"", $content);
        }
        return false;
    }
}

new OTF_Shortcode();