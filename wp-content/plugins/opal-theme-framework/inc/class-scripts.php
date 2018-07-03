<?php
if (!defined('ABSPATH')) {
    exit;
}

class OTF_Scripts {
    /**
     * OTF_Scripts constructor.
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'add_admin_scripts'), 999);
        add_action('customize_preview_init', array($this, 'init_preview_js'));
        add_action('customize_controls_enqueue_scripts', array($this, 'init_panel_customize_js'));

        add_action('after_switch_theme', array($this, 'set_style_theme_mods'));
        add_action('customize_save_after', array($this, 'set_style_theme_mods'));
        add_action('wp_enqueue_scripts', array($this, 'add_frontend_scripts'), 100);

        add_action('wp_footer', array($this, 'megamenu_css'));
        add_action('admin_head', array($this, 'fix_svg_thumb_display'));
    }

    /**
     * Assign styles to individual theme mod.
     *
     * @return void
     */
    public function set_style_theme_mods() {
        set_theme_mod('otf_theme_custom_style', otf_theme_custom_css());
        set_theme_mod('otf_theme_google_fonts', otf_get_fonts_url());
    }

    public function add_frontend_scripts() {
        global $post;
        wp_register_script('otf-sticky-layout-js', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/sticky-layout.js', array('jquery', 'wp-util'), false, true);
        wp_register_script('tilt-jquery', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/libs/tilt.jquery.min.js', array('jquery', 'wp-util'), false, true);
        wp_register_script('otf-sticky-header-js', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/sticky-header.js', array('jquery', 'wp-util'), false, true);
        wp_register_script('otf-counter', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/counter.js', array('jquery'), '1.0.0', true);
        wp_register_script('otf-parallax-scroll', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . '/assets/js/parallax.js', array('jquery'), false, true);
        wp_register_script('otf-countdown', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . '/assets/js/countdown.js', array('jquery'), false, true);
//        wp_register_script( 'magnific-popup', get_theme_file_uri( '/assets/js/libs/jquery.magnific-popup.js' ), array('jquery'), false, true );
//        wp_register_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.css' ) );

        if (get_theme_support('opal-customize-css')) {
            $dev_mode = get_theme_mod('otf_dev_mode', false);
            // Custom Css
            if ($dev_mode) {
                $google_fonts_url = otf_get_fonts_url();
            } else {
                $google_fonts_url = get_theme_mod('otf_theme_google_fonts', false);
            }
            if ($google_fonts_url) {
                wp_enqueue_style('otf-fonts', $google_fonts_url, array(), null);
            }

            $themeSlug = get_template();
            if (is_customize_preview() || $dev_mode) {
                wp_add_inline_style($themeSlug . '-style', otf_theme_custom_css());
            } else {
                wp_add_inline_style($themeSlug . '-style-responsive', get_theme_mod('otf_theme_custom_style', ''));
            }

            if(is_customize_preview()){
                add_action('wp_footer', array($this, 'customizer_inline_css'));
            }
            if($dev_mode){
                wp_add_inline_style($themeSlug . '-style', apply_filters('otf_theme_custom_inline_css', ''));
            }else{
                wp_add_inline_style($themeSlug . '-style-responsive', apply_filters('otf_theme_custom_inline_css', ''));
            }
        }

        // Dequeue Contact Form 7 related assets if not necessary.
        if (isset($post->post_content) && !(has_shortcode($post->post_content, 'contact-form-7'))) {
            wp_dequeue_style('contact-form-7');
            wp_dequeue_script('contact-form-7');
        }

        // Dequeue Revolution Slider assets if not necessary.
        if (isset($post->post_content) && (!(has_shortcode($post->post_content, 'rev_slider') || has_shortcode($post->post_content, 'rev_slider_vc')))) {
            wp_dequeue_style('rs-plugin-settings');
            wp_dequeue_script('tp-tools');
            wp_dequeue_script('revmin');
        }
//        if (get_theme_mod( 'otf_header_layout_is_sticky', false )){
        wp_enqueue_script('otf-sticky-header-js');
//        }
        wp_enqueue_script('otf-sticky-layout-js');

        //Opal Counter
        if (isset($post->post_content)) {
            if (has_shortcode($post->post_content, 'otf_counter')) {
                wp_enqueue_script('otf-counter');
            }
//            if (has_shortcode($post->post_content, 'otf_countdown') || has_shortcode($post->post_content, 'otf_product_deals') || has_shortcode($post->post_content, 'olp_demo_item')) {
            wp_enqueue_script('otf-countdown');
//                wp_enqueue_script('jquery-ui-datepicker');
//                wp_enqueue_script('datepicker-js', get_theme_file_uri('/assets/js/datepicker.js'));
//            }

            if (has_shortcode($post->post_content, 'otf_parallax') || has_shortcode($post->post_content, 'otf_product_parallax')) {
                wp_enqueue_script('otf-parallax-scroll');
            }
        }


//        if (is_single() && 'gallery' === get_post_format( $post->ID )){
//            wp_enqueue_script( 'magnific-popup' );
//            wp_enqueue_style( 'magnific-popup' );
//        }

        // Owl Carousel
        wp_enqueue_script('owl-carousel', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/libs/owl.carousel.js', array('jquery'), '2.2.1');
        wp_enqueue_script('otf-carousel', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/carousel.js', array('owl-carousel'));

        wp_enqueue_style('otf-style', OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/css/wocommerce.css');

    }

    public function customizer_inline_css() {
        echo '<div id="otf-style-inline-css-customizer" class="d-none">';
        otf_customize_partial_css();
        echo '</div>';
    }


    public function init_panel_customize_js() {
        wp_enqueue_script(
            'otf-admin-customize',
            OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/js/customizer/customize.js',
            array('jquery'),
            null,
            true
        );
    }


    /**
     * @return void
     */
    public function init_preview_js() {
        wp_enqueue_style('otf-theme-preview', OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/css/customize-preview.css');
        wp_enqueue_script('otf-theme-preview', OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/js/customizer/preview.js', array('jquery', 'customize-preview'), OPAL_THEME_FRAMEWORK_VERSION, true);
        wp_localize_script('otf-theme-preview', 'otfCustomizerButtons', apply_filters('otf_customizer_buttons', array()));
    }

    /**
     * @return void
     */
    public function add_admin_scripts($hook) {
        global $post;
        if ($hook === 'widgets.php') {
            wp_enqueue_script(
                'otf-admin-color',
                OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/3rd-party/alpha-color-picker/alpha-color-picker.js',
                array('jquery'),
                null,
                true
            );
        }

        wp_enqueue_script(
            'otf-admin-select2',
            OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/3rd-party/select2/select2.js',
            array('jquery'),
            null,
            true
        );


        wp_enqueue_style('otf-admin-style',
            OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/css/admin.css');
        wp_enqueue_style('otf-icon',
            OPAL_THEME_FRAMEWORK_PLUGIN_URL . 'assets/css/opal-icon.css');

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            wp_enqueue_script('otf-admin-page', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/admin-page.js');
        }
    }


    public function megamenu_css() {
        global $megamenu_css;
        if ($megamenu_css) {
            echo '<script>';
            echo <<<JS
    jQuery('head').append('<style id="otf-megamenu-render-css" type="text/css">{$megamenu_css}</style>');
JS;
            echo '</script>';
        }
    }

    public function fix_svg_thumb_display() {
        echo '<style type="text/css">
    .media-icon img[src$=".svg"] { 
      width: 100% !important; 
      height: auto !important; 
    }
    </style>
  ';
    }
}

new OTF_Scripts();