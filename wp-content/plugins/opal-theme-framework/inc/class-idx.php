<?php

class OTF_IDX {

    /**
     * OTF_IDX constructor.
     */
    public function __construct() {
        if (class_exists( 'Vc_Manager' )){
            $this->map_shortcodes();
            add_shortcode( 'otf_idx_page', array( $this, 'idx_page_shortcode' ) );
        }
    }

    /**
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function idx_page_shortcode($atts, $content = '') {
        $atts = shortcode_atts( array(
            'id' => '',
        ), $atts, 'otf_idx_page' );
        if (!$atts['id']){
            return '';
        }
        $post = get_post( $atts['id'] );

        return do_shortcode( $post->post_content );
    }


    public function map_shortcodes() {

        vc_map( array(
            "name"     => __( "IDX Page", "opal-theme-framework" ),
            "base"     => "otf_idx_page",
            "category" => __( "IDX", "opal-theme-framework" ),
            "params"   => array(
                array(
                    'type'       => 'dropdown',
                    'heading'    => __( 'Select IDX Page', 'opal-theme-framework' ),
                    'param_name' => 'id',
                    'value'      => $this->get_idx_pages(),
                ),
            ),
        ) );

        vc_map( array(
            "name"     => __( "IDX Quick Search", "opal-theme-framework" ),
            "base"     => "idx_quick_search",
            "category" => __( "IDX", "opal-theme-framework" ),
            "params"   => array(
                array(
                    "type"        => "dropdown",
                    'value'       => array(
                        __( 'Horizontal -  Recommended for wider areas', 'opal-theme-framework' ) => 'horizontal',
                        __( 'Vertical - Recommended for side columns', 'opal-theme-framework' )   => 'vertical',
                    ),
                    'admin_label' => true,
                    "heading"     => __( "Aspect Ratio", "opal-theme-framework" ),
                    "param_name"  => "format",
                    "std"         => 'horizontal',
                ),
            ),
        ) );

        vc_map( array(
            "name"     => __( "IDX Listing", "opal-theme-framework" ),
            "base"     => "idx_listing",
            "category" => __( "IDX", "opal-theme-framework" ),
            "params"   => array(
                array(
                    "type"       => "textfield",
                    "heading"    => esc_html__( "Number", 'opal-theme-framework' ),
                    "param_name" => "mlsnumber",
                ),
                array(
                    "type"       => "textfield",
                    "heading"    => esc_html__( "Status", 'opal-theme-framework' ),
                    "param_name" => "statuses",
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => esc_html__( "Show All", 'opal-theme-framework' ),
                    "param_name" => "showall",
                    'value'      => array(
                        esc_html__( 'Yes', 'opal-theme-framework' ) => 'true',
                    ),
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => esc_html__( "Show Price History", 'opal-theme-framework' ),
                    "param_name" => "showpricehistory",
                    'value'      => array(
                        esc_html__( 'Yes', 'opal-theme-framework' ) => 'true',
                    ),
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => esc_html__( "Show School", 'opal-theme-framework' ),
                    "param_name" => "showschools",
                    'value'      => array(
                        esc_html__( 'Yes', 'opal-theme-framework' ) => 'true',
                    ),
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => esc_html__( "Show Extra Details", 'opal-theme-framework' ),
                    "param_name" => "showextradetails",
                    'value'      => array(
                        esc_html__( 'Yes', 'opal-theme-framework' ) => 'true',
                    ),
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => esc_html__( "Show Features", 'opal-theme-framework' ),
                    "param_name" => "showfeatures",
                    'value'      => array(
                        esc_html__( 'Yes', 'opal-theme-framework' ) => 'true',
                    ),
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => esc_html__( "Show Location", 'opal-theme-framework' ),
                    "param_name" => "showlocation",
                    'value'      => array(
                        esc_html__( 'Yes', 'opal-theme-framework' ) => 'true',
                    ),
                ),
            ),
        ) );
    }

    /**
     * @return array
     */
    private function get_idx_pages() {
        $args = array(
            'post_type'      => 'ds-idx-listings-page',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );

        $posts   = get_posts( $args );
        $options = array(
            __( 'Select IDX Page', 'opal-theme-framework' ) => '',
        );
        foreach ($posts as $post) {
            /**
             * @var $post WP_Post
             */
            $options[$post->post_title] = $post->ID;
        }

        return $options;
    }
}

new OTF_IDX();