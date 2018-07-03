<?php

if (!defined( 'ABSPATH' )){
    exit; // Exit if accessed directly
}

class OTF_CMB2_Field_Footer_Layout {

    /**
     * Current version number
     */
    const VERSION = '1.0.0';

    /**
     * Initialize the plugin by hooking into CMB2
     */
    public function __construct() {
        add_filter( 'cmb2_render_opal_footer_layout', array( $this, 'render' ), 10, 5 );
    }

    /**
     * Render field
     */
    public function render($field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object) {
        $footers        = $this->get_footers();
        $footer_default = trailingslashit( OPAL_THEME_FRAMEWORK_PLUGIN_URL ) . 'assets/images/customize/footer-default.png';
        echo $field_type_object->input( array( 'type' => 'hidden' ) );
        $option = '<option value="default" selected>'. esc_html__('Default', 'opal-theme-framework') .'</option>';
        if ($footers){
            foreach ($footers as $footer) {
                $option .= '<option value="' . esc_attr( $footer->ID ) . '"' . selected( $field_escaped_value, $footer->ID, false ) . '>' . esc_html( $footer->post_title ) . '</option>';
            };
        }
        $images = '<div data-value="default" class="image-select-tpl' . ( $field_escaped_value == '0' ? ' active' : '' ) . '"><img src="' . esc_url_raw( $footer_default ) . '" alt="default"></div>';
        if ($footers){
            foreach ($footers as $footer) {
                $images .= '<div data-value="' . esc_attr( $footer->ID ) . '" class="image-select-tpl' . ( $field_escaped_value == $footer->ID ? ' active' : '' ) . '">';
                if(has_post_thumbnail($footer->ID)){
                    $images .= '<img src="' . esc_url_raw( get_the_post_thumbnail_url( $footer->ID, 'full' ) ) . '" alt="' . esc_attr( $footer->ID ) . '">';
                }
                $images .= '</div>';
            };
        }
        echo '<div class="cmb2-footer-layout opal-control-image-select opal-control-footer" data-id="' . $field->_id() . '">
                <div class="select-control footer-select">
                    <select>' . $option . '</select>
                </div>
            <div class="image-select">
                ' . $images . '
            </div>
        </div>';
    }

    private function get_footers() {
        $args = array(
            'post_type'      => 'footer',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );

        return get_posts( $args );
    }
}

new OTF_CMB2_Field_Footer_Layout();
