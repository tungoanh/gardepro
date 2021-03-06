<?php
if (!defined( 'ABSPATH' )){
    exit;
}

class OTF_Metabox {
    public function __construct() {
        add_action( 'cmb2_admin_init', array( $this, 'page_meta_box' ) );
    }

    public function page_meta_box() {
        $prefix = 'otf_';
        if(apply_filters('otf_check_page_settings', true)){
            $this->page_layout( $prefix );
            $this->page_header( $prefix );
            $this->page_breadcrumb( $prefix );
            $this->page_footer( $prefix );
        }

        $this->header_builder( $prefix );
    }

    private function header_builder($prefix = 'otf_') {
        $cmb2 = new_cmb2_box( array(
            'id'           => 'otf_header_builder',
            'title'        => __( 'Header Settings', 'opal-theme-framework' ),
            'object_types' => array( 'header' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Enable Header Absolute', 'opal-theme-framework' ),
            'id'      => $prefix . 'enable_header_absolute',
            'type'    => 'opal_switch',
            'default' => '0',
        ) );

        if (otf_is_woocommerce_activated()){
            $cmb2->add_field( array(
                'name'    => __( 'Show Cart', 'opal-theme-framework' ),
                'id'      => $prefix . 'enable_cart',
                'type'    => 'opal_switch',
                'default' => '0',
                'desc'    => 'Show cart in [Main Navigation]',
            ) );
        }

        $cmb2->add_field( array(
            'name'    => __( 'Show Search Form', 'opal-theme-framework' ),
            'id'      => $prefix . 'enable_search_form',
            'type'    => 'opal_switch',
            'default' => '0',
            'desc'    => 'Show search form in [Main Navigation]',
        ) );
    }

    private function page_footer($prefix = 'otf_') {
        $cmb2 = new_cmb2_box( array(
            'id'           => 'otf_page_footer',
            'title'        => __( 'Footer', 'opal-theme-framework' ),
            'object_types' => array( 'page' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $cmb2->add_field( array(
            'name'        => __( 'Enable Custom Footer', 'opal-theme-framework' ),
            'id'          => $prefix . 'enable_custom_footer',
            'type'        => 'opal_switch',
            'default'     => '0',
            'show_fields' => array(
                $prefix . 'footer_padding_top',
                $prefix . 'footer_layout',
            ),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Padding Top', 'opal-theme-framework' ),
            'id'      => $prefix . 'footer_padding_top',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Layout', 'opal-theme-framework' ),
            'id'      => $prefix . 'footer_layout',
            'type'    => 'opal_footer_layout',
            'default' => 'global',
        ) );
    }

    private function page_header($prefix = 'otf_') {
        $cmb2 = new_cmb2_box( array(
            'id'           => 'otf_page_header',
            'title'        => __( 'Header', 'opal-theme-framework' ),
            'object_types' => array( 'page' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $cmb2->add_field( array(
            'name'        => __( 'Enable Custom Header', 'opal-theme-framework' ),
            'id'          => $prefix . 'enable_custom_header',
            'type'        => 'opal_switch',
            'default'     => '0',
            'show_fields' => array(
                $prefix . 'header_layout',
                //                $prefix . 'search_position',
                //                $prefix . 'cart_position',
                //                $prefix . 'cart_position',
                //                $prefix . 'enable_fullwidth',
                //                $prefix . 'header_layout',
                //                $prefix . 'header_padding_top',
                //                $prefix . 'header_padding_bottom',
            ),
        ) );
        $headers = wp_parse_args( $this->get_post_type_data( 'header' ), array(
            'default' => esc_html__( 'Default', 'opal-theme-framework' ),
        ) );
        $cmb2->add_field( array(
            'name'             => __( 'Layout', 'opal-theme-framework' ),
            'id'               => $prefix . 'header_layout',
            'type'             => 'select',
            'show_option_none' => false,
            'default'          => 'default',
            'options'          => $headers,
        ) );
    }

    private function get_post_type_data($post_type = 'post') {
        $args = array(
            'post_type'      => 'header',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        $data = array();
        if ($posts = get_posts( $args )){
            foreach ($posts as $post) {
                /**
                 * @var $post WP_Post
                 */
                $data[$post->post_name] = $post->post_title;
            }
        }

        return $data;
    }

    private function page_breadcrumb($prefix = 'otf_') {
        $cmb2 = new_cmb2_box( array(
            'id'           => 'otf_page_breadcrumb',
            'title'        => __( 'Breadcrumb', 'opal-theme-framework' ),
            'object_types' => array( 'page' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $cmb2->add_field( array(
            'name'        => __( 'Enable Breadcrumb', 'opal-theme-framework' ),
            'id'          => $prefix . 'enable_breadcrumb',
            'type'        => 'opal_switch',
            'default'     => '1',
            'show_fields' => array(
                $prefix . 'breadcrumb_text_color',
                $prefix . 'breadcrumb_bg_color',
                $prefix . 'breadcrumb_bg_image',
                $prefix . 'heading_color',
            ),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Heading Color', 'opal-theme-framework' ),
            'id'      => $prefix . 'heading_color',
            'type'    => 'colorpicker',
            'default' => '',
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Breadcrumb Text Color', 'opal-theme-framework' ),
            'id'      => $prefix . 'breadcrumb_text_color',
            'type'    => 'colorpicker',
            'default' => '',
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Breadcrumb Background Color', 'opal-theme-framework' ),
            'id'      => $prefix . 'breadcrumb_bg_color',
            'type'    => 'colorpicker',
            'default' => '',
        ) );

        $cmb2->add_field( array(
            'name'         => __( 'Breadcrumb Background', 'opal-theme-framework' ),
            'desc'         => 'Upload an image or enter an URL.',
            'id'           => $prefix . 'breadcrumb_bg_image',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'text'         => array(
                'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
            ),
            'preview_size' => 'large', // Image size to use when previewing in the admin.
        ) );
    }

    private function page_layout($prefix = 'otf_') {
        $cmb2 = new_cmb2_box( array(
            'id'           => 'otf_page_layout',
            'title'        => __( 'Layout', 'opal-theme-framework' ),
            'object_types' => array( 'page' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Layout', 'opal-theme-framework' ),
            'id'      => $prefix . 'layout',
            'type'    => 'opal_switch_layout',
            'default' => '1c',
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Sidebar Width', 'opal-theme-framework' ),
            'id'      => $prefix . 'sidebar_width',
            'type'    => 'opal_slider',
            'default' => '320',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '400',
                'step' => '1',
                'unit' => 'px',
            ),
        ) );

        $cmb2->add_field( array(
            'name'             => __( 'Sidebar', 'opal-theme-framework' ),
            'desc'             => 'Select sidebar',
            'id'               => $prefix . 'sidebar',
            'type'             => 'select',
            'show_option_none' => true,
            'options'          => $this->get_sidebars(),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Enable Page Title', 'opal-theme-framework' ),
            'id'      => $prefix . 'enable_page_heading',
            'type'    => 'opal_switch',
            'default' => '1',
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Padding Top', 'opal-theme-framework' ),
            'id'      => $prefix . 'padding_top',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Padding Bottom', 'opal-theme-framework' ),
            'id'      => $prefix . 'padding_bottom',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ),
        ) );
    }

    /**
     * @return array
     */
    private function get_sidebars() {
        global $wp_registered_sidebars;
        $output = array();

        if (!empty( $wp_registered_sidebars )){
            foreach ($wp_registered_sidebars as $sidebar) {
                $output[$sidebar['id']] = $sidebar['name'];
            }
        }

        return $output;
    }
}