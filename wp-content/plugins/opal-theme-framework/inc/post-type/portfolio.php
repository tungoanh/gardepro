<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Portfolio
 */
class OTF_Custom_Post_Type_Portfolio extends OTF_Custom_Post_Type_Abstract {
    public $post_type = 'portfolio';
    public $taxonomy = 'portfolio_category';

    static $instance;

    public static function getInstance() {
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Portfolio )){
            self::$instance = new OTF_Custom_Post_Type_Portfolio();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public function create_post_type() {

        $labels = array(
            'name'               => __('Portfolios', "opal-theme-framework"),
            'singular_name'      => __('Portfolio', "opal-theme-framework"),
            'add_new'            => __('Add New Portfolio', "opal-theme-framework"),
            'add_new_item'       => __('Add New Portfolio', "opal-theme-framework"),
            'edit_item'          => __('Edit Portfolio', "opal-theme-framework"),
            'new_item'           => __('New Portfolio', "opal-theme-framework"),
            'view_item'          => __('View Portfolio', "opal-theme-framework"),
            'search_items'       => __('Search Portfolios', "opal-theme-framework"),
            'not_found'          => __('No Portfolios found', "opal-theme-framework"),
            'not_found_in_trash' => __('No Portfolios found in Trash', "opal-theme-framework"),
            'parent_item_colon'  => __('Parent Portfolio:', "opal-theme-framework"),
            'menu_name'          => __('Portfolios', "opal-theme-framework"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => __('List Portfolio', 'opal-theme-framework'),
            'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt'), //page-attributes, post-formats
            'taxonomies'          => array($this->taxonomy),
            'post-formats'        => array('aside', 'image', 'quote'),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->get_icon(__FILE__),
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => true,
            'capability_type'     => 'post'
        );
        register_post_type($this->post_type, $args);
    }

    /**
     * @return void
     */
    public function create_taxonomy() {
        $labels = array(
            'name'              => __('Categories', "opal-theme-framework"),
            'singular_name'     => __('Category', "opal-theme-framework"),
            'search_items'      => __('Search Category', "opal-theme-framework"),
            'all_items'         => __('All Categories', "opal-theme-framework"),
            'parent_item'       => __('Parent Category', "opal-theme-framework"),
            'parent_item_colon' => __('Parent Category:', "opal-theme-framework"),
            'edit_item'         => __('Edit Category', "opal-theme-framework"),
            'update_item'       => __('Update Category', "opal-theme-framework"),
            'add_new_item'      => __('Add New Category', "opal-theme-framework"),
            'new_item_name'     => __('New Category Name', "opal-theme-framework"),
            'menu_name'         => __('Categories', "opal-theme-framework"),
        );
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_nav_menus' => false,
            'rewrite'           => array('slug' => 'category-portfolio')
        );
        // Now register the taxonomy
        register_taxonomy($this->taxonomy, array($this->post_type), $args);
    }

    /**
     * @return void
     */
    public function create_meta_box() {
        // Start with an underscore to hide fields from custom fields list
        $prefix = 'otf_';

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box(array(
            'id'           => 'otf_portfolio',
            'title'        => __('Portfolio Settings', 'opal-theme-framework'),
            'object_types' => array('portfolio'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ));

        $args = array(
            array(
                'name' => __('Author fullname', 'opal-theme-framework'),
                'id'   => $prefix . 'portfolio_fullname',
                'type' => 'text',
            ),
            array(
                'name' => __('Showcase Link', 'opal-theme-framework'),
                'id'   => $prefix . 'portfolio_showcase_link',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Client', 'opal-theme-framework'),
                'id'   => $prefix . 'portfolio_client',
                'type' => 'text',
            ),
            array(
                'name' => __('Date Created', 'opal-theme-framework'),
                'id'   => $prefix . 'portfolio_date_created',
                'type' => 'text_date',
            ),
        );

        $this->init_meta_box($cmb, $args, __FILE__);
    }

    /**
     * @param $buttons
     *
     * @return array
     */
    public function customizer_buttons($buttons) {
        $buttons = wp_parse_args($buttons, array(
            '.single-portfolio #content'       => array(
                array(
                    'id'   => 'otf_portfolio_single',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.tax-portfolio_category #content' => array(
                array(
                    'id'   => 'otf_portfolio_archive',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
        ));
        return $buttons;
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     */
    public function customize_register($wp_customize) {

        $wp_customize->add_panel('otf_portfolio', array(
            'title'      => __('Portfolio', 'opal-theme-framework'),
            'capability' => 'edit_theme_options',
            'priority'   => 1,
        ));

        //Portfolio Archive config
        $wp_customize->add_section('otf_portfolio_archive', array(
            'title'      => __('Archive', 'opal-theme-framework'),
            'capability' => 'edit_theme_options',
            'panel'      => 'otf_portfolio',
            'priority'   => 1,
        ));

        // =========================================
        // Select Layout
        // =========================================
        $wp_customize->add_setting('otf_portfolio_archive_layout', array(
            'default' => '2cr',
        ));
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_portfolio_archive_layout', array(
            'section' => 'otf_portfolio_archive',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));
        // Sidebar
        $wp_customize->add_setting('otf_portfolio_archive_sidebar', array());
        $wp_customize->add_control(new OTF_Customize_Control_Sidebars($wp_customize, 'otf_portfolio_archive_sidebar', array(
            'section' => 'otf_portfolio_archive',
            'label'   => __('Sidebar', 'opal-theme-framework'),
        )));


        //Single portfolio layout
        $wp_customize->add_section('otf_portfolio_single', array(
            'title'      => __('Single', 'opal-theme-framework'),
            'capability' => 'edit_theme_options',
            'panel'      => 'otf_portfolio',
            'priority'   => 1,
        ));

        // Select Layout
        $wp_customize->add_setting('otf_portfolio_single_layout', array(
            'default' => '2cr',
        ));
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_portfolio_single_layout', array(
            'section' => 'otf_portfolio_single',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));

        $wp_customize->add_setting('otf_portfolio_single_sidebar', array());
        $wp_customize->add_control(new OTF_Customize_Control_Sidebars($wp_customize, 'otf_portfolio_single_sidebar', array(
            'section' => 'otf_portfolio_single',
            'label'   => __('Sidebar', 'opal-theme-framework'),
        )));
    }

    /**
     * @param $classes
     *
     * @return array
     */
    public function body_class($classes) {
        if (is_post_type_archive($this->post_type) || is_tax($this->taxonomy)) {
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_portfolio_archive_layout', '2cr');
        } else if (is_singular($this->post_type)) {
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_portfolio_single_layout', '2cr');
        }
        return $classes;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function set_sidebar($name) {
        if (is_post_type_archive($this->post_type) || is_tax($this->taxonomy)) {
            $mode = get_theme_mod('otf_portfolio_archive_layout', '2cr');
            if ($mode == '1c') {
                $name = '';
            } else if ($sidebar = get_theme_mod('otf_portfolio_archive_sidebar', '')) {
                $name = $sidebar;
            }
        } else if (is_singular($this->post_type)) {
            $mode = get_theme_mod('otf_portfolio_single_sidebar', '2cr');
            if ($mode == '1c') {
                $name = '';
            } else if ($sidebar = get_theme_mod('otf_portfolio_single_sidebar', '')) {
                $name = $sidebar;
            }
        }
        return $name;
    }

    /**
     * @return array
     */
    public function add_shortcode() {
        return array(
            'otf_portfolio'
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     *  @return string
     */
    public function otf_portfolio_shortcode($atts, $content = '') {
        return $this->render_shortcode('otf_portfolio', $atts, $content);
    }

    /**
     * @param array $arg
     *
     * @return WP_Query
     */
    public function create_query($per_page = -1, $taxonomies = array()){
        $args  = array(
            'post_type' => $this->post_type,
            'posts_per_page' => $per_page,
            'post_status' => 'publish',
        );
        if(!empty($taxonomies)){
            $args ['tax_query'] = array(
                'taxonomy' => $this->taxonomy,
                'field'    => 'slug',
                'terms'    => $taxonomies
            );
        }
        return new WP_Query($args);
    }

    /**
     * @return array|int|WP_Error
     */
    public function get_terms(){
        return get_terms(array($this->taxonomy) );
    }

    /**
     * @param $id
     *
     * @return array|false|WP_Error
     */
    public function get_the_terms($id){
        return get_the_terms( $id, $this->taxonomy );
    }
}

OTF_Custom_Post_Type_Portfolio::getInstance();