<?php

class OTF_Import {
    private $config;
    private $link_config = false;

    private $path_rev;

    public function __construct() {
        if (is_admin()) {
            $this->path_rev = trailingslashit(get_template_directory()) . 'rev_sliders_import/';
            add_action('after_setup_theme', array($this, 'init'));
        }
    }

    public function init() {
        $this->config = $this->get_remote_json(apply_filters('otf_oneclick_config_url', trailingslashit(get_template_directory_uri()) . 'config.json'));
        if ($this->config && $this->config->demos) {
            $this->init_hooks();
        }
        add_filter('pt-ocdi/disable_pt_branding', '__return_true');
    }

    public function init_hooks() {
        add_action('otf_before_import_customizer', array($this, 'reset_theme_mods'));
        if (get_option('otf-oneclick-first-import', 'yes') === 'yes') {
            add_filter('pt-ocdi/import_files', array($this, 'import_file_base'));
            add_action('pt-ocdi/after_import', array($this, 'after_import_setup_base'));
        } else {
            add_filter('pt-ocdi/import_files', array($this, 'import_files'));
            add_action('pt-ocdi/after_import', array($this, 'after_import_setup'));
            add_filter('pt-ocdi/enable_grid_layout_import_popup_confirmation', '__return_false');
            add_filter('otf-ocdi/reload_page', '__return_false');
        }
    }

