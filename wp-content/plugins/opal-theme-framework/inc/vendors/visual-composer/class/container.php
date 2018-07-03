<?php

class WPBakeryShortCode_OTF_Container_Base extends WPBakeryShortCodesContainer {
    protected function findShortcodeTemplate() {
        // Check template path in shortcode's mapping settings
        if (!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
            return $this->setTemplate($this->settings['html_template']);
        }

        // Check Template in FW
        $fw_template = trailingslashit(OPAL_THEME_FRAMEWORK_PLUGIN_DIR) . 'inc/vendors/visual-composer/vc_templates/' . $this->getFileName() . '.php';
        if (is_file($fw_template)) {
            return $this->setTemplate($fw_template);
        }

        // Check template in theme directory
        $user_template = vc_shortcodes_theme_templates_dir($this->getFileName() . '.php');
        if (is_file($user_template)) {
            return $this->setTemplate($user_template);
        }

        // Check default place
        $default_dir = vc_manager()->getDefaultShortcodesTemplatesDir() . '/';
        if (is_file($default_dir . $this->getFileName() . '.php')) {
            return $this->setTemplate($default_dir . $this->getFileName() . '.php');
        }

        return '';
    }

    public function getColumnControls($controls = 'full', $extended_css = '') {
        $controls_start = '<div style="margin-bottom: 20px;" class="vc_controls vc_controls-visible controls_column' . (!empty($extended_css) ? " {$extended_css}" : '') . '">';
        $controls_end = '</div>';

        if ('bottom-controls' === $extended_css) {
            $control_title = sprintf(__('Append to this %s', 'opal-theme-framework'), strtolower($this->settings('name')));
        } else {
            $control_title = sprintf(__('Prepend to this %s', 'opal-theme-framework'), strtolower($this->settings('name')));
        }

        $controls_move = '<a class="vc_control-btn vc_element-name vc_element-move" data-vc-control="move" href="#" title="' . sprintf(__('Move this %s', 'opal-theme-framework'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-dragndrop"></i>' . $this->settings('name') . '</span></a>';
        $moveAccess = vc_user_access()->part('dragndrop')->checkStateAny(true, null)->get();
        if (!$moveAccess) {
            $controls_move = '';
        }
        $controls_add = '<a class="vc_control column_add" data-vc-control="add" href="#" title="' . $control_title . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-add"></i></span></a>';
        $controls_edit = '<a class="vc_control-btn vc_control-btn-prepend vc_edit" data-vc-control="edit" href="#" title="' . sprintf(__('Edit this %s', 'opal-theme-framework'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-mode_edit"></i></span></a>';
        $controls_clone = '<a class="vc_control-btn vc_control-btn-clone" data-vc-control="clone" href="#" title="' . sprintf(__('Clone this %s', 'opal-theme-framework'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-content_copy"></i></span></a>';
        $controls_delete = '<a class="vc_control-btn vc_control-btn-delete" data-vc-control="delete" href="#" title="' . sprintf(__('Delete this %s', 'opal-theme-framework'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-delete_empty"></i></span></a>';

        $controls_full = <<<HTML
        <div class="wpb_vc_tta_tabs" style="width: 100%;">
            <div class="vc_controls-out-tc vc_controls-content-widget" style="display: inline-block;">
                {$controls_move}
                {$controls_add}
                {$controls_edit}
                {$controls_clone}
                {$controls_delete}
            </div>
</div>
HTML;


        $editAccess = vc_user_access_check_shortcode_edit($this->shortcode);
        $allAccess = vc_user_access_check_shortcode_all($this->shortcode);

        if (!empty($controls)) {
            if (is_string($controls)) {
                $controls = array($controls);
            }
            $controls_string = $controls_start;
            foreach ($controls as $control) {
                $control_var = 'controls_' . $control;
                if (($editAccess && 'edit' == $control) || $allAccess) {
                    if (isset(${$control_var})) {
                        $controls_string .= ${$control_var};
                    }
                }
            }

            return $controls_string . $controls_end;
        }

        if ($allAccess) {
            return $controls_start . $controls_full . $controls_end;
        } elseif ($editAccess) {
            return $controls_start . $controls_edit . $controls_end;
        }

        return $controls_start . $controls_end;
    }
}