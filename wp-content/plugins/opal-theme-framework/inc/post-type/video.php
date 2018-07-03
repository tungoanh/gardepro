<?php
if( !defined('ABSPATH')){
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Video
 */
class OTF_Custom_Post_Type_Video extends OTF_Custom_Post_Type_Abstract{

    public $post_type = 'video';
    public $taxonomy = 'video_category';

    static $instance;

    /**
     * @return OTF_Custom_Post_Type_Video
     */
    public static function getInstance(){
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Video)){
            self::$instance = new OTF_Custom_Post_Type_Video();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public function create_post_type(){
        $labels = array(
            'name'               => __('Video', "opal-theme-framework"),
            'singular_name'      => __('Video', "opal-theme-framework"),
            'add_new'            => __('Add New Video', "opal-theme-framework"),
            'add_new_item'       => __('Add New Video', "opal-theme-framework"),
            'edit_item'          => __('Edit Video', "opal-theme-framework"),
            'new_item'           => __('New Video', "opal-theme-framework"),
            'view_item'          => __('View Video', "opal-theme-framework"),
            'search_items'       => __('Search Videos', "opal-theme-framework"),
            'not_found'          => __('No Videos found', "opal-theme-framework"),
            'not_found_in_trash' => __('No Videos found in Trash', "opal-theme-framework"),
            'parent_item_colon'  => __('Parent Video:', "opal-theme-framework"),
            'menu_name'          => __('Videos', "opal-theme-framework"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => 'List Video',
            'supports'            => array('title', 'thumbnail', 'excerpt'),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->get_icon(__FILE__),
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => true,
            'capability_type'     => 'post'
        );
        register_post_type( $this->post_type, $args );
    }

    /**
     * @return void
     */
    public function create_taxonomy(){
        $labels = array(
            'name'              => __( 'Categories Video', "opal-theme-framework" ),
            'singular_name'     => __( 'Category', "opal-theme-framework" ),
            'search_items'      => __( 'Search Category', "opal-theme-framework" ),
            'all_items'         => __( 'All Categories', "opal-theme-framework" ),
            'parent_item'       => __( 'Parent Category', "opal-theme-framework" ),
            'parent_item_colon' => __( 'Parent Category:', "opal-theme-framework" ),
            'edit_item'         => __( 'Edit Category', "opal-theme-framework" ),
            'update_item'       => __( 'Update Category', "opal-theme-framework" ),
            'add_new_item'      => __( 'Add New Category', "opal-theme-framework" ),
            'new_item_name'     => __( 'New Category Name', "opal-theme-framework" ),
            'menu_name'         => __( 'Categories Video', "opal-theme-framework" ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'video'),
        );
        // Now register the taxonomy
        register_taxonomy($this->taxonomy,array($this->post_type),$args);

    }

    public function create_meta_box(){
        // Start with an underscore to hide fields from custom fields list
        $prefix = 'otf_';

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box( array(
            'id'            => 'otf_video',
            'title'         => __( 'Video Settings', 'opal-theme-framework' ),
            'object_types'  => array( 'video' ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $args = array(
            array(
                'name' => __('Link Video', 'opal-theme-framework'),
                'id'   => $prefix . 'video_link',
                'type' => 'oembed',
                'desc' => __('Add link video, support youtube and vimeo', 'opal-theme-framework'),
            )
        );

        $this->init_meta_box($cmb, $args, __FILE__);
    }

    public function customizer_buttons($buttons) {
        $buttons = wp_parse_args( $buttons, array(
            '.single-'.$this->post_type.' #content'       => array(
                array(
                    'id'   => 'otf_video_single',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.tax-'.$this->taxonomy.' #content' => array(
                array(
                    'id'   => 'otf_video_archive',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
        ) );
        return $buttons;
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     */
    public function customize_register($wp_customize)
    {
        $wp_customize->add_panel( 'otf_video', array(
            'title'          => __( 'Video', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        //Portfolio Archive config
        $wp_customize->add_section( 'otf_video_archive', array(
            'title'          => __( 'Archive', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_video',
            'priority'       => 1,
        ) );

        // =========================================
        // Select Layout
        // =========================================
        $wp_customize->add_setting( 'otf_video_archive_layout', array(
            'default'           => '2cr',
        ) );
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_video_archive_layout', array(
            'section' => 'otf_video_archive',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));
        // Sidebar
        $wp_customize->add_setting( 'otf_video_archive_sidebar', array(
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_video_archive_sidebar', array(
            'section' => 'otf_video_archive',
            'label' => __( 'Sidebar', 'opal-theme-framework' ),
        ) ) );


        //Single portfolio layout
        $wp_customize->add_section( 'otf_video_single', array(
            'title'          => __( 'Single', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_video',
            'priority'       => 1,
        ) );

        // Select Layout
        $wp_customize->add_setting( 'otf_video_single_layout', array(
            'default'           => '2cr',
        ) );
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_video_single_layout', array(
            'section' => 'otf_video_single',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));

        $wp_customize->add_setting( 'otf_video_single_sidebar', array(
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_video_single_sidebar', array(
            'section' => 'otf_video_single',
            'label' => __( 'Sidebar', 'opal-theme-framework' ),
        ) ) );
    }

    /**
     * @param $classes
     *
     * @return array
     */
    public function body_class($classes) {
        if (is_post_type_archive($this->post_type) || is_tax($this->taxonomy)) {
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_video_archive_layout', '2cr');
        } else if (is_singular($this->post_type)) {
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_video_single_layout', '2cr');
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
            $mode = get_theme_mod('otf_video_archive_layout', '2cr');
            if($mode == '1c'){
                $name = '';
            }else if($sidebar = get_theme_mod('otf_video_archive_sidebar', '')){
                $name = $sidebar;
            }
        } else if (is_singular($this->post_type)) {
            $mode = get_theme_mod('otf_video_single_sidebar', '2cr');
            if($mode == '1c'){
                $name = '';
            }else if($sidebar = get_theme_mod('otf_video_single_sidebar', '')){
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
            'otf_video'
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     *  @return string
     */
    public function otf_video_shortcode($atts, $content = '') {
        return $this->render_shortcode('otf_video', $atts, $content);
    }

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
OTF_Custom_Post_Type_Video::getInstance();