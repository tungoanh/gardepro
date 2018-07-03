<?php
require 'class/base.php';
require 'class/container.php';

class OTF_Visual_Composer {

    private $giparams = array();

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'), 9);
        add_action('vc_after_mapping', array($this, 'init_shortcodes'));
        require_once vc_path_dir('CONFIG_DIR', 'grids/vc-grids-functions.php');
        if ('vc_get_autocomplete_suggestion' === vc_request_param('action') || 'vc_edit_form' === vc_post_param('action')) {
            // Narrow data taxonomies
            add_filter('vc_autocomplete_otf_vc_blog_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1);
            add_filter('vc_autocomplete_otf_vc_blog_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1);

            if (otf_is_woocommerce_activated()) {
                add_filter('vc_autocomplete_otf_product_parallax_id_callback', array(OTF_WooCommerce::getInstance(), 'productIdAutocompleteSuggester'), 10, 1);
                add_filter('vc_autocomplete_otf_product_parallax_id_render', array(OTF_WooCommerce::getInstance(), 'productIdAutocompleteRender'), 10, 1);

                add_filter('vc_autocomplete_otf_product_category_banner_category_callback', array(OTF_WooCommerce::getInstance(), 'productCategoryAutocompleteSuggester'), 10, 1);
                add_filter('vc_autocomplete_otf_product_category_banner_category_render', array(OTF_WooCommerce::getInstance(), 'productCategoryAutocompleteRender'), 10, 1);

                add_filter('vc_autocomplete_otf_product_banner_id_callback', array(OTF_WooCommerce::getInstance(), 'productIdAutocompleteSuggester'), 10, 1);
                add_filter('vc_autocomplete_otf_product_banner_id_render', array(OTF_WooCommerce::getInstance(), 'productIdAutocompleteSuggester'), 10, 1);
            }
        }

        vc_editor_set_post_types(wp_parse_args(array('header', 'footer', 'megamenu'), vc_editor_post_types()));

        add_filter('vc_base_build_shortcodes_custom_css', array($this, 'optimze_custom_css'));
        add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array($this, 'add_classes_in_element'), 10, 3);
        add_filter('vc_shortcode_output', array($this, 'custom_output'), 10, 3);
        add_filter('vc-tta-get-params-tabs-list', array($this, 'custom_markup_tabs'), 10, 4);
        // Enable wrapper heading
        add_filter('vc_custom_heading_template_use_wrapper', '__return_true');

        add_action('vc_after_init', array($this, 'custom_css_design_notices'));
        add_action('vc_after_init', array($this, 'setup_giitem'));
        add_action('vc_after_init', array($this, 'add_field_to_row_and_column'));
        add_action('vc_after_init', array($this, 'add_field_to_column'));
        add_action('vc_after_init', array($this, 'add_field_to_video'));
        add_action('vc_after_init', array($this, 'add_field_to_tabs'));
        add_action('vc_after_init', array($this, 'add_field_to_separator_text'));
        add_action('vc_after_init', array($this, 'add_field_to_separator'));
        add_action('vc_after_init', array($this, 'add_field_to_accordion'));
        add_action('vc_after_init', array($this, 'add_field_to_custom_heading'));
        add_action('vc_after_init', array($this, 'add_field_to_wp_custommenu'));
        add_action('vc_after_init', array($this, 'add_field_to_vc_wp_posts'));
        add_action('vc_after_init', array($this, 'add_field_to_vc_btn'), 9);
        add_action('vc_after_init', array($this, 'add_field_to_vc_gitem_post_categories'), 11);

//        add_action('vc_after_init', array($this, 'add_field_to_vc_gitem_post_excerpt'), 11);

        // Override Shortcode
        add_shortcode('vc_wp_posts', array($this, 'vc_wp_posts_function'));

        // Override Grid Template
        add_filter('vc_gitem_template_attribute_vc_btn', array($this, 'gitem_template_attribute_vc_btn'), 11, 2);
        add_filter('vc_gitem_template_attribute_post_categories', array($this, 'gitem_template_attribute_post_categories'), 11, 2);
        add_filter('vc_gitem_template_attribute_post_excerpt', array($this, 'gitem_template_attribute_post_excerpt'), 11, 2);

        add_filter('do_shortcode_tag', array($this, 'custom_markup_shortcode'), 10, 4);
    }


    public function custom_css_design_notices() {
        if (vc_is_as_theme()) {
            remove_action('admin_notices', 'vc_custom_css_admin_notice');
        }
    }

