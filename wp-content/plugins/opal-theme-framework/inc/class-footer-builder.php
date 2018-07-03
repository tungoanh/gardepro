<?php

class OTF_Footer_builder {

    public function __construct() {
        add_action('wp', array($this, 'setup_footer'));
        add_action('admin_bar_menu', array($this, 'custom_button_footer_builder'), 50);
    }

    /**
     * @param $wp_admin_bar WP_Admin_Bar
     */
    public function custom_button_footer_builder($wp_admin_bar) {
        global $otf_footer;
        if ($otf_footer && $otf_footer instanceof WP_Post) {
            $args = array(
                'id'    => 'footer-builder-button',
                'title' => __('Edit Footer', 'opal-theme-framework'),
                'href'  => get_edit_post_link($otf_footer->ID),
//            'meta'  => array(
//                'class' => 'custom-button-class'
//            )
            );
            $wp_admin_bar->add_node($args);
        }
    }


    public function setup_footer() {
        global $otf_footer;
        $footer_id = get_theme_mod('otf_footer_layout');
        if ( otf_get_metabox(get_the_ID(), 'otf_enable_custom_footer', false) && $fid = otf_get_metabox(get_the_ID(), 'otf_footer_layout', 'default')) {
            if ($fid != 'global' && $fid != 'default') {
                $footer_id = $fid;
                $otf_footer = get_post($footer_id);
            }
        }else{
            if ($footer_id && $footer_id != 'global' && $footer_id != 'default') {
                $otf_footer = get_post($footer_id);
            }
        }

    }

}

new OTF_Footer_builder();