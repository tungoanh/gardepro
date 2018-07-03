<?php
if( !defined('ABSPATH')){
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Team
 */
class OTF_Custom_Post_Type_Team extends OTF_Custom_Post_Type_Abstract {

    public $post_type = 'team';
    public $taxonomy = 'team_category';

    static $instance;

    /**
     * @return OTF_Custom_Post_Type_Team
     */
    public static function getInstance(){
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Team)){
            self::$instance = new OTF_Custom_Post_Type_Team();
        }

        return self::$instance;
    }
    /**
     * @return void
     */
    public function create_post_type(){
        $labels = array(
            'name'               => __('Team', "opal-theme-framework"),
            'singular_name'      => __('Team', "opal-theme-framework"),
            'add_new'            => __('Add New Team', "opal-theme-framework"),
            'add_new_item'       => __('Add New Team', "opal-theme-framework"),
            'edit_item'          => __('Edit Team', "opal-theme-framework"),
            'new_item'           => __('New Team', "opal-theme-framework"),
            'view_item'          => __('View Team', "opal-theme-framework"),
            'search_items'       => __('Search Teams', "opal-theme-framework"),
            'not_found'          => __('No Teams found', "opal-theme-framework"),
            'not_found_in_trash' => __('No Teams found in Trash', "opal-theme-framework"),
            'parent_item_colon'  => __('Parent Team:', "opal-theme-framework"),
            'menu_name'          => __('Teams', "opal-theme-framework"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => __('List Team', 'opal-theme-framework'),
            'supports'            => array('title', 'editor', 'thumbnail'),
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

    /**
     * @return void
     */
    public function create_taxonomy(){
        $labels = array(
            'name'              => __( 'Team Categories', "opal-theme-framework" ),
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
            'rewrite'           => array('slug' => 'team-category')
        );
        // Now register the taxonomy
        register_taxonomy($this->taxonomy, array($this->post_type), $args);
    }

    public function create_meta_box(){
        // Start with an underscore to hide fields from custom fields list
        $prefix = 'otf_';

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box( array(
            'id'            => 'otf_team',
            'title'         => __( 'Team Settings', 'opal-theme-framework' ),
            'object_types'  => array( $this->post_type ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $args = array(
            array(
                'name' => __('Job','opal-theme-framework'),
                'desc' => __('Enter job, ex: Developer, Design...','opal-theme-framework'),
                'id'   => $prefix . 'team_job',
                'type' => 'text',
            ),
            array(
                'name' => __('Address','opal-theme-framework'),
                'desc' => '',
                'id'   => $prefix . 'team_address',
                'type' => 'textarea_small',
            ),
            array(
                'name' => __('Phone number','opal-theme-framework'),
                'desc' => __('Enter phone number, Ex: +84 123 456 789','opal-theme-framework'),
                'id'   => $prefix . 'team_phone_number',
                'type' => 'text_medium',
            ),

            array(
                'name' => __('Email','opal-theme-framework'),
                'desc' => __('Enter email, Ex: info@wpopal.com','opal-theme-framework'),
                'id'   => $prefix . 'team_email',
                'type' => 'text_email',
            ),
            array(
                'name' => __('Website','opal-theme-framework'),
                'desc' => __('Enter website, Ex: wpopal.com','opal-theme-framework'),
                'id'   => $prefix . 'team_website',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Google Plus link','opal-theme-framework'),
                'desc' => __('Enter google plus link, Ex: https://plus.google.com/+WPOpal','opal-theme-framework'),
                'id'   => $prefix . 'team_google_plus',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Facebook link','opal-theme-framework'),
                'desc' => __('Enter Facebook link, Ex: https://www.facebook.com/opalwordpress/','opal-theme-framework'),
                'id'   => $prefix . 'team_facebook',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Twitter Link','opal-theme-framework'),
                'desc' => __('Enter Twitter link, Ex: https://twitter.com/opalwordpress','opal-theme-framework'),
                'id'   => $prefix . 'team_twitter',
                'type' => 'text_url',
            ),
            array(
                'name' => __('Pinterest Link','opal-theme-framework'),
                'desc' => __('Enter Pinterest link, Ex: https://www.pinterest.com/wpopal/','opal-theme-framework'),
                'id'   => $prefix . 'team_pinterest',
                'type' => 'text_url',
            ),

        );
        $this->init_meta_box($cmb, $args, __FILE__);
    }

    public function customizer_buttons($buttons) {
        $buttons = wp_parse_args( $buttons, array(
            '.single-'.$this->post_type.' #content'       => array(
                array(
                    'id'   => 'otf_team_single',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.tax-t'.$this->taxonomy.' #content' => array(
                array(
                    'id'   => 'otf_team_archive',
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
        $wp_customize->add_panel( 'otf_team', array(
            'title'          => __( 'Team', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        //Portfolio Archive config
        $wp_customize->add_section( 'otf_team_archive', array(
            'title'          => __( 'Archive', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_team',
            'priority'       => 1,
        ) );

        // =========================================
        // Select Layout
        // =========================================
        $wp_customize->add_setting( 'otf_team_archive_layout', array(
            'default'           => '2cr',
        ) );
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_team_archive_layout', array(
            'section' => 'otf_team_archive',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));
        // Sidebar
        $wp_customize->add_setting( 'otf_team_archive_sidebar', array(
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_team_archive_sidebar', array(
            'section' => 'otf_team_archive',
            'label' => __( 'Sidebar', 'opal-theme-framework' ),
        ) ) );


        //Single portfolio layout
        $wp_customize->add_section( 'otf_team_single', array(
            'title'          => __( 'Single', 'opal-theme-framework' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'otf_team',
            'priority'       => 1,
        ) );

        // Select Layout
        $wp_customize->add_setting( 'otf_team_single_layout', array(
            'default'           => '2cr',
        ) );
        $wp_customize->add_control(new OTF_Customize_Control_Image_Select($wp_customize, 'otf_team_single_layout', array(
            'section' => 'otf_team_single',
            'label'   => __('Select Layout', 'opal-theme-framework'),
            'choices' => $this->options,
        )));

        $wp_customize->add_setting( 'otf_team_single_sidebar', array(
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_team_single_sidebar', array(
            'section' => 'otf_team_single',
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
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_team_archive_layout', '2cr');
        } else if (is_singular($this->post_type)) {
            $classes[] = 'opal-content-layout-' . get_theme_mod('otf_team_single_layout', '2cr');
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
            $mode = get_theme_mod('otf_team_archive_layout', '2cr');
            if($mode == '1c'){
                $name = '';
            }else if($sidebar = get_theme_mod('otf_team_archive_sidebar', '')){
                $name = $sidebar;
            }
        } else if (is_singular($this->post_type)) {
            $mode = get_theme_mod('otf_team_single_sidebar', '2cr');
            if($mode == '1c'){
                $name= '';
            }else if($sidebar = get_theme_mod('otf_team_single_sidebar', '')){
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
            'otf_team'
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     *  @return string
     */
    public function otf_team_shortcode($atts, $content = '') {
        ob_start();
        $this->render_shortcode('otf_team', $atts, $content);
        return ob_get_clean();
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

    public function show_social($id){
        $socials = array(
            //'website'     => 'link',
            'google_plus' => 'google-plus',
            'facebook'    => 'facebook',
            'twitter'     => 'twitter',
            'pinterest'   => 'pinterest'
        );
        $output = '';
        foreach($socials as $key => $val){
            $link_social = get_post_meta($id, 'otf_team_'.$key, true);
            if(!empty($link_social)){
                $output .= '<a href="'.esc_url($link_social).'" title="'.esc_html(ucfirst( str_replace('_',' ', $key )) ).'">';
                $output .= '<i class="fa fa-'.$val.'"></i>';
                $output .= '</a>';
            }
        }
        echo $output;
    }
}
OTF_Custom_Post_Type_Team::getInstance();