    public function setup_giitem() {
        $this->giparams = include vc_path_dir('PARAMS_DIR', 'vc_grid_item/shortcodes.php');
    }

    public function gitem_template_attribute_post_excerpt($value, $data) {
        return wp_trim_words($value, get_theme_mod('otf_vc_grid_post_excerpt_number_words', 55));
    }

    public function gitem_template_attribute_post_categories($value, $data) {
        parse_str(urldecode($data['data']), $attrs);

        if (!empty($attrs['atts']['category_alignment'])) {
            $value = preg_replace('/vc_grid-filter-(center|left|right)/', 'vc_grid-filter-' . $attrs['atts']['category_alignment'], $value);
        }
        return $value;
    }

    public function gitem_template_attribute_vc_btn($value, $data) {
        /**
         * @var Wp_Post $post
         * @var string  $data
         */
        extract(array_merge(array(
            'post' => null,
            'data' => '',
        ), $data));

        return require trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/vendors/visual-composer/grid/vc_btn.php';
    }

    public function add_field_to_vc_btn() {
        $vc_config_path = vc_path_dir('CONFIG_DIR');
        $params         = include $vc_config_path . '/buttons/shortcode-vc-btn.php';
        $params         = $params['params'];

        foreach ($params as $key => $param) {
            if ($param['param_name'] === 'shape') {
                $params[$key]['dependency'] = array(
                    'element'            => 'style',
                    'value_not_equal_to' => array(
                        'link',
                    ),
                );
            }

            if ($param['param_name'] === 'style') {
                $params[$key]['value']['Primary']           = 'button-primary';
                $params[$key]['value']['Primary Outline']   = 'button-outline-primary';
                $params[$key]['value']['Secondary']         = 'button-secondary';
                $params[$key]['value']['Secondary Outline'] = 'button-outline-secondary';
                $params[$key]['value']['Link']              = 'link';
                continue;
            }

            if ($param['param_name'] === 'color') {
                $params[$key]['dependency']['value_not_equal_to'][] = 'button-primary';
                $params[$key]['dependency']['value_not_equal_to'][] = 'button-secondary';
                $params[$key]['dependency']['value_not_equal_to'][] = 'button-outline-primary';
                $params[$key]['dependency']['value_not_equal_to'][] = 'button-outline-secondary';
                $params[$key]['dependency']['value_not_equal_to'][] = 'link';
                continue;
            }
        }

        vc_add_params('vc_btn', $params);
    }

    public function vc_wp_posts_function($atts = array(), $content = '') {

        $title  = $number = $show_date = $el_class = $el_id = '';
        $output = '';
        $atts   = vc_map_get_attributes('vc_wp_posts', $atts);
        extract($atts);

//        $el_class = $this->getExtraClass( $el_class );
        $wrapper_attributes = array();
        if (!empty($el_id)) {
            $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
        }
        $output = '<div ' . implode(' ', $wrapper_attributes) . ' class="vc_wp_posts wpb_content_element' . esc_attr($el_class) . '">';
        $type   = 'OTF_Recent_Posts_Widget';
        $args   = array();
        global $wp_widget_factory;
        if (is_object($wp_widget_factory) && isset($wp_widget_factory->widgets, $wp_widget_factory->widgets[$type])) {
            ob_start();
            the_widget($type, $atts, $args);
            $output .= ob_get_clean();
        }
        $output .= '</div>';

        return $output;

    }

