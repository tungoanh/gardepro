<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class OTF_Custom_Post_Type_Header
 */
class OTF_Custom_Post_Type_Header extends OTF_Custom_Post_Type_Abstract
{

    /**
     * @return void
     */
    public function create_post_type()
    {

        $labels = array(
            'name'               => __('Header', "opal-theme-framework"),
            'singular_name'      => __('Header', "opal-theme-framework"),
            'add_new'            => __('Add New Header', "opal-theme-framework"),
            'add_new_item'       => __('Add New Header', "opal-theme-framework"),
            'edit_item'          => __('Edit Header', "opal-theme-framework"),
            'new_item'           => __('New Header', "opal-theme-framework"),
            'view_item'          => __('View Header', "opal-theme-framework"),
            'search_items'       => __('Search Headers', "opal-theme-framework"),
            'not_found'          => __('No Headers found', "opal-theme-framework"),
            'not_found_in_trash' => __('No Headers found in Trash', "opal-theme-framework"),
            'parent_item_colon'  => __('Parent Header:', "opal-theme-framework"),
            'menu_name'          => __('Header Builder', "opal-theme-framework"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => __('List Header', "opal-theme-framework"),
            'supports'            => array('title', 'editor', 'thumbnail'), //page-attributes, post-formats
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->get_icon(__FILE__),
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => true,
            'capability_type'     => 'post'
        );
        register_post_type('header', $args);
    }


}

new OTF_Custom_Post_Type_Header;

