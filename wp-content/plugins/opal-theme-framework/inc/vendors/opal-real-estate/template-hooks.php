<?php
function ore_hooks_single_property() {
    $style = get_theme_mod( 'otf_property_single_style', 1 );
    switch ($style) {
        case 4:
            add_action( 'ore_single_property_before_item', 'ore_template_show_property_images_map', 10 );
            add_action( 'ore_single_property_before_item', 'otf_realestate_template_property_single_navigation', 10 );
            add_action( 'ore_single_property_before_item', 'ore_template_before_content', 30 );

            add_action( 'ore_single_property_before_summary', 'ore_template_show_all_labels', 5 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_title_address_start', 9 );
            add_action( 'ore_single_property_before_summary', 'ore_template_show_property_title', 10 );
            add_action( 'ore_single_property_before_summary', 'ore_template_show_address_group', 15 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_title_address_end', 16 );
            add_action( 'ore_single_property_before_summary', 'ore_template_price_html', 20 );

            add_action( 'ore_single_property_before_summary', 'ore_template_single_meta_info_start', 24 );
            add_action( 'ore_single_property_before_summary', 'ore_template_short_info', 25 );
            add_action( 'ore_single_property_before_summary', 'ore_template_loop_meta_button_single', 30 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_meta_info_end', 35 );

            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_description', 10 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_information', 20 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_amenities', 40 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_facilities', 50 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_360_virtual', 60 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_attachments', 70 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_floor_plans', 80 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_video', 90 );

            add_action( 'ore_single_property_after_item', 'ore_template_comment_form', 45 );
            add_action( 'ore_single_property_after_item', 'ore_template_after_content', 99 );
            break;
        case 3:
            add_action( 'ore_single_property_before_item', 'ore_template_before_content', 5 );

            add_action( 'ore_single_property_before_summary', 'ore_template_show_all_labels', 5 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_title_address_start', 9 );
            add_action( 'ore_single_property_before_summary', 'ore_template_show_property_title', 10 );
            add_action( 'ore_single_property_before_summary', 'ore_template_loop_property_address', 15 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_title_address_end', 16 );
            add_action( 'ore_single_property_before_summary', 'ore_template_price_html', 20 );

            add_action( 'ore_single_property_before_summary', 'ore_template_single_meta_info_start', 24 );
            add_action( 'ore_single_property_before_summary', 'ore_template_short_info', 25 );
            add_action( 'ore_single_property_before_summary', 'ore_template_loop_meta_button_single', 30 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_meta_info_end', 35 );

            add_action( 'ore_single_property_summary', 'ore_template_show_property_images', 10 );
            add_action( 'ore_single_property_summary', 'otf_realestate_template_property_single_tabs', 11 );

            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_description', 10 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_information', 20 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_map', 30 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_amenities', 40 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_facilities', 50 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_360_virtual', 60 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_attachments', 70 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_floor_plans', 80 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_video', 90 );

            add_action( 'ore_single_property_after_item', 'ore_template_comment_form', 45 );
            add_action( 'ore_single_property_after_item', 'ore_template_after_content', 99 );
            break;
        case 2:
            add_action( 'ore_single_property_before_item', 'ore_template_show_all_labels', 5 );
            add_action( 'ore_single_property_before_item', 'ore_template_single_title_address_start', 9 );
            add_action( 'ore_single_property_before_item', 'ore_template_show_property_title', 10 );
            add_action( 'ore_single_property_before_item', 'ore_template_loop_property_address', 15 );
            add_action( 'ore_single_property_before_item', 'ore_template_single_title_address_end', 16 );
            add_action( 'ore_single_property_before_item', 'ore_template_price_html', 20 );
            add_action( 'ore_single_property_before_item', 'ore_template_single_meta_info_start', 24 );
            add_action( 'ore_single_property_before_item', 'ore_template_short_info', 25 );
            add_action( 'ore_single_property_before_item', 'ore_template_loop_meta_button_single', 30 );
            add_action( 'ore_single_property_before_item', 'ore_template_single_meta_info_end', 35 );

            add_action( 'ore_single_property_before_item', 'ore_template_show_property_images', 45 );

            add_action( 'ore_single_property_before_item', 'ore_template_before_content', 99 );

            add_action( 'ore_single_property_summary', 'ore_template_show_property_description', 15 );
            add_action( 'ore_single_property_summary', 'ore_template_show_property_information', 20 );

            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_map', 10 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_amenities', 15 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_facilities', 20 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_360_virtual', 25 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_attachments', 30 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_floor_plans', 35 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_video', 40 );
            add_action( 'ore_single_property_after_summary', 'ore_template_comment_form', 45 );

            add_action( 'ore_single_property_after_item', 'ore_template_after_content', 99 );

            break;
        default:
            add_action( 'ore_single_property_before_item', 'ore_template_before_content', 5 );

            add_action( 'ore_single_property_before_summary', 'ore_template_show_all_labels', 5 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_title_address_start', 9 );
            add_action( 'ore_single_property_before_summary', 'ore_template_show_property_title', 10 );
            add_action( 'ore_single_property_before_summary', 'ore_template_loop_property_address', 15 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_title_address_end', 16 );
            add_action( 'ore_single_property_before_summary', 'ore_template_price_html', 20 );

            add_action( 'ore_single_property_before_summary', 'ore_template_single_meta_info_start', 24 );
            add_action( 'ore_single_property_before_summary', 'ore_template_short_info', 25 );
            add_action( 'ore_single_property_before_summary', 'ore_template_loop_meta_button_single', 30 );
            add_action( 'ore_single_property_before_summary', 'ore_template_single_meta_info_end', 35 );

            add_action( 'ore_single_property_summary', 'ore_template_show_property_images', 10 );
            add_action( 'ore_single_property_summary', 'ore_template_show_property_description', 15 );
            add_action( 'ore_single_property_summary', 'ore_template_show_property_information', 20 );

            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_map', 10 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_amenities', 15 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_facilities', 20 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_360_virtual', 25 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_attachments', 30 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_floor_plans', 35 );
            add_action( 'ore_single_property_after_summary', 'ore_template_show_property_video', 40 );
            add_action( 'ore_single_property_after_summary', 'ore_template_comment_form', 45 );

            add_action( 'ore_single_property_after_item', 'ore_template_after_content', 99 );
            break;
    }
}


add_action('opal-after-header', 'otf_realestate_template_single_property_header_search');