    public function add_field_to_vc_wp_posts() {
        $args = array(
            array(
                'type'        => 'checkbox',
                'heading'     => __('Display post image?', 'opal-theme-framework'),
                'param_name'  => 'show_image',
                'value'       => array(__('Yes', 'opal-theme-framework') => true),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'description' => __('If checked, image will be displayed.', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__('Image size', 'opal-theme-framework'),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'param_name'  => 'image_size',
                'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
                'dependency'  => array(
                    'element' => 'show_image',
                    'value'   => array('1'),
                )
            ),
        );

        vc_add_params('vc_wp_posts', $args);

    }

    public function add_field_to_vc_gitem_post_excerpt() {
        $params = array(
            array(
                'type'       => 'textfield',
                'heading'    => __('Number Words', 'opal-theme-framework'),
                'param_name' => 'number_words',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
            )
        );
        vc_add_params('vc_gitem_post_excerpt', $params);
    }

    public function add_field_to_vc_gitem_post_categories() {
        $params = $this->giparams['vc_gitem_post_categories']['params'];
        foreach ($params as $key => $param) {
            if ($param['param_name'] === 'category_color') {
                $params[$key]['value']['Primary']   = 'primary';
                $params[$key]['value']['secondary'] = 'secondary';
                continue;
            }
            if ($param['param_name'] === 'category_style') {
                $params[$key]['value'][__('Opal Extra Square', 'opal-theme-framework')] = 'filled vc_grid-filter-filled-square-all';
                continue;
            }
        }

        $params[] = array(
            'type'       => 'dropdown',
            'heading'    => __('Alignment', 'opal-theme-framework'),
            'param_name' => 'category_alignment',
            'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
            'value'      => array(
                __('Left', 'opal-theme-framework')   => 'left',
                __('Right', 'opal-theme-framework')  => 'right',
                __('Center', 'opal-theme-framework') => 'center',
            ),
            'std'        => 'center',
        );

        vc_add_params('vc_gitem_post_categories', $params);
    }

    public function add_field_to_wp_custommenu() {
        $args = array(
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Style', 'opal-theme-framework'),
                'param_name' => 'opal_custommenu_style',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    esc_html__('List', 'opal-theme-framework')   => 'list',
                    esc_html__('Inline', 'opal-theme-framework') => 'inline',
                ),
                'std'        => 'list'
            ),
            array(
                'type'        => 'textfield',
                'heading'     => __('Column list', 'opal-theme-framework'),
                'param_name'  => 'opal_custommenu_columns',
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'std'         => 1,
                'save_always' => true,
                'dependency'  => array(
                    'element' => 'opal_custommenu_style',
                    'value'   => array(
                        'list',
                    ),
                ),
            ),
        );
        vc_add_params('vc_wp_custommenu', $args);
    }

    public function add_field_to_custom_heading() {
        $args = array(
            array(
                'type'        => 'checkbox',
                'heading'     => __('Enable Underline Wrap', 'opal-theme-framework'),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'param_name'  => 'enable_underline_wrap',
                'value'       => array(__('Yes', 'opal-theme-framework') => 'yes'),
                'save_always' => true,
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Underline Title', 'opal-theme-framework'),
                'param_name' => 'underline_title',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    esc_html__('None', 'opal-theme-framework')            => 'none',
                    esc_html__('Primary Color', 'opal-theme-framework')   => 'primary',
                    esc_html__('Secondary Color', 'opal-theme-framework') => 'secondary',
                ),
                'std'        => 'none'
            ),
            // icon 
            array(
                'type'        => 'dropdown',
                'heading'     => __('Icon library', 'opal-theme-framework'),
                'value'       => array(
                    __('None', 'opal-theme-framework')         => '',
                    __('Font Awesome', 'opal-theme-framework') => 'fontawesome',
                    __('Open Iconic', 'opal-theme-framework')  => 'openiconic',
                    __('Typicons', 'opal-theme-framework')     => 'typicons',
                    __('Entypo', 'opal-theme-framework')       => 'entypo',
                    __('Linecons', 'opal-theme-framework')     => 'linecons',
                    __('Mono Social', 'opal-theme-framework')  => 'monosocial',
                    __('Material', 'opal-theme-framework')     => 'material',
                    __('Custom Image', 'opal-theme-framework') => 'custom',
                ),
                'admin_label' => true,
                'param_name'  => 'type',
                'description' => __('Select icon library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
                'std'         => ''
            ),
            array(
                'type'        => 'iconpicker',
                'heading'     => __('Icon', 'opal-theme-framework'),
                'param_name'  => 'icon_fontawesome',
                'value'       => 'fa fa-adjust',
                // default value to backend editor admin_label
                'settings'    => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'fontawesome',
                ),
                'description' => __('Select icon from library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'iconpicker',
                'heading'     => __('Icon', 'opal-theme-framework'),
                'param_name'  => 'icon_openiconic',
                'value'       => 'vc-oi vc-oi-dial',
                // default value to backend editor admin_label
                'settings'    => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'type'         => 'openiconic',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'openiconic',
                ),
                'description' => __('Select icon from library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'iconpicker',
                'heading'     => __('Icon', 'opal-theme-framework'),
                'param_name'  => 'icon_typicons',
                'value'       => 'typcn typcn-adjust-brightness',
                // default value to backend editor admin_label
                'settings'    => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'type'         => 'typicons',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'typicons',
                ),
                'description' => __('Select icon from library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'       => 'iconpicker',
                'heading'    => __('Icon', 'opal-theme-framework'),
                'param_name' => 'icon_entypo',
                'value'      => 'entypo-icon entypo-icon-note',
                // default value to backend editor admin_label
                'settings'   => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'type'         => 'entypo',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value'   => 'entypo',
                ),
                'group'      => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'iconpicker',
                'heading'     => __('Icon', 'opal-theme-framework'),
                'param_name'  => 'icon_linecons',
                'value'       => 'vc_li vc_li-heart',
                // default value to backend editor admin_label
                'settings'    => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'type'         => 'linecons',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'linecons',
                ),
                'description' => __('Select icon from library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'iconpicker',
                'heading'     => __('Icon', 'opal-theme-framework'),
                'param_name'  => 'icon_monosocial',
                'value'       => 'vc-mono vc-mono-fivehundredpx',
                // default value to backend editor admin_label
                'settings'    => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'type'         => 'monosocial',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'monosocial',
                ),
                'description' => __('Select icon from library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'iconpicker',
                'heading'     => __('Opal Extras', 'opal-theme-framework'),
                'param_name'  => 'icon_material',
                'value'       => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings'    => array(
                    'emptyIcon'    => false,
                    // default true, display an 'EMPTY' icon?
                    'type'         => 'material',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'material',
                ),
                'description' => __('Select icon from library.', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => esc_html__('Icon Color', 'opal-theme-framework'),
                'param_name'  => 'i_color',
                'description' => esc_html__('Select font color', 'opal-theme-framework'),
                'group'       => __('Opal Extras', 'opal-theme-framework'),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => array('material', 'monosocial', 'linecons', 'entypo', 'typicons', 'openiconic', 'fontawesome'),
                ),
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__('Image source', 'opal-theme-framework'),
                'param_name'  => 'select_image_source',
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'description' => esc_html__('Select Image source', 'opal-theme-framework'),
                'value'       => array(
                    esc_html__('Media Library', 'opal-theme-framework') => 'library',
                    esc_html__('External link', 'opal-theme-framework') => 'external',
                ),
                'std'         => 'library',
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'custom',
                ),
            ),
            array(
                'type'       => 'attach_image',
                'heading'    => esc_html__('Photo', 'opal-theme-framework'),
                'param_name' => 'photo',
                'value'      => '',
                'group'      => __('Opal Extras', 'opal-theme-framework'),
                'dependency' => array(
                    'element' => 'select_image_source',
                    'value'   => 'library',
                ),
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __('External link', 'opal-theme-framework'),
                'param_name' => 'external_link_photo',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'dependency' => array(
                    'element' => 'select_image_source',
                    'value'   => 'external'
                ),
            ),
        );
        vc_add_params('vc_custom_heading', $args);
    }

    public function custom_markup_shortcode($output, $tag, $attr, $m) {
        if ($tag === 'vc_custom_heading') {
            $output = $this->custom_markup_custom_heading($output, $attr);
        }
        if ($tag === 'vc_text_separator') {
            $output = $this->custom_markup_separator_text($output, $attr);
        }
        if ($tag === 'vc_separator') {
            $output = $this->custom_markup_separator($output, $attr);
        }
        return $output;
    }

    private function custom_markup_custom_heading($output, $attr) {
        extract($attr);
        if (empty($attr['type'])) {
            $html_icon = '';
        } elseif ($attr['type'] === 'custom') {
            if(empty($attr['select_image_source'])){
                $attr['select_image_source'] = 'library';
            }
            if($attr['select_image_source'] === 'external') {
                if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $external_link_photo ) ) {
                    $external_link_photo = 'http://' . $external_link_photo;
                }
                $html_icon = '<img src="' . esc_attr($external_link_photo) . '" alt="">';
            }else {
                if(!empty($attr['photo'])) {
                    $img_icon = wp_get_attachment_url($attr['photo']);
                    $html_icon = '<img src="' . esc_url_raw($img_icon) . '" alt="">';
                }
            }
        } elseif ($attr['type'] != '' && $attr['type'] != 'custom') {
            if (function_exists('vc_icon_element_fonts_enqueue')) {
                vc_icon_element_fonts_enqueue($attr['type']);
                $iconClass = isset(${'icon_' . $type}) ? esc_attr(${'icon_' . $type}) : 'fa fa-adjust';
                $html_icon = '<i class="' . esc_attr($iconClass) . '"></i>';
                if ($i_color) {
                    $html_icon = '<i style="color:' . $i_color . '" class="' . esc_attr($iconClass) . '"></i>';
                }
            }
        }
        $output = preg_replace('/(<div[^>]*>[\s\S]*<.[^>]*>)([\s\S]*)(<\/.[^>]+><\/div>)/', '$1' . $html_icon . '$2$3', $output);

        return $output;
    }

    public function custom_markup_tabs($html, $atts, $content, $obj) {
        $custom = array();
        foreach ($html as $key => $value) {
            $custom[] = $value;
            if (!empty($atts['tabs_heading']) && $key == 0) {
                $heading_classes = '';
                if (!empty($atts['enable_underline_wrap'])) {
                    $heading_classes .= ' underline-wrap';
                }
                if (!empty($atts['underline_title'])) {
                    $heading_classes .= ' underline-title-' . esc_attr($atts['underline_title']);
                }
                $custom[] = '<div class="otf_custom_tabs"><div class="vc_custom_heading' . esc_attr($heading_classes) . '"><h2>' . esc_html($atts["tabs_heading"]) . '</h2></div>';
            }
        }
        if (!empty($atts['tabs_heading'])) {
            $custom[] = '</div>';
        }
        return $custom;
    }

    /**
     * @return array
     */
    private function custom_markup_separator_text($output, $attr) {
        extract($attr);
        $html_icon = '';

        if ($photo != '') {
            $img_size  = otf_get_image_size($image_size);
            $img_icon  = wpb_resize($photo, null, $img_size[0], $img_size[1], true);
            $html_icon = '<img src="' . esc_url_raw($img_icon['url']) . '" width="' . esc_attr($img_icon['width']) . '" height="' . esc_attr($img_icon['height']) . '" alt="">';
        }
        $output = preg_replace('/(vc_sep_line\"\>\<\/span\>\<\/span\>)/', '$1' . $html_icon, $output, 1);
        return $output;
    }

    /**
     * @param $output
     * @param $attr
     *
     * @return array
     */
    private function custom_markup_separator($output, $attr) {
        $html = '';
        if (is_array($attr)) {
            extract($attr);
        }
        if (!empty($c_width)) {
            $matches = preg_replace('/[^0-9]/', '', $c_width);
            $html    = 'style="width:' . $matches . 'px;" ';
        }
        $output = preg_replace('/(\<div\s)/', '$1' . $html, $output, 1);
        return $output;
    }

    /**
     * @param $classes   string
     * @param $shortcode string
     * @param $atts      array
     *
     * @return string
     */
    public function add_classes_in_element($classes, $shortcode, $atts) {
        if ($shortcode === 'vc_row'
            || $shortcode === 'vc_row_inner'
            || $shortcode === 'vc_section'
            || $shortcode === 'vc_column'
            || $shortcode === 'vc_column_inner'
            || $shortcode === 'vc_column_text'
        ) {
            if (isset($atts['colors_schema']) && $atts['colors_schema'] === 'light') {
                $classes .= ' colors-scheme-light';
            }

            if (!empty($atts['bg_position'])) {
                $classes .= ' opal-bg-' . $atts['bg_position'];
            }
        } elseif ($shortcode === 'vc_custom_heading') {
            if (!empty($atts['enable_underline_wrap'])) {
                $classes .= ' underline-wrap';
            }
            if (!empty($atts['underline_title'])) {
                $classes .= ' underline-title-' . esc_attr($atts['underline_title']);
            }
            if (!empty($atts['font_container'])) {
                $font_container_obj = new Vc_Font_Container();
                $fontSettings       = $font_container_obj->_vc_font_container_parse_attributes(array(), $atts['font_container']);
                if (isset($fontSettings['values']) && !empty($fontSettings['values']['text_align'])) {
                    $classes .= ' text-' . esc_attr($fontSettings['values']['text_align']);
                }
            }
        } elseif ($shortcode === 'vc_btn') {
            if (in_array($atts['style'], array(
                'button-primary',
                'button-outline-primary',
                'button-secondary',
                'button-outline-secondary',
            ))) {
                $classes = str_replace('vc_general', $atts['style'], $classes);
                $classes = str_replace('vc_btn3-color-' . $atts['color'], '', $classes);
            } elseif ($atts['style'] === 'link') {
                $classes = preg_replace('/(vc_general|(vc_btn3-shape-[^ ]+)|(vc_btn3-color-[^ ]+))/', '', $classes);
            }
        }
        if ($shortcode === 'vc_column' || $shortcode === 'vc_column_inner') {
            if (!empty($atts['column_display'])) {
                $classes .= ' ' . $atts['column_display'];
            }
            if (!empty($atts['column_alignment'])) {
                $classes .= ' ' . $atts['column_alignment'];
            }
            if (!empty($atts['column_overflow'])) {
                $classes .= ' overflow-' . $atts['column_overflow'];
            }
        }
        return $classes;
    }


    public function custom_output($output, $obj, $attr) {
        if (!empty($attr['image_poster_switch'])) {
            if(empty($attr['select_image_source'])){
                $attr['select_image_source'] = 'library';
            }
            if ($attr['select_image_source'] != 'external'){
                $image_id   = $attr['poster_image'];
                $image_size = 'full';
                if (isset($attr['img_size'])) {
                    $image_size = $attr['img_size'];
                }
                $thumb_size = otf_get_image_size($image_size);
                $thumbnail  = wpb_resize($image_id, null, $thumb_size[0], $thumb_size[1], true);
                $image      = $thumbnail['url'];
            }else{
                if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $attr['external_poster_image'] ) ) {
                    $attr['external_poster_image'] = 'http://' . $attr['external_poster_image'];
                }
                $image = $attr['external_poster_image'];
            }

            $output     = preg_replace_callback('/wpb_video_wrapper.*?>/',
                function ($matches) use ($image) {
                    return strtolower($matches[0] . '<div class="otf-video-poster-wrapper"><div class="otf-video-poster" style="background-image:url(' . esc_url($image) . ')";></div><div class="button-play"></div></div>');
                }, $output);
        }
        if (!empty($attr['opal_custommenu_columns'])) {
            $output = str_replace('<ul', '<ul style="columns:' . $attr['opal_custommenu_columns'] . ';"', $output);
        } elseif (!empty($attr['opal_custommenu_style'])) {
            $output = '<div class="opal-custom-menu-' . esc_attr($attr['opal_custommenu_style']) . '">' . $output . '</div>';
        }
        return $output;
    }

    public function add_field_to_accordion() {
        $params = vc_get_shortcode('vc_tta_accordion')['params'];
        foreach ($params as $key => $param) {
            if ($param['param_name'] === 'style') {
                $params[$key]['value']['Opal style 1'] = 'opal-style';
                $params[$key]['value']['Opal style 2'] = 'opal-style-2';
                break;
            }
        }
        vc_add_params('vc_tta_accordion', $params);
    }

    public function add_field_to_tabs() {
        $params = vc_get_shortcode('vc_tta_tabs')['params'];
        foreach ($params as $key => $param) {
            if ($param['param_name'] === 'style') {
                $params[$key]['value']['Opal style 1'] = 'opal-style';
                $params[$key]['value']['Opal style 2'] = 'opal-style-2';
                break;
            }
        }
        $args = array(
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Heading', 'opal-theme-framework'),
                'param_name' => 'tabs_heading',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'checkbox',
                'heading'     => __('Enable Underline Wrap', 'opal-theme-framework'),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'param_name'  => 'enable_underline_wrap',
                'value'       => array(__('Yes', 'opal-theme-framework') => 'yes'),
                'save_always' => true,
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Underline Title', 'opal-theme-framework'),
                'param_name' => 'underline_title',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    esc_html__('None', 'opal-theme-framework')            => 'none',
                    esc_html__('Primary Color', 'opal-theme-framework')   => 'primary',
                    esc_html__('Secondary Color', 'opal-theme-framework') => 'secondary',
                ),
                'std'        => 'none'
            )
        );

        vc_add_params('vc_tta_tabs', $params);
        vc_add_params('vc_tta_tabs', $args);
    }

    public function add_field_to_separator_text() {
        $args = array(
            array(
                "type"        => "attach_image",
                "heading"     => esc_html__("Photo", 'opal-theme-framework'),
                "param_name"  => "photo",
                'description' => esc_html__('Select your image', 'opal-theme-framework'),
                "value"       => '',
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__('Image size', 'opal-theme-framework'),
                'param_name'  => 'image_size',
                'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                "value"       => 'full',
            ),
        );
        vc_add_params('vc_text_separator', $args);
    }

    public function add_field_to_separator() {
        $params = vc_get_shortcode('vc_separator')['params'];
        foreach ($params as $key => $param) {
            if ($param['param_name'] === 'el_width') {
                $params[$key]['value']['Opal Extras Custom'] = 'custom';
                break;
            }
        }
        $args = array(
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Element width custom', 'opal-theme-framework'),
                'param_name' => 'c_width',
                "value"      => '',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'dependency' => array(
                    'element' => 'el_width',
                    'value'   => 'custom',
                ),
            )
        );
        vc_add_params('vc_separator', $params);
        vc_add_params('vc_separator', $args);
    }


    public function add_field_to_column() {
        $args = array(
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Display', 'opal-theme-framework'),
                'param_name' => 'column_display',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    __('Default', 'opal-theme-framework') => '',
                    __('Flex', 'opal-theme-framework')    => 'column-flex',
                ),
                'std'        => ''
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Alignment', 'opal-theme-framework'),
                'param_name' => 'column_alignment',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    __('Left', 'opal-theme-framework')    => 'text-left',
                    __('Right', 'opal-theme-framework')   => 'text-right',
                    __('Center', 'opal-theme-framework')  => 'text-center',
                    __('Justify', 'opal-theme-framework') => 'text-justify',
                ),
                'std'        => 'text-left'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Overflow', 'opal-theme-framework'),
                'param_name' => 'column_overflow',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    __('initial', 'opal-theme-framework') => 'initial',
                    __('inherit', 'opal-theme-framework') => 'inherit',
                    __('visible', 'opal-theme-framework') => 'visible',
                    __('hidden', 'opal-theme-framework')  => 'hidden',
                    __('scroll', 'opal-theme-framework')  => 'scroll',
                    __('auto', 'opal-theme-framework')    => 'auto',
                ),
                'std'        => 'initial'
            ),
        );
        vc_add_params('vc_column', $args);
        vc_add_params('vc_column_inner', $args);
    }

    public function add_field_to_row_and_column() {
        $args = array(
            'colors_scheme' => array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Colors Scheme', 'opal-theme-framework'),
                'param_name' => 'colors_schema',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    __('Dark', 'opal-theme-framework')  => 'dark',
                    __('Light', 'opal-theme-framework') => 'light',
                ),
                'std'        => 'dark'
            ),
            'bg_position'   => array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Background position', 'opal-theme-framework'),
                'param_name' => 'bg_position',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(
                    esc_html__('None', 'opal-theme-framework')          => '',
                    esc_html__('Top left', 'opal-theme-framework')      => 'top-left',
                    esc_html__('Top center', 'opal-theme-framework')    => 'top-center',
                    esc_html__('Top right', 'opal-theme-framework')     => 'top-right',
                    esc_html__('Center left', 'opal-theme-framework')   => 'center-left',
                    esc_html__('Center center', 'opal-theme-framework') => 'center-center',
                    esc_html__('Center right', 'opal-theme-framework')  => 'center-right',
                    esc_html__('Bottom left', 'opal-theme-framework')   => 'bottom-left',
                    esc_html__('Bottom center', 'opal-theme-framework') => 'bottom-center',
                    esc_html__('Bottom right', 'opal-theme-framework')  => 'bottom-right',
                ),
            )
        );
        vc_add_params('vc_row', $args);
        vc_add_params('vc_row_inner', $args);
        vc_add_params('vc_section', $args);
        vc_add_params('vc_column', $args);
        vc_add_params('vc_column_inner', $args);

        unset($args['bg_position']);
        vc_add_params('vc_column_text', $args);
    }

    public function add_field_to_video() {
        vc_add_params('vc_video', array(
            array(
                'type'       => 'checkbox',
                'heading'    => esc_html__('Add poster to video', 'opal-theme-framework'),
                'param_name' => 'image_poster_switch',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'      => array(esc_html__('Yes, please', 'opal-theme-framework') => 'yes')
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__('Image source', 'opal-theme-framework'),
                'param_name'  => 'select_image_source',
                'description' => esc_html__('Select Image source', 'opal-theme-framework'),
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'value'       => array(
                    esc_html__('Media Library', 'opal-theme-framework') => 'library',
                    esc_html__('External link', 'opal-theme-framework') => 'external',
                ),
                'std'         => 'library',
                'dependency'  => array(
                    'element' => 'image_poster_switch',
                    'value'   => array('yes'),
                )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__('Image', 'opal-theme-framework'),
                'param_name'  => 'poster_image',
                'value'       => '',
                'description' => esc_html__('Select image from media library.', 'opal-theme-framework'),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'dependency' => array(
                    'element' => 'select_image_source',
                    'value'   => 'library'
                ),
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __('External link', 'opal-theme-framework'),
                'param_name' => 'external_poster_image',
                'group'      => esc_html__('Opal Extras', 'opal-theme-framework'),
                'dependency' => array(
                    'element' => 'select_image_source',
                    'value'   => 'external'
                ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__('Image size', 'opal-theme-framework'),
                'group'       => esc_html__('Opal Extras', 'opal-theme-framework'),
                'param_name'  => 'img_size',
                'description' => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'opal-theme-framework'),
                'dependency' => array(
                    'element' => 'select_image_source',
                    'value'   => 'library'
                ),
            ),

        ));
    }

    public function optimze_custom_css($css) {
        $css = preg_replace('/\?id=\d+/', '', $css);

        return $css;
    }

    public function init_shortcodes() {
        $vc_path = trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/vendors/visual-composer/';
        vc_lean_map('otf_mc4wp_form', null, $vc_path . 'settings/otf_mc4wp_form.php');
        vc_lean_map('otf_team', null, $vc_path . 'settings/otf_team.php');
        vc_lean_map('otf_team_item', null, $vc_path . 'settings/otf_team_item.php');
        vc_lean_map('otf_testimonial', null, $vc_path . 'settings/otf_testimonial.php');
        vc_lean_map('otf_testimonial_item', null, $vc_path . 'settings/otf_testimonial_item.php');
        vc_lean_map('otf_brand', null, $vc_path . 'settings/otf_brand.php');
        vc_lean_map('otf_brand_item', null, $vc_path . 'settings/otf_brand_item.php');
        vc_lean_map('otf_flex_item', null, $vc_path . 'header-builder/otf_flex_item.php');
        vc_lean_map('otf_slider', null, $vc_path . 'settings/otf_slider.php');
        vc_lean_map('otf_slider_item', null, $vc_path . 'settings/otf_slider_item.php');
        $list_shortcodes = apply_filters('otf_list_shortcodes', array());
        foreach ($list_shortcodes as $shortcode) {
            $path = get_theme_file_path('inc/vendors/vc/settings/' . $shortcode . '.php');
            if (!file_exists($path)) {
                $path = $vc_path . 'settings/' . $shortcode . '.php';
            }
            if (file_exists($path)) {
                vc_lean_map($shortcode, null, $path);
            }
        }
        if (otf_is_woocommerce_activated()) {
            $settings        = apply_filters('otf_woocommerce_custom_shortcode_settings', array());
            $list_shortcodes = array(
                'recent_products',
                'sale_products',
                'best_selling_products',
                'top_rated_products',
                'featured_products',
                'related_products',
                'product_category',
            );
            foreach ($list_shortcodes as $shortcode) {
                foreach ($settings as $setting) {
                    vc_add_param($shortcode, $setting);
                }
            }

            foreach ($settings as $setting) {
                if ($setting['param_name'] === 'show_dot'
                    || $setting['param_name'] === 'show_nav'
                    || $setting['param_name'] === 'nav_position'
                    || $setting['param_name'] === 'nav_style'
                ) {
                    continue;
                }

                if ($setting['param_name'] === 'style') {
                    unset($setting['value'][esc_html__('Carousel', 'opal-theme-framework')]);
                }
                vc_add_param('product', $setting);
            }
        }

        if (get_theme_mod('otf_layout_general_layout_mode') === 'boxed') {
//            add_filter('vc_shortcode_content_filter_after', array($this, 'remove_vc_fullwidth'), 10, 2);
        }

    }

    public function remove_vc_fullwidth($content, $shortcode) {
        if ($shortcode === 'vc_row' || $shortcode === 'vc_section' || $shortcode === 'vc_row_inner') {
            return str_replace('data-vc-full-width="true"', '', $content);
        }

        return $content;
    }

    public function add_scripts() {
        wp_enqueue_style('js_composer_front');
        wp_register_style('vc_tta_style', vc_asset_url('css/js_composer_tta.min.css'), false, WPB_VC_VERSION);
        wp_enqueue_style('vc_tta_style');
    }
}

new OTF_Visual_Composer();

vc_map_update('icon_type', array(__( 'IconWebmod', 'js_composer'   ) => 'webmod') );

add_filter( 'vc_iconpicker-type-webmod', 'vc_iconpicker_type_webmod' );
/**
 * Webmod Icon
 *
 * @param $icons
 *
 * @return array
 */
function vc_iconpicker_type_webmod( $icons ) {
    $webmod = array();
    for ($i = 1; $i<= 1331; $i++){
        $i = str_pad($i, 3, '0', STR_PAD_LEFT);
        $webmod[] = array( 'icon icon-'.$i => 'icon-'.$i );
    }
    return array_merge( $icons, $webmod );
}