<?php
if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Teacher
 */
class OTF_Custom_Post_Type_Teacher extends OTF_Custom_Post_Type_Abstract {

    public $post_type = 'teacher';
    public $taxonomy = 'teacher_category';

    static $instance;

    /**
     * @return OTF_Custom_Post_Type_Teacher
     */
    public static function getInstance(){
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Teacher)){
            self::$instance = new OTF_Custom_Post_Type_Teacher();
        }

        return self::$instance;
    }
    /**
     * @return void
     */
    public function create_post_type(){
        $labels = array(
            'name'               => __('Teacher', "opal-theme-framework"),
            'singular_name'      => __('Teacher', "opal-theme-framework"),
            'add_new'            => __('Add New Teacher', "opal-theme-framework"),
            'add_new_item'       => __('Add New Teacher', "opal-theme-framework"),
            'edit_item'          => __('Edit Teacher', "opal-theme-framework"),
            'new_item'           => __('New Teacher', "opal-theme-framework"),
            'view_item'          => __('View Teacher', "opal-theme-framework"),
            'search_items'       => __('Search Teachers', "opal-theme-framework"),
            'not_found'          => __('No Teachers found', "opal-theme-framework"),
            'not_found_in_trash' => __('No Teachers found in Trash', "opal-theme-framework"),
            'parent_item_colon'  => __('Parent Teacher:', "opal-theme-framework"),
            'menu_name'          => __('Teachers', "opal-theme-framework"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => __('List Teacher', 'opal-theme-framework'),
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'), //page-attributes, post-formats
            'taxonomies'          => array($this->taxonomy),
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
        register_post_type($this->post_type, $args);
    }

    public function create_taxonomy(){
        $labels = array(
            'name'              => __( 'Teacher Categories', "opal-theme-framework" ),
            'singular_name'     => __( 'Category', "opal-theme-framework" ),
            'search_items'      => __( 'Search Category', "opal-theme-framework" ),
            'all_items'         => __( 'All Categories', "opal-theme-framework" ),
            'parent_item'       => __( 'Parent Category', "opal-theme-framework" ),
            'parent_item_colon' => __( 'Parent Category:', "opal-theme-framework" ),
            'edit_item'         => __( 'Edit Category', "opal-theme-framework" ),
            'update_item'       => __( 'Update Category', "opal-theme-framework" ),
            'add_new_item'      => __( 'Add New Category', "opal-theme-framework" ),
            'new_item_name'     => __( 'New Category Name', "opal-theme-framework" ),
            'menu_name'         => __( 'Categories', "opal-theme-framework" ),
        );
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_nav_menus' => true,
            'rewrite'           => array( 'slug' => 'teacher-category'),
        );
        // Now register the taxonomy
        register_taxonomy($this->taxonomy, array($this->post_type),$args);

    }

    public function create_meta_box(){
        // Start with an underscore to hide fields from custom fields list
        $prefix = 'otf_';

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box( array(
            'id'            => 'otf_teacher',
            'title'         => __( 'Teacher Settings', 'opal-theme-framework' ),
            'object_types'  => array( $this->post_type ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $args = array(
            array(
                'name' => __('Email','opal-theme-framework'),
                'desc' => __('Enter email, Ex: info@wpopal.com','opal-theme-framework'),
                'id'   => $prefix . 'teacher_email',
                'type' => 'text_email',
            ),
            array(
                'name' => __('Phone number','opal-theme-framework'),
                'desc' => __('Enter phone number, Ex: +84 123 456 789','opal-theme-framework'),
                'id'   => $prefix . 'teacher_phone_number',
                'type' => 'text_medium',
            ),
            array(
                'name' => __('Address','opal-theme-framework'),
                'desc' => '',
                'id'   => $prefix . 'teacher_address',
                'type' => 'textarea_small',
            ),

            array(
                'name' => __('Website','opal-theme-framework'),
                'desc' => __('Enter website, Ex: wpopal.com','opal-theme-framework'),
                'id'   => $prefix . 'teacher_website',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Google Plus link','opal-theme-framework'),
                'desc' => __('Enter google plus link, Ex: https://plus.google.com/+WPOpal','opal-theme-framework'),
                'id'   => $prefix . 'teacher_google_plus',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Facebook link','opal-theme-framework'),
                'desc' => __('Enter Facebook link, Ex: https://www.facebook.com/opalwordpress/','opal-theme-framework'),
                'id'   => $prefix . 'teacher_facebook',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Twitter Link','opal-theme-framework'),
                'desc' => __('Enter Twitter link, Ex: https://twitter.com/opalwordpress','opal-theme-framework'),
                'id'   => $prefix . 'teacher_twitter',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Pinterest Link','opal-theme-framework'),
                'desc' => __('Enter Pinterest link, Ex: https://www.pinterest.com/wpopal/','opal-theme-framework'),
                'id'   => $prefix . 'teacher_twitter',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Instagram Link','opal-theme-framework'),
                'desc' => __('Enter Instagram link, Ex: https://www.instagram.com/opalwordpress/','opal-theme-framework'),
                'id'   => $prefix . 'teacher_twitter',
                'type' => 'text_url',
            ),

        );
        $this->init_meta_box($cmb, $args, __FILE__);

        $group_field_id = $cmb->add_field( array(
            'name'        => __('Skin Information', 'opal-theme-framework'),
            'id'          => $prefix . 'teacher_skin_group',
            'type'        => 'group',
            'description' => __('Generates reusable form entries', 'opal-theme-framework'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __( 'Skin {#}', 'opal-theme-framework' ), // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __( 'Add Skin', 'opal-theme-framework' ),
                'remove_button' => __( 'Remove Skin', 'opal-theme-framework' ),
                'sortable'      => true, // beta
                // 'closed'     => true, // true to have the groups closed by default
            ),
        ) );
        $cmb->add_group_field( $group_field_id, array(
            'name' => __('Label','opal-theme-framework'),
            'id'   => $prefix . 'teacher_label',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );

        $cmb->add_group_field( $group_field_id, array(
            'name' => __('Volume','opal-theme-framework'),
            'description' => '',
            'id'   => $prefix . 'teacher_volume',
            'type' => 'text_small',
        ) );
    }

    public function customizer_buttons($buttons) {
        $buttons = wp_parse_args( $buttons, array(
            '.single-'.$this->post_type .' #content'       => array(
                array(
                    'id'   => 'otf_teacher_single',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.tax-'.$this->taxonomy.' #content' => array(
                array(
                    'id'   => 'otf_teacher_archive',
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
        $wp_customize->add_panel( 'otf_teacher', array(
            'title'          => __( 'Teacher', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        //Portfolio Archive config
        $wp_customize->add_section( 'otf_teacher_archive', array(
            'title'          => __( 'Archive', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_teacher',
            'priority'       => 1,
        ) );

        // =========================================
        // Select Layout
        // =========================================
        $wp_customize->add_setting( 'otf_teacher_archive_layout', array(
            'default'           => '2cr',
        ) );
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_teacher_archive_layout', array(
            'section' => 'otf_teacher_archive',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));
        // Sidebar
        $wp_customize->add_setting( 'otf_teacher_archive_sidebar', array(
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_teacher_archive_sidebar', array(
            'section' => 'otf_teacher_archive',
            'label' => __( 'Sidebar', 'opal-theme-framework' ),
        ) ) );


        //Single portfolio layout
        $wp_customize->add_section( 'otf_teacher_single', array(
            'title'          => __( 'Single', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_teacher',
            'priority'       => 1,
        ) );

        // Select Layout
        $wp_customize->add_setting( 'otf_teacher_single_layout', array(
            'default'           => '2cr',
        ) );
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_teacher_single_layout', array(
            'section' => 'otf_teacher_single',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));

        $wp_customize->add_setting( 'otf_teacher_single_sidebar', array(
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_teacher_single_sidebar', array(
            'section' => 'otf_teacher_single',
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
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_teacher_archive_layout', '2cr');
        } else if (is_singular($this->post_type)) {
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_teacher_single_layout', '2cr');
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
            $mode = get_theme_mod('otf_teacher_archive_layout', '2cr');
            if($mode == '1c'){
                $name = '';
            }else if($sidebar = get_theme_mod('otf_teacher_archive_sidebar', '')){
                $name = $sidebar;
            }
        } else if (is_singular($this->post_type)) {
            $mode = get_theme_mod('otf_teacher_single_sidebar', '2cr');
            if($mode == '1c'){
                $name = '';
            }else if($sidebar = get_theme_mod('otf_teacher_single_sidebar', '')){
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
            'otf_teacher'
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     *  @return string
     */
    public function otf_teacher_shortcode($atts, $content = '') {
        return $this->render_shortcode('otf_teacher', $atts, $content);
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
OTF_Custom_Post_Type_Teacher::getInstance();