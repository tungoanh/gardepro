<?php

class OTF_Header_builder {
    private $list_shortcodes = array();

    public function __construct() {
        $this->list_shortcodes = array(
            'otf_header_logo'              => 'header_logo',
            'otf_header_main_navigation'   => 'main_navigation',
            'otf_header_cart'              => 'cart',
            'otf_header_search'            => 'search',
            'otf_header_search_button'     => 'search_button',
            'otf_header_account'           => 'account',
            'otf_header_navigation_button' => 'navigation_button',
        );

        $this->list_shortcodes['otf_header_wishlist'] = 'wishlist_button';

        if (class_exists('WOOCS_STARTER')) {
            $this->list_shortcodes['otf_header_currency_switcher'] = 'currency_switcher';
        }
        foreach ($this->list_shortcodes as $shortcode => $callback) {
            add_shortcode($shortcode, array($this, $callback));
        }

        add_action('vc_before_init', array($this, 'vc_mapping'));

        add_action('wp', array($this, 'setup_header'));
        add_filter('body_class', array($this, 'add_body_class'));

        add_action('admin_bar_menu', array($this, 'custom_button_header_builder'), 50);
    }

    public function currency_switcher($atts = array(), $content = '') {
        return $this->get_template('template-parts/header/currency-switcher.php', $atts);
    }

    /**
     * @param $wp_admin_bar WP_Admin_Bar
     */
    public function custom_button_header_builder($wp_admin_bar) {
        global $otf_header;
        if ($otf_header && $otf_header instanceof WP_Post) {
            $args = array(
                'id'    => 'header-builder-button',
                'title' => __('Edit Header', 'opal-theme-framework'),
                'href'  => get_edit_post_link($otf_header->ID),
//            'meta'  => array(
//                'class' => 'custom-button-class'
//            )
            );
            $wp_admin_bar->add_node($args);
        }
    }


    /**
     * @param $classes
     *
     * @return array
     */
    public function add_body_class($classes) {
        global $otf_header;
        if ($otf_header && $otf_header instanceof WP_Post) {
            // Absolute Header
            if (otf_get_metabox($otf_header->ID, 'otf_enable_header_absolute', false)) {
                $classes[] = 'opal-header-absolute';
            }
        }

        return $classes;
    }


    public function setup_header() {
        global $otf_header;

        if ((bool)otf_get_metabox(get_the_ID(), 'otf_enable_custom_header', false)) {
            if (($header_slug = otf_get_metabox(get_the_ID(), 'otf_header_layout', 'default')) !== 'default') {
                $otf_header = get_page_by_path($header_slug, OBJECT, 'header');
            }
        } else {
            if (($header_slug = get_theme_mod('otf_header_builder', '')) && get_theme_mod('otf_header_enable_builder', false)) {
                $otf_header = get_page_by_path($header_slug, OBJECT, 'header');
            }
        }

    }

    /**
     * @return void
     */
    public function vc_mapping() {
        $path = trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/vendors/visual-composer/header-builder/';
        foreach ($this->list_shortcodes as $shortcode => $callback) {
//            $_p = get_theme_file_path('inc/vendors/vc/header-builder/' . $shortcode . '.php');
//            if (!file_exists($path)) {
//                $_p = $path . $shortcode . '.php';
//            }
            $_p = $path . $shortcode . '.php';
            if (file_exists($_p)) {
                vc_lean_map($shortcode, null, $_p);
            }
        }
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function account($atts = array(), $content = '') {
        $atts = shortcode_atts(array(
            'style' => 'menu',
            'alignment' => 'left',
            'css'   => '',
        ), $atts, 'otf_header_account');
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/account.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function cart($atts = array(), $content = '') {
        $atts = shortcode_atts(array(
            'style' => 'style_1',
            'alignment' => 'left',
            'css'   => '',
        ), $atts, 'otf_header_cart');
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/cart.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function header_logo($atts = array(), $content = '') {
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/site-branding.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function main_navigation($atts = array(), $content = '') {
        $atts = shortcode_atts(array(
            'display'     => 'inline',
            'align'       => 'left',
            'logo'        => false,
            'skin'        => '',
            'css'         => '',
            'smooth_menu' => false,
        ), $atts, 'otf_header_main_navigation');
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/navigation.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function search($atts = array(), $content = '') {
        $atts = shortcode_atts(array(
            'button_color' => 'primary',
            'border_color' => 'primary',
            'style'        => 'otf-style-default',
            'el_class'     => '',
            'css'          => ''
        ), $atts, 'otf_header_search');
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/search-form.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function search_button($atts = array(), $content = '') {
        $atts = shortcode_atts(array(
            'skin' => '',
            'css'  => ''
        ), $atts, 'otf_header_search_button');
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/search-button.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function navigation_button($atts = array(), $content = '') {
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/navigation-button.php', $atts);
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function wishlist_button($atts = array(), $content = '') {
        if (!otf_is_woocommerce_extension_activated('YITH_WCWL')) {
            return '';
        }
        if (!empty($atts['css'])) {
            $atts['css'] = $this->get_css_class_filter($atts['css']);
        }
        return $this->get_template('template-parts/header/wishlist.php', $atts);
    }


    /**
     * @param $slug string
     *
     * @return string
     */
    private function get_template($template, $atts = array()) {
        ob_start();
        $file = get_theme_file_path($template);
        if (file_exists($file)) {
            include $file;
        }

        return ob_get_clean();
    }

    private function get_css_class_filter($css) {
        $class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $class = vc_shortcode_custom_css_class($css, ' ');
        }
        return $class;
    }
}

new OTF_Header_builder();