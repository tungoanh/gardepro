<?php

class OTF_CSS {

    private $args;

    /**
     * OTF_CSS constructor.
     * @param $id   string
     * @param $atts array
     */
    public function __construct($args) {
        $this->args = $args;
        $this->render();
    }

    public function render() {
        if (count($this->args) <= 0) {
            return;
        }
        echo '<style scoped>';
        foreach ($this->args as $selector => $atts) {
            $css = $this->render_code($atts);
            if(!empty($css)){
                echo '#' . $selector . '{';
                echo $css;
                echo '}';
            }
        }
        echo '</style>';
    }

    private function render_code($atts) {
        $css = '';
        foreach ($atts as $key => $value) {
            if(!empty($value)){
                $css .= "{$key}: {$value};";
            }
        }

        return $css;
    }
}