    private function set_logo($image) {
        $custom_logo   = get_theme_mod('otf_custom_logo', 0);
        $wp_upload_dir = wp_upload_dir();
        $path_uploads  = trailingslashit($wp_upload_dir['basedir']) . 'opal_uploads/';
        if (!file_exists($path_uploads)) {
            mkdir($path_uploads, 0777, true);
        }
        $filename = $path_uploads . 'logo.png';
        if ($imgLogo = wp_remote_fopen($image)) {
            file_put_contents($filename, $imgLogo);
        }

        if (!$custom_logo) {
            // Check the type of file. We'll use this as the 'post_mime_type'.
            $filetype = wp_check_filetype(basename($filename), null);

            // Get the path to the upload directory.

            // Prepare an array of post data for the attachment.
            $attachment = array(
                'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
                'post_mime_type' => $filetype['type'],
                'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            // Insert the attachment.
            $custom_logo = wp_insert_attachment($attachment, $filename);

            // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Generate the metadata for the attachment, and update the database record.
            $attach_data = wp_generate_attachment_metadata($custom_logo, $filename);
            wp_update_attachment_metadata($custom_logo, $attach_data);
            set_theme_mod('otf_custom_logo', $custom_logo);
        }

        set_theme_mod('custom_logo', $custom_logo);
    }

    public function import_file_base() {
        add_filter('intermediate_image_sizes', '__return_empty_array');
        $imports = array();
        $demo    = $this->config->base;
        $import  = array(
            'import_file_name' => $demo->import_file_name,
            'import_notice'    => __('After you import this demo, you will have to setup the slider separately.', 'opal-theme-framework'),
        );

        if (isset($demo->import_notice)) {
            $import['import_notice'] = $demo->import_notice;
        }
        if (isset($demo->categories)) {
            $import['categories'] = $demo->categories;
        }
        if (isset($demo->import_file_url) && $demo->import_file_url) {
            $import['import_file_url'] = $demo->import_file_url;
        }
        if (isset($demo->import_preview_image_url)) {
            $import['import_preview_image_url'] = $demo->import_preview_image_url;
        }
        if (isset($demo->import_widget_file_url)) {
            $import['import_widget_file_url'] = $demo->import_widget_file_url;
        }
        if (isset($demo->import_customizer_file_url)) {
            $import['import_customizer_file_url'] = $demo->import_customizer_file_url;
        }
        if (isset($demo->preview_url)) {
            $import['preview_url'] = $demo->preview_url;
        }

        $imports[] = $import;


        return $imports;
    }

    public function import_files() {
        $imports = array();
        $params = array('categories', 'import_file_url', 'import_preview_image_url', 'import_widget_file_url', 'import_customizer_file_url', 'preview_url', 'is_new');
        foreach ($this->config->demos as $demo) {
            $import = array(
                'import_file_name' => $demo->import_file_name,
            );

            foreach ($params as $param){
                if (isset($demo->$param)) {
                    $import[$param] = $demo->$param;
                }
            }

            $imports[] = $import;
        }


        return $imports;
    }

    public function after_import_setup_base($selected_import) {
        set_theme_mod('otf_dev_mode', false);
        update_option('otf-oneclick-first-import', 'no');
        if (!file_exists($this->path_rev)) {
            mkdir($this->path_rev, 0777, true);
        }

        $base = $this->config->base;

        if ($base->woocommerce) {
            $woocommerce = $this->get_remote_json($this->config->base->woocommerce);
            foreach ($woocommerce as $key => $value) {
                $woocommerce_page = get_page_by_title(trim($value));
                if ($woocommerce_page) {
                    update_option($key, $woocommerce_page->ID);
                }
            }
        }

        // Sliders
        if (class_exists('RevSliderAdmin')) {
            if ($sliders = $base->rev_sliders) {
                foreach ($sliders as $slider) {
                    $this->add_revslider($slider);
                }
            }
        }

        if ($base->settings) {
            $settings = $this->get_remote_json($base->settings);
            if ($settings) {
                $this->update_settings($settings);
            }
        }

        if (isset($base->logo)) {
            $this->set_logo($base->logo);
        }

        if (class_exists('Vc_Manager') && $base->js_composer_front_custom) {
            $this->update_js_composer_css($base->js_composer_front_custom);
        }

        // Update Vc Grid
        $this->update_vc_custom_grid_css();
    }

    /**
     * @param $selected_import
     */
    public function after_import_setup($selected_import) {
        set_theme_mod('otf_dev_mode', false);

        if (!file_exists($this->path_rev)) {
            mkdir($this->path_rev, 0777, true);
        }

        foreach ($this->config->demos as $demo) {
            if ($demo->import_file_name === $selected_import['import_file_name']) {
                if ($demo->settings) {
                    $settings = $this->get_remote_json($demo->settings);
                    if ($settings) {
                        $this->update_settings($settings);
                    }
                }

                // Sliders
                if (class_exists('RevSliderAdmin')) {
                    if ($sliders = $demo->rev_sliders) {
                        foreach ($sliders as $slider) {
                            $this->add_revslider($slider);
                        }
                    }
                }

                if (class_exists('Vc_Manager') && $demo->js_composer_front_custom) {
                    $this->update_js_composer_css($demo->js_composer_front_custom);
                }

                if (isset($demo->logo)) {
                    $this->set_logo($demo->logo);
                }
                break;
            }
        }
        set_theme_mod('otf_theme_custom_style', otf_theme_custom_css());
        set_theme_mod('otf_theme_google_fonts', otf_get_fonts_url());

        // Update Vc Grid
        $this->update_vc_custom_grid_css();
    }

    private function update_settings($settings){
        $menu_locations = array();
        foreach ($settings->menus as $menu_key => $menu) {
            $menu_locations[$menu_key] = get_term_by('slug', $menu, 'nav_menu')->term_id;
        }
        if (count($menu_locations) > 0) {
            set_theme_mod('nav_menu_locations', $menu_locations);
        }

        // Set Homepage
        $display = $settings->displays;
        update_option('show_on_front', $display->show_on_front);
        update_option('page_on_front', ((($page = get_page_by_title($display->page_on_front)) instanceof WP_Post) ? $page->ID : 0));
        update_option('page_for_posts', ((($page = get_page_by_title($display->page_for_posts)) instanceof WP_Post) ? $page->ID : 0));
        // Set Footer Customizer
        set_theme_mod('otf_footer_layout', ((($page = get_page_by_title($display->footer_layout_customizer, OBJECT, 'footer')) instanceof WP_Post) ? $page->ID : 0));

        // Plugins
        if (isset($settings->plugins)) {
            $plugins = $settings->plugins;
            foreach ($plugins as $plugin) {
                foreach ($plugin as $key => $value) {
                    update_option($key, $value);
                }
            }
        }
    }

    private function add_revslider($slider){
        $dest_rev = $this->path_rev . basename($slider);
        if (!file_exists($dest_rev)) {
            file_put_contents($dest_rev, wp_remote_fopen($slider));
            $_FILES['import_file']['error']    = UPLOAD_ERR_OK;
            $_FILES['import_file']['tmp_name'] = $dest_rev;

            $revslider = new RevSlider();
            $revslider->importSliderFromPost(true, 'none');
        }
    }

    /**
     * @param $link string
     */
    private function update_js_composer_css($link){
        $upload_dir    = wp_upload_dir();
        $vc_upload_dir = vc_upload_dir();
        if (!file_exists($upload_dir['basedir'] . '/' . $vc_upload_dir)) {
            mkdir($upload_dir['basedir'] . '/' . $vc_upload_dir, 0777, true);
        }
        file_put_contents($upload_dir['basedir'] . '/' . $vc_upload_dir . '/js_composer_front_custom.css', wp_remote_fopen($link));
    }

    /**
     * @param $link
     *
     * @return object|boolean
     */
    private function get_remote_json($link) {
        $content = wp_remote_get($link);
        if ($content instanceof WP_Error) {
            return false;
        }
        return json_decode($content['body']);
    }

    public function reset_theme_mods() {
        $mods = json_decode(file_get_contents(trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'reset-theme-mods.json'));
        foreach ($mods as $mod) {
            remove_theme_mod($mod);
        }
    }

    private function update_vc_custom_grid_css() {
        $query = new WP_Query(array(
            'post_type'      => 'vc_grid_item',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ));
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $value   = get_post_meta($post_id, '_wpb_shortcodes_custom_css');
            if (count($value) > 1) {
                update_post_meta($post_id, '_wpb_shortcodes_custom_css', $value[1]);
            }
        }
        wp_reset_query();
    }
}

return new OTF_Import();
