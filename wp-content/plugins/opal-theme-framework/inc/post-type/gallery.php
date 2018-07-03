<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Gallery
 */
class OTF_Custom_Post_Type_Gallery extends OTF_Custom_Post_Type_Abstract {
    public $post_type = 'gallery';
    public $taxonomy  = 'gallery_category';

    static $instance;

    /**
     * @return OTF_Custom_Post_Type_Gallery
     */
    public static function getInstance() {
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Gallery )){
            self::$instance = new OTF_Custom_Post_Type_Gallery();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public function create_post_type() {
        $labels = array(
            'name'               => __( 'Gallery', "opal-theme-framework" ),
            'singular_name'      => __( 'Gallery', "opal-theme-framework" ),
            'add_new'            => __( 'Add New Gallery', "opal-theme-framework" ),
            'add_new_item'       => __( 'Add New Gallery', "opal-theme-framework" ),
            'edit_item'          => __( 'Edit Gallery', "opal-theme-framework" ),
            'new_item'           => __( 'New Gallery', "opal-theme-framework" ),
            'view_item'          => __( 'View Gallery', "opal-theme-framework" ),
            'search_items'       => __( 'Search Gallery', "opal-theme-framework" ),
            'not_found'          => __( 'No Gallery found', "opal-theme-framework" ),
            'not_found_in_trash' => __( 'No Gallery found in Trash', "opal-theme-framework" ),
            'parent_item_colon'  => __( 'Parent Gallery:', "opal-theme-framework" ),
            'menu_name'          => __( 'Gallery', "opal-theme-framework" ),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => false,
            'description'         => 'List Gallery',
            'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ), //page-attributes, post-formats
            'taxonomies'          => array( $this->taxonomy ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->get_icon( __FILE__ ),
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => array( 'slug' => 'gallery' ),
            'capability_type'     => 'post',
        );
        register_post_type( $this->post_type, $args );
    }

    /**
     * @return void
     */
    public function create_taxonomy() {
        $labels = array(
            'name'              => __( 'Categories', "opal-theme-framework" ),
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
        $agrs   = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_nav_menus' => true,
            'rewrite'           => array( 'slug' => 'gallery-category' ),
        );
        // Now register the taxonomy
        register_taxonomy( $this->taxonomy, array( $this->post_type ), $agrs );

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
        $cmb = new_cmb2_box( array(
            'id'           => 'otf_gallery',
            'title'        => __( 'Gallery Settings', 'opal-theme-framework' ),
            'object_types' => array( $this->post_type ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $args = array(
            array(
                'name'         => __( 'Gallery', 'opal-theme-framework' ),
                'desc'         => __( 'Add image for gallery', 'opal-theme-framework' ),
                'id'           => 'otf_gallery_file_list',
                'type'         => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                'query_args'   => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => array(
                    'add_upload_files_text' => __( 'Add or Upload Files', 'opal-theme-framework' ), // default: "Add or Upload Files"
                    'remove_image_text'     => __( 'Remove Image', 'opal-theme-framework' ), // default: "Remove Image"
                    'file_text'             => __( 'Image', 'opal-theme-framework' ), // default: "File:"
                    'file_download_text'    => __( 'Download', 'opal-theme-framework' ), // default: "Download"
                    'remove_text'           => __( 'Remove', 'opal-theme-framework' ) // default: "Remove"
                ),
            ),
        );

        $this->init_meta_box( $cmb, $args, __FILE__ );
    }

    /**
     * @param $buttons
     *
     * @return array
     */
    public function customizer_buttons($buttons) {
        $buttons = wp_parse_args( $buttons, array(
            '.single-' . $this->post_type . ' #content' => array(
                array(
                    'id'   => 'otf_gallery_single',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.tax-' . $this->taxonomy . ' #content'     => array(
                array(
                    'id'   => 'otf_gallery_archive',
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
    public function customize_register($wp_customize) {
        $this->link_image = trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_URL ) . 'assets/images/customize/';
        $wp_customize->add_panel( 'otf_gallery', array(
            'title'      => __( 'Gallery', 'opal-theme-framework' ),
            'capability' => 'edit_theme_options',
            'priority'   => 1,
        ) );

        //Portfolio Archive config
        $wp_customize->add_section( 'otf_gallery_archive', array(
            'title'      => __( 'Archive', 'opal-theme-framework' ),
            'capability' => 'edit_theme_options',
            'panel'      => 'otf_gallery',
            'priority'   => 1,
        ) );

        // =========================================
        // Select Layout
        // =========================================
        $wp_customize->add_setting( 'otf_gallery_archive_layout', array(
            'default' => '2cr',
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_gallery_archive_layout', array(
            'section' => 'otf_gallery_archive',
            'label'   => __( 'Select Layout', 'opal-theme-framework' ),
            'choices' => $this->options,
        ) ) );
        // Sidebar
        $wp_customize->add_setting( 'otf_gallery_archive_sidebar', array() );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_gallery_archive_sidebar', array(
            'section' => 'otf_gallery_archive',
            'label'   => __( 'Sidebar', 'opal-theme-framework' ),
        ) ) );


        //Single portfolio layout
        $wp_customize->add_section( 'otf_gallery_single', array(
            'title'      => __( 'Single', 'opal-theme-framework' ),
            'capability' => 'edit_theme_options',
            'panel'      => 'otf_gallery',
            'priority'   => 1,
        ) );

        // Select Layout
        $wp_customize->add_setting( 'otf_gallery_single_layout', array(
            'default' => '2cr',
        ) );
        $wp_customize->add_control( new OTF_Customize_Control_Image_Select( $wp_customize, 'otf_gallery_single_layout', array(
            'section' => 'otf_gallery_single',
            'label'   => __( 'Select Layout', 'opal-theme-framework' ),
            'choices' => $this->options,
        ) ) );

        $wp_customize->add_setting( 'otf_gallery_single_sidebar', array() );
        $wp_customize->add_control( new OTF_Customize_Control_Sidebars( $wp_customize, 'otf_gallery_single_sidebar', array(
            'section' => 'otf_gallery_single',
            'label'   => __( 'Sidebar', 'opal-theme-framework' ),
        ) ) );
    }

    /**
     * @param $classes
     *
     * @return array
     */
    public function body_class($classes) {
        if (is_post_type_archive( $this->post_type ) || is_tax( $this->taxonomy )){
            $classes[] = 'opal-content-layout-' . get_theme_mod( 'otf_gallery_archive_layout', '2cr' );
        } else{
            if (is_singular( $this->post_type )){
                $classes[] = 'opal-content-layout-' . get_theme_mod( 'otf_gallery_single_layout', '2cr' );
            }
        }

        return $classes;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function set_sidebar($name) {
        if (is_post_type_archive( $this->post_type ) || is_tax( $this->taxonomy )){
            $mode = get_theme_mod( 'otf_gallery_archive_layout', '2cr' );
            if ($mode == '1c'){
                $name = '';
            } else{
                if ($sidebar = get_theme_mod( 'otf_gallery_archive_sidebar', '' )){
                    $name = $sidebar;
                }
            }
        } else{
            if (is_singular( $this->post_type )){
                $mode = get_theme_mod( 'otf_gallery_single_sidebar', '2cr' );
                if ($mode == '1c'){
                    $name = '';
                } else{
                    if ($sidebar = get_theme_mod( 'otf_gallery_single_sidebar', '' )){
                        $name = $sidebar;
                    }
                }
            }
        }

        return $name;
    }

    /**
     * @return array
     */
    public function add_shortcode() {
        return array(
            'otf_gallery',
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function otf_gallery_shortcode($atts, $content = '') {
        return $this->render_shortcode( 'otf_gallery', $atts, $content );
    }

    public function create_query($per_page = -1, $taxonomies = array()) {
        $args = array(
            'post_type'      => $this->post_type,
            'posts_per_page' => $per_page,
            'post_status'    => 'publish',
        );
        if (!empty( $taxonomies )){
            $args ['tax_query'] = array(
                'taxonomy' => $this->taxonomy,
                'field'    => 'slug',
                'terms'    => $taxonomies,
            );
        }

        return new WP_Query( $args );
    }

    /**
     * @return array|int|WP_Error
     */
    public function get_terms() {
        return get_terms( array( $this->taxonomy ) );
    }

    /**
     * @param $id
     *
     * @return array|false|WP_Error
     */
    public function get_the_terms($id) {
        return get_the_terms( $id, $this->taxonomy );
    }
}

OTF_Custom_Post_Type_Gallery::getInstance();