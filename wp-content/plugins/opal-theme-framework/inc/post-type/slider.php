<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Slider
 */
class OTF_Custom_Post_Type_Slider extends OTF_Custom_Post_Type_Abstract {
    public $post_type = 'slider';
    public $taxonomy  = 'slider_category';

    static $instance;

    /**
     * @return OTF_Custom_Post_Type_Slider
     */
    public static function getInstance() {
        if (!isset( self::$instance ) && !( self::$instance instanceof OTF_Custom_Post_Type_Slider )){
            self::$instance = new OTF_Custom_Post_Type_Slider();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public function create_post_type() {
        $labels = array(
            'name'               => __( 'Slider', "opal-theme-framework" ),
            'singular_name'      => __( 'Slider', "opal-theme-framework" ),
            'add_new'            => __( 'Add New Slider', "opal-theme-framework" ),
            'add_new_item'       => __( 'Add New Slider', "opal-theme-framework" ),
            'edit_item'          => __( 'Edit Slider', "opal-theme-framework" ),
            'new_item'           => __( 'New Slider', "opal-theme-framework" ),
            'view_item'          => __( 'View Slider', "opal-theme-framework" ),
            'search_items'       => __( 'Search Slider', "opal-theme-framework" ),
            'not_found'          => __( 'No Slider found', "opal-theme-framework" ),
            'not_found_in_trash' => __( 'No Slider found in Trash', "opal-theme-framework" ),
            'parent_item_colon'  => __( 'Parent Slider:', "opal-theme-framework" ),
            'menu_name'          => __( 'Slider', "opal-theme-framework" ),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => false,
            'description'         => 'List Slider',
            'supports'            => array( 'title', 'editor', 'thumbnail'), //page-attributes, post-formats
            'taxonomies'          => array( $this->taxonomy ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->get_icon( __FILE__ ),
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => array( 'slug' => 'slider' ),
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
            'rewrite'           => array( 'slug' => 'slider-category' ),
        );
        // Now register the taxonomy
        register_taxonomy( $this->taxonomy, array( $this->post_type ), $agrs );

    }

    /**
     * @return array
     */
    public function add_shortcode() {
        return array(
            'otf_slider',
        );
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function otf_slider_shortcode($atts, $content = '') {
        return $this->render_shortcode( 'otf_slider', $atts, $content );
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

    public function get_option_terms(){
        $terms = $this->get_terms();
        $results = array();
        foreach($terms as $term){
            $results[$term->name] = $term->term_id;
        }
        return $results;
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

OTF_Custom_Post_Type_Slider::getInstance();