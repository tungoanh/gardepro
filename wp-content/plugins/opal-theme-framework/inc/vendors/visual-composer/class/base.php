<?php
class WPBakeryShortCode_OTF_Base extends WPBakeryShortCode {

    protected function findShortcodeTemplate() {
        // Check template path in shortcode's mapping settings
        if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
            return $this->setTemplate( $this->settings['html_template'] );
        }

        // Check Template in FW
        $fw_template = trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/vendors/visual-composer/vc_templates/' . $this->getFileName() . '.php' ;
        if ( is_file( $fw_template ) ) {
            return $this->setTemplate( $fw_template );
        }

        // Check template in theme directory
        $user_template = vc_shortcodes_theme_templates_dir( $this->getFileName() . '.php' );
        if ( is_file( $user_template ) ) {
            return $this->setTemplate( $user_template );
        }

        // Check default place
        $default_dir = vc_manager()->getDefaultShortcodesTemplatesDir() . '/';
        if ( is_file( $default_dir . $this->getFileName() . '.php' ) ) {
            return $this->setTemplate( $default_dir . $this->getFileName() . '.php' );
        }

        return '';
    }

    /**
     * @param $taxonomies
     *
     * @see wp_generate_uuid4()
     *
     * @return array
     */
    public function getSettingsTaxonomies($taxonomies) {
        $settings = array();
        $vc_taxonomies_types = get_taxonomies(array('public' => true));
        $terms = get_terms(array_keys($vc_taxonomies_types), array(
            'hide_empty' => false,
            'include'    => $taxonomies,
        ));
        $settings['tax_query'] = array();
        $tax_queries = array(); // List of taxnonimes
        foreach ($terms as $t) {
            if (!isset($tax_queries[$t->taxonomy])) {
                $tax_queries[$t->taxonomy] = array(
                    'taxonomy' => $t->taxonomy,
                    'field'    => 'id',
                    'terms'    => array($t->term_id),
                    'relation' => 'IN',
                );
            } else {
                $tax_queries[$t->taxonomy]['terms'][] = $t->term_id;
            }
        }
        $settings['tax_query'] = array_values($tax_queries);
        $settings['tax_query']['relation'] = 'OR';

        return $settings;
    }
}