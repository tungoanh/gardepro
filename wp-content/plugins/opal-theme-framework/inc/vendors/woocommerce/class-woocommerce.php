<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('OTF_WooCommerce')) :


    class OTF_WooCommerce {

        static $instance;

        /**
         * @var array
         */
        public $list_shortcodes;

        private $list_size = 'shop_thumbnail';

        /**
         * @return OTF_WooCommerce
         */
        public static function getInstance() {
            if (!isset(self::$instance) && !(self::$instance instanceof OTF_WooCommerce)) {
                self::$instance = new OTF_WooCommerce();
            }

            return self::$instance;
        }

        /**
         * Setup class.
         *
         * @since 1.0
         *
         */
        public function __construct() {
            $this->list_shortcodes = array(
                'recent_products',
                'sale_products',
                'best_selling_products',
                'top_rated_products',
                'featured_products',
                'related_products',
                'product_category',
                'product',
            );
            $this->init_shortcodes();

            add_action('after_setup_theme', array($this, 'after_setup_theme'));

            add_filter('body_class', array($this, 'body_class'));
            add_filter('opal_theme_sidebar', array($this, 'set_sidebar'), 20);
            add_filter('otf_customizer_buttons', array($this, 'customizer_buttons'));

            add_action('wp_enqueue_scripts', array($this, 'woocommerce_scripts'), 20);
            add_filter('woocommerce_enqueue_styles', '__return_empty_array');

            add_filter('woocommerce_output_related_products_args', array($this, 'related_products_args'));
            add_filter('woocommerce_product_thumbnails_columns', array($this, 'thumbnail_columns'));
            add_filter('loop_shop_per_page', array($this, 'products_per_page'));
            add_filter('woocommerce_breadcrumb_defaults', array($this, 'change_breadcrumb_delimiter'));
            add_filter('woocommerce_show_page_title', '__return_false');

            add_action('widgets_init', array($this, 'widgets_init'));

            if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.5', '<')) {
                add_action('wp_footer', array($this, 'star_rating_script'));
            }

            if (class_exists('YITH_WCWL_Init')) {
                remove_action('wp_head', array(YITH_WCWL_Init::get_instance(), 'detect_javascript'), 0);
            }

            add_action('cmb2_admin_init', array($this, 'taxonomy_metaboxes'));

            add_filter('otf_customize_sidebar_width', array($this, 'set_sidebar_width_customize'));
            add_filter('otf_customize_layout_page', array($this, 'customize_layout_page'));

            if (isset($_GET['display']) && $_GET['display'] === 'list') {
                add_action('woocommerce_before_shop_loop', array($this, 'filter_layout_archive'));
                add_action('woocommerce_after_shop_loop', array($this, 'remove_filter_layout_archive'));
            }

            add_action('woocommerce_before_template_part', array($this, 'add_layout_before_cross_sells'), 10, 4);
            add_action('woocommerce_after_template_part', array($this, 'add_layout_after_cross_sells'), 10, 4);
            add_action('wp_footer', array($this, 'added_to_cart_template'));

            // Thirt-party
            add_filter('ywsfd_share_position', array($this, 'ywsfd_share_position'));
            if (defined('YITH_WCWL')) {
                add_action('wp_ajax_otf_update_wishlist_count', array($this, 'yith_wcwl_ajax_update_count'));
                add_action('wp_ajax_nopriv_otf_update_wishlist_count', array($this, 'yith_wcwl_ajax_update_count'));
            }

            add_action('wp_footer', array($this, 'label_tooltip'));

            add_action('wp_print_styles', array($this, 'remove_css_vendors'), 999);
            add_filter('otf_woocommerce_custom_shortcode_settings', array($this, 'shortcode_settings'));

            // Woocommerce 3.3
            if (otf_woocommerce_version_check('3.3')) {
                add_action('customize_register', array($this, 'edit_section_customizer'), 99);
            }

            // Wocommerce filter
            if (is_active_sidebar('sidebar-woocommerce-shop-filters')) {
                add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 5);
                add_action('woocommerce_before_shop_loop', array($this, 'render_button_shop_canvas'), 2);
            }
            if (get_theme_mod('otf_woocommerce_archive_filter_position', 'left') == 'top') {
                add_action('woocommerce_before_shop_loop', array($this, 'render_woocommerce_shop_canvas'));
            } else {
                add_action('wp_footer', array($this, 'render_woocommerce_shop_canvas'), 1);
            }
        }

        /**
         * @param $wp_customizer WP_Customize_Manager
         */
        public function edit_section_customizer($wp_customizer) {
            $wp_customizer->get_control('woocommerce_single_image_width')->section = 'otf_woocommerce_single';
            $wp_customizer->get_control('woocommerce_single_image_width')->priority = 9;

            $wp_customizer->get_control('woocommerce_thumbnail_image_width')->section = 'otf_woocommerce_product';
            $wp_customizer->get_control('woocommerce_thumbnail_cropping')->section = 'otf_woocommerce_product';

            $wp_customizer->get_control('woocommerce_shop_page_display')->section = 'otf_woocommerce_archive';
            $wp_customizer->get_control('woocommerce_shop_page_display')->priority = 21;

            $wp_customizer->get_control('woocommerce_category_archive_display')->section = 'otf_woocommerce_archive';
            $wp_customizer->get_control('woocommerce_category_archive_display')->priority = 21;

            $wp_customizer->get_control('woocommerce_default_catalog_orderby')->section = 'otf_woocommerce_archive';
            $wp_customizer->get_control('woocommerce_default_catalog_orderby')->priority = 21;
        }

        /**
         * @param $out
         * @param $pairs
         * @param $atts
         *
         * @return array
         */
        public function set_shortcode_attributes($out, $pairs, $atts) {
            $out = wp_parse_args($atts, $out);
            return $out;
        }

        /**
         * @param $settings
         *
         * @return array
         */
        public function shortcode_settings($settings) {
            $settings = wp_parse_args(array(
                array(
                    "type"       => "dropdown",
                    "heading"    => esc_html__("Style", 'opal-theme-framework'),
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    "param_name" => "style",
                    'value'      => array(
                        esc_html__('Grid', 'opal-theme-framework')     => 'grid',
                        esc_html__('List', 'opal-theme-framework')     => 'list',
                        esc_html__('Carousel', 'opal-theme-framework') => 'carousel',
                    ),
                    'std'        => 'grid',
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Enable boxed', 'opal-theme-framework'),
                    'param_name' => 'boxed',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => true,
                    ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('list'),
                    ),
                ),
                array(
                    'type'       => 'dropdown',
                    'heading'    => __('Listing Skin', 'opal-theme-framework'),
                    'param_name' => 'listing_skin',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Default', 'opal-theme-framework')     => 'skin-default',
                        esc_html__('Line Bottom', 'opal-theme-framework') => 'skin-line-bottom',
                        esc_html__('Line Right', 'opal-theme-framework') => 'skin-line-right',
                        esc_html__('Border box', 'opal-theme-framework')  => 'skin-border-box',
                    ),
                    'std'        => 'skin-1',
                    'dependency' => array(
                        'element'  => 'boxed',
                        'is_empty' => true,
                    ),
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Enable Big Typo', 'opal-theme-framework'),
                    'param_name' => 'big_typo',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => true,
                    ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('list'),
                    ),
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Show Rating', 'opal-theme-framework'),
                    'param_name' => 'show_rating',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => true,
                    ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('list'),
                    ),
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Show Category', 'opal-theme-framework'),
                    'param_name' => 'show_category',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => true,
                    ),
                    'std'        => true,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('list'),
                    ),
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Show Short Description', 'opal-theme-framework'),
                    'param_name' => 'show_except',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => true,
                    ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('list'),
                    ),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Image size', 'opal-theme-framework'),
                    'param_name'  => 'image_size',
                    'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
                    'dependency'  => array(
                        'element' => 'style',
                        'value'   => array('list'),
                    ),
                ),

                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Show Dot', 'opal-theme-framework'),
                    'param_name' => 'show_dot',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => 'true',
                    ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('carousel'),
                    ),
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Show Navigation', 'opal-theme-framework'),
                    'param_name' => 'show_nav',
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    'value'      => array(
                        esc_html__('Yes', 'opal-theme-framework') => 'true',
                    ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'style',
                        'value'   => array('carousel'),
                    ),
                ),
                array(
                    "type"       => "dropdown",
                    "heading"    => esc_html__("Navigation Position", 'opal-theme-framework'),
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    "param_name" => "nav_position",
                    'value'      => array(
                        esc_html__('Top - Center', 'opal-theme-framework')    => 'top-center',
                        esc_html__('Top - Right', 'opal-theme-framework')     => 'top-right',
                        esc_html__('Middle - Center', 'opal-theme-framework') => 'middle-center',
                        esc_html__('Bottom - Center', 'opal-theme-framework') => 'bottom-center',
                    ),
                    'std'        => 'middle-center',
                    'dependency' => array(
                        'element' => 'show_nav',
                        'value'   => array('true'),
                    ),
                ),
                array(
                    "type"       => "dropdown",
                    "heading"    => esc_html__("Navigation Style", 'opal-theme-framework'),
                    'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                    "param_name" => "nav_style",
                    'value'      => array(
                        esc_html__('Style 1', 'opal-theme-framework') => 'style-1',
                        esc_html__('Style 2', 'opal-theme-framework') => 'style-2',
                    ),
                    'std'        => 'style-1',
                    'dependency' => array(
                        'element' => 'show_nav',
                        'value'   => array('true'),
                    ),
                ),
            ), $settings);
            return $settings;
        }

        public function remove_css_vendors() {
            wp_dequeue_style('dgwt-wcas-style');
        }

        public function label_tooltip() {
            echo '<div class="woocommerce-lablel-tooltip" style="display: none!important;">';
            echo '<div id="otf-woocommerce-cart">' . esc_html__('Add to cart', 'opal-theme-framework') . '</div>';
            echo '</div>';
        }

        public function yith_wcwl_ajax_update_count() {
            wp_send_json(array(
                'count' => yith_wcwl_count_all_products(),
            ));
        }

        public function ywsfd_share_position($args) {
            $args['priority'] = 45;

            return $args;
        }

        public function added_to_cart_template() {
            $text = esc_html__('has been added to your cart', 'opal-theme-framework');
            echo <<<HTML
        <script type="text/html" id="tmpl-added-to-cart-template"><div class="notification-added-to-cart"><div class="notification-wrap"><div class="ns-thumb d-inline-block"><img src="{{{data.src}}}" alt="{{{data.name}}}"></div><div class="ns-content d-inline-block"><p><strong>{{{data.name}}}</strong> $text </p></div></div></div></script>
HTML;
        }


        public function add_layout_before_cross_sells($template_name, $template_path, $located, $args) {
            if ($template_name === 'cart/cross-sells.php') {
                echo '<div class="columns-' . esc_attr($args["columns"]) . '">';
            }
        }

        public function add_layout_after_cross_sells($template_name, $template_path, $located, $args) {
            if ($template_name === 'cart/cross-sells.php') {
                echo '</div>';
            }
        }

        public function filter_layout_archive() {
            add_filter('wc_get_template_part', array($this, 'add_layout_list_archive'), 10, 3);
        }

        public function remove_filter_layout_archive() {
            remove_filter('wc_get_template_part', array($this, 'add_layout_list_archive'), 10);
        }

        public function add_layout_list_archive($template, $slug, $name) {
            if ($slug === 'content' && $name === 'product') {
                $newTemplate = get_theme_file_path('woocommerce/content-product-list.php');
                if (file_exists($newTemplate)) {
                    return $newTemplate;
                } else {
                    return trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'templates/woocommerce/content-product-list.php';
                }
            }

            return $template;
        }

        public function customize_layout_page($layout) {
            if (otf_is_product_archive()) {
                $layout = get_theme_mod('otf_woocommerce_archive_layout', '2cr');
            } elseif (is_product()) {
                $layout = get_theme_mod('otf_woocommerce_single_layout', '2cr');
            }

            return $layout;
        }

        public function widgets_init() {
            register_sidebar(array(
                'name'          => __('Woocommerce Shop', 'opal-theme-framework'),
                'id'            => 'sidebar-woocommerce-shop',
                'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'opal-theme-framework'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
            register_sidebar(array(
                'name'          => __('Woocommerce Detail', 'opal-theme-framework'),
                'id'            => 'sidebar-woocommerce-detail',
                'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'opal-theme-framework'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
            register_sidebar(array(
                'name'          => __('Woocommerce Shop Filters', 'opal-theme-framework'),
                'id'            => 'sidebar-woocommerce-shop-filters',
                'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'opal-theme-framework'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }

        public function render_woocommerce_shop_canvas() {
            $position = get_theme_mod('otf_woocommerce_archive_filter_position', 'left');
            if (is_active_sidebar('sidebar-woocommerce-shop-filters')) {
                echo '<div id="opal-canvas-filter" class="opal-canvas-filter ' . $position . '"><span class="filter-close">'.__('CLOSE', 'opal-theme-framework').'</span><div class="opal-canvas-filter-wrap">';
                dynamic_sidebar('sidebar-woocommerce-shop-filters');
                echo '</div></div>';
                echo '<div class="opal-overlay-filter"></div>';
            }

        }

        public function render_button_shop_canvas() {
            if (is_active_sidebar('sidebar-woocommerce-shop-filters')) {
                echo '<button class="filter-toggle" aria-expanded="false"><span class="filter-icon"></span>' . __('SHOW FILTER', 'opal-theme-framework') . '</button>';
            }
        }

        public function productIdAutocompleteRender($query) {
            $query = trim($query['value']); // get value from requested
            if (!empty($query)) {
                // get product
                $product_object = wc_get_product((int)$query);
                if (is_object($product_object)) {
                    $product_sku = $product_object->get_sku();
                    $product_title = $product_object->get_title();
                    $product_id = $product_object->get_id();

                    $product_sku_display = '';
                    if (!empty($product_sku)) {
                        $product_sku_display = ' - ' . __('Sku', 'opal-theme-framework') . ': ' . $product_sku;
                    }

                    $product_title_display = '';
                    if (!empty($product_title)) {
                        $product_title_display = ' - ' . __('Title', 'opal-theme-framework') . ': ' . $product_title;
                    }

                    $product_id_display = __('Id', 'opal-theme-framework') . ': ' . $product_id;

                    $data = array();
                    $data['value'] = $product_id;
                    $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

                    return !empty($data) ? $data : false;
                }

                return false;
            }

            return false;
        }

        public function productCategoryAutocompleteRender($query) {
            $query = $query['value'];
            $query = trim($query);
            $term = get_term_by('slug', $query, 'product_cat');

            $term_slug = $term->slug;
            $term_title = $term->name;
            $term_id = $term->term_id;

            $term_slug_display = '';
            if (!empty($term_slug)) {
                $term_slug_display = ' - ' . __('Sku', 'opal-theme-framework') . ': ' . $term_slug;
            }

            $term_title_display = '';
            if (!empty($term_title)) {
                $term_title_display = ' - ' . __('Title', 'opal-theme-framework') . ': ' . $term_title;
            }

            $term_id_display = __('Id', 'opal-theme-framework') . ': ' . $term_id;

            $data = array();
            $data['value'] = $term_id;
            $data['label'] = $term_id_display . $term_title_display . $term_slug_display;

            return !empty($data) ? $data : false;
        }

        public function productCategoryAutocompleteSuggester($query) {
            global $wpdb;
            $cat_id = (int)$query;
            $query = trim($query);
            $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : -1, stripslashes($query), stripslashes($query)), ARRAY_A);

            $result = array();
            if (is_array($post_meta_infos) && !empty($post_meta_infos)) {
                foreach ($post_meta_infos as $value) {
                    $data = array();
                    $data['value'] = $value['slug'];
                    $data['label'] = __('Id', 'opal-theme-framework') . ': ' . $value['id'] . ((strlen($value['name']) > 0) ? ' - ' . __('Name', 'opal-theme-framework') . ': ' . $value['name'] : '') . ((strlen($value['slug']) > 0) ? ' - ' . __('Slug', 'opal-theme-framework') . ': ' . $value['slug'] : '');
                    $result[] = $data;
                }
            }

            return $result;
        }

        public function productIdAutocompleteSuggester($query) {
            global $wpdb;
            $product_id = (int)$query;
            $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
					FROM {$wpdb->posts} AS a
					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : -1, stripslashes($query), stripslashes($query)), ARRAY_A);

            $results = array();
            if (is_array($post_meta_infos) && !empty($post_meta_infos)) {
                foreach ($post_meta_infos as $value) {
                    $data = array();
                    $data['value'] = $value['id'];
                    $data['label'] = __('Id', 'opal-theme-framework') . ': ' . $value['id'] . ((strlen($value['title']) > 0) ? ' - ' . __('Title', 'opal-theme-framework') . ': ' . $value['title'] : '') . ((strlen($value['sku']) > 0) ? ' - ' . __('Sku', 'opal-theme-framework') . ': ' . $value['sku'] : '');
                    $results[] = $data;
                }
            }

            return $results;
        }

        public function taxonomy_metaboxes() {
            $prefix = 'product_cat_';
            $cmb_term = new_cmb2_box(array(
                'id'           => 'product_cat',
                'title'        => __('Product Metabox', 'opal-theme-framework'), // Doesn't output for term boxes
                'object_types' => array('term'),
                'taxonomies'   => array('product_cat'),
                // 'new_term_section' => true, // Will display in the "Add New Category" section
            ));

            $cmb_term->add_field(array(
                'name'       => __('Banner', 'opal-theme-framework'),
                //                'desc' => __('Location image', 'homefinder'),
                'id'         => $prefix . 'banner',
                'type'       => 'file',
                'options'    => array(
                    'url' => false, // Hide the text input for the url
                ),
                'query_args' => array(
                    'type' => 'image',
                ),
            ));
        }

        /**
         * @return void
         */
        public function after_setup_theme() {
            add_theme_support('woocommerce');
        }

        /**
         * @return void
         *
         * @see do_shortcode()
         */
        private function init_shortcodes() {
            foreach ($this->list_shortcodes as $shortcode) {
                add_filter('shortcode_atts_' . $shortcode, array($this, 'set_shortcode_attributes'), 10, 3);
                add_action('woocommerce_shortcode_before_' . $shortcode . '_loop', array($this, 'style_loop_start'));
                add_action('woocommerce_shortcode_before_' . $shortcode . '_loop', array($this, 'shortcode_loop_start'));
                add_action('woocommerce_shortcode_after_' . $shortcode . '_loop', array($this, 'style_loop_end'));
                add_action('woocommerce_shortcode_after_' . $shortcode . '_loop', array($this, 'shortcode_loop_end'));
            }

            add_action('woocommerce_shortcode_before_otf_product_deal_loop', array($this, 'style_loop_start'));
            add_action('woocommerce_shortcode_before_otf_product_deal_loop', array($this, 'shortcode_loop_start'));
            add_action('woocommerce_shortcode_after_otf_product_deal_loop', array($this, 'style_loop_end'));
            add_action('woocommerce_shortcode_after_otf_product_deal_loop', array($this, 'shortcode_loop_end'));
        }

        public function shortcode_loop_end($atts = array()) {
            if (isset($atts['style'])) {
                if ($atts['style'] === 'list') {
                    remove_filter('wc_get_template_part', 'otf_woocommerce_change_path_shortcode', 10);
                } elseif ($atts['style'] === 'carousel') {
                    echo '</div>';
                }
            }

            if (!empty($atts['image_size'])) {
                remove_filter('woocommerce_product_get_image', array($this, 'set_image_size_list'), 10);
            }
        }

        public function shortcode_loop_start($atts = array()) {
            if (isset($atts['style'])) {
                if ($atts['style'] === 'list') {
                    add_filter('wc_get_template_part', 'otf_woocommerce_change_path_shortcode', 10, 3);
                    if (!empty($atts['image_size'])) {
                        $this->list_size = $atts['image_size'];
                        add_filter('woocommerce_product_get_image', array($this, 'set_image_size_list'), 10, 2);
                    }
                } elseif ($atts['style'] === 'carousel') {
                    $nav = (isset($atts['show_nav']) && $atts['show_nav'] === 'true') ? 'true' : 'false';
                    $dot = (isset($atts['show_dot']) && $atts['show_dot'] === 'true') ? 'true' : 'false';
                    $nav_position = (!empty($atts['nav_position'])) ? $atts['nav_position'] : 'middle-center';
                    $nav_style = (!empty($atts['nav_style'])) ? $atts['nav_style'] : 'style-1';
                    echo '<div class="woocommerce-carousel owl-theme nav-position-' . $nav_position . ' nav-' . $nav_style . '" data-columns="' . esc_attr($atts['columns']) . '" 
                        data-nav="' . esc_attr($nav) . '" data-dot="' . esc_attr($dot) . '">';
                }
            }
        }

        public function style_loop_start($atts = array()) {
            if (isset($atts['style']) && $atts['style'] != 'default') {
                $classes = '';
                if ($atts['style'] === 'list') {
                    if (!empty($atts['show_category'])) {
                        add_action('otf_product_list_before_price', 'otf_woocommerce_list_show_category', 15);
                    }

                    if (!empty($atts['show_rating'])) {
                        add_action('otf_product_list_before_price', 'otf_woocommerce_list_show_rating', 10);
                    }

                    if (!empty($atts['show_except'])) {
                        add_action('otf_product_list_after_price', 'otf_woocommerce_list_show_excerpt', 15);
                    }
                    if (!empty($atts['boxed'])) {
                        $classes .= ' boxed';
                    } else {
                        if (!empty($atts['listing_skin'])) {
                            $classes .= ' ' . $atts['listing_skin'];
                        }
                    }

                    if (!empty($atts['big_typo'])) {
                        $classes .= ' big-typo';
                    }
                }
                echo '<div class="woocommerce-product-' . esc_attr($atts['style']) . esc_attr($classes) . '">';
            }
        }


        public function style_loop_end($atts = array()) {
            if (isset($atts['style']) && $atts['style'] != 'default') {
                echo '</div>';
                if ($atts['style'] === 'list') {
                    if (!empty($atts['show_category'])) {
                        remove_action('otf_product_list_before_price', 'otf_woocommerce_list_show_category', 15);
                    }

                    if (!empty($atts['show_rating'])) {
                        remove_action('otf_product_list_before_price', 'otf_woocommerce_list_show_rating', 10);
                    }

                    if (!empty($atts['show_except'])) {
                        remove_action('otf_product_list_after_price', 'otf_woocommerce_list_show_excerpt', 15);
                    }
                }
            }
        }

        /**
         * @param $image   string
         * @param $product WC_Product
         */
        public function set_image_size_list($image, $product) {
            $image_id = get_post_thumbnail_id($product->get_id());
            $thumb_size = otf_get_image_size($this->list_size);
            $thumbnail = wpb_resize($image_id, null, $thumb_size[0], $thumb_size[1], true);
            $image = '<img width="' . esc_attr($thumbnail['width']) . '" height="' . esc_attr($thumbnail['height']) . '" src="' . esc_attr($thumbnail['url']) . '" alt="' . esc_attr($product->get_title()) . '"/>';
            return wc_get_relative_url($image);
        }


        public function body_class($classes) {
            $classes[] = 'woocommerce-active';
            if (otf_is_product_archive()) {
                $classes = array_diff($classes, array('opal-content-layout-2cl', 'opal-content-layout-2cr', 'opal-content-layout-1c'));
                $classes[] = 'opal-content-layout-' . get_theme_mod('otf_woocommerce_archive_layout', '2cr');
            } else {
                if (is_product()) {
                    $classes = array_diff($classes, array('opal-content-layout-2cl', 'opal-content-layout-2cr', 'opal-content-layout-1c'));
                    $classes[] = 'opal-content-layout-' . get_theme_mod('otf_woocommerce_single_layout', '2cr');
                    $classes[] = 'woocommerce-single-style-' . get_theme_mod('otf_woocommerce_single_product_style', '1');
                    if (get_theme_mod('otf_woocommerce_single_product_width', 0)) {
                        $classes[] = 'otf_woocommerce_single_product_style_full';
                    }

                }
            }

            $classes[] = 'product-style-' . get_theme_mod('otf_woocommerce_product_style', 1);

            if (get_theme_mod('otf_woocommerce_product_boxshadow_custom_enable', 0)) {
                $classes[] = 'product-boxshadow';
            }

            if ($shape = get_theme_mod('otf_woocommerce_product_label_sale_shape', 'square')) {
                $classes[] = 'opal-label-sale-' . esc_attr($shape);
            }

            return $classes;
        }

        public function set_sidebar($name) {
            if (otf_is_product_archive()) {
                $mode = get_theme_mod('otf_woocommerce_archive_layout', '2cr');
                if ($mode == '1c') {
                    $name = '';
                } else {
                    if ($sidebar = get_theme_mod('otf_woocommerce_archive_sidebar', '')) {
                        $name = $sidebar;
                    }
                }
            } else {
                if (is_product()) {
                    $mode = get_theme_mod('otf_woocommerce_single_layout', '2cr');
                    if ($mode == '1c') {
                        $name = '';
                    } else {
                        if ($sidebar = get_theme_mod('otf_woocommerce_single_sidebar', '')) {
                            $name = $sidebar;
                        }
                    }
                }
            }

            return $name;
        }

        public function set_sidebar_width_customize($width) {
            if (otf_is_product_archive()) {
                $width = get_theme_mod('otf_woocommerce_archive_sidebar_width', 320);
            } elseif (is_product()) {
                $width = get_theme_mod('otf_woocommerce_single_sidebar_width', 320);
            }

            return $width;
        }

        /**
         * WooCommerce specific scripts & stylesheets
         *
         * @since 1.0.0
         */
        public function woocommerce_scripts() {
            wp_enqueue_script('otf-woocommerce-single', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . '/assets/js/woocommerce/main.js', array(), false, true);
            if (is_product()) {
                //                wp_enqueue_style( 'homefinder-woocommerce-single', get_template_directory_uri() . '/assets/css/woocommerce/single-product-'.get_theme_mod('otf_woocommerce_single_product_style', '1').'.css', array() );
                wp_enqueue_script('otf-woocommerce-single', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . '/assets/js/woocommerce/single.js', array(), false, true);
                if (get_theme_mod('otf_woocommerce_single_product_tab_style', 'tab') == 'accordion') {
                    wp_enqueue_script('otf-woocommerce-single-accordion', trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_URL) . 'assets/js/woocommerce/woocommerce-accordion.js', array(), false, true);
                }
            }
            wp_dequeue_style('yith-wcwl-font-awesome');
        }

        /**
         * Star rating backwards compatibility script (WooCommerce <2.5).
         *
         * @since 1.6.0
         */
        public function star_rating_script() {
            if (wp_script_is('jquery', 'done') && is_product()) {
                ?>
                <script type="text/javascript">
                    jQuery(function ($) {
                        $('body').on('click', '#respond p.stars a', function () {
                            var $container = $(this).closest('.stars');
                            $container.addClass('selected');
                        });
                    });
                </script>
                <?php
            }
        }

        /**
         * Related Products Args
         *
         * @param  array $args related products args.
         *
         * @since 1.0.0
         * @return  array $args related products args
         */
        public function related_products_args($args) {
            $args = apply_filters('otf_related_products_args', array(
                'posts_per_page' => get_theme_mod('otf_woocommerce_single_related_number', 3),
                'columns'        => get_theme_mod('otf_woocommerce_single_related_columns', 3),
            ));

            return $args;
        }

        /**
         * Product gallery thumnail columns
         *
         * @return integer number of columns
         * @since  1.0.0
         */
        public function thumbnail_columns() {
            $columns = get_theme_mod('otf_woocommerce_product_thumbnail_columns', 3);

            return intval(apply_filters('otf_product_thumbnail_columns', $columns));
        }

        /**
         * Products per page
         *
         * @return integer number of products
         * @since  1.0.0
         */
        public function products_per_page() {
            $number = get_theme_mod('otf_woocommerce_archive_number', 12);

            return intval(apply_filters('otf_products_per_page', $number));
        }


        /**
         * Remove the breadcrumb delimiter
         *
         * @param  array $defaults thre breadcrumb defaults
         *
         * @return array           thre breadcrumb defaults
         * @since 2.2.0
         */
        public function change_breadcrumb_delimiter($defaults) {
            $defaults['delimiter'] = '<span class="breadcrumb-separator"> / </span>';

            return $defaults;
        }

        public function customizer_buttons($buttons) {
            $buttons = wp_parse_args($buttons, array(
                '.single-product #content'             => array(
                    array(
                        'id'   => 'otf_woocommerce_single',
                        'icon' => 'default',
                        'type' => 'section',
                    ),
                ),
                '.archive.woocommerce-page #content'   => array(
                    array(
                        'id'   => 'otf_woocommerce_archive',
                        'icon' => 'default',
                        'type' => 'section',
                    ),
                ),
                '.woocommerce-pagination'              => array(
                    array(
                        'id'      => 'otf_layout_pagination_style',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => '.button-change-image|click',
                    ),
                ),
                '.single-product .flex-control-thumbs' => array(
                    array(
                        'id'      => 'otf_woocommerce_product_thumbnail_columns',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '.single-product .related'             => array(
                    array(
                        'id'      => 'otf_woocommerce_single_related_columns',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '.single-product .upsells'             => array(
                    array(
                        'id'      => 'otf_woocommerce_single_upsale_columns',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '.products .type-product'              => array(
                    array(
                        'id'      => 'otf_woocommerce_product_hover',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '#otf-accordion-container'             => array(
                    array(
                        'id'      => 'otf_woocommerce_single_product_tab_style',
                        'icon'    => 'layout',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
            ));

            return $buttons;
        }

        public function add_support_zoom() {
            add_theme_support('wc-product-gallery-zoom');
        }

        public function add_support_lightbox() {
            add_theme_support('wc-product-gallery-lightbox');
        }

        public function add_support_slider() {
            add_theme_support('wc-product-gallery-slider');
        }

        public function add_support_gallery_all() {
            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');
        }

    }
endif;

OTF_WooCommerce::getInstance();

