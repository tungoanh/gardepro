<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OTF_Customize_Control_Color
 */
class OTF_Customize_Control_Background_Position extends WP_Customize_Control {
    public $type = 'otf-background-position';

    /**
     * Render the control.
     */
    public function render_content() {
        $options = array(
            array(
                'left top'   => array( 'label' => __( 'Top Left', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-left-alt' ),
                'center top' => array( 'label' => __( 'Top', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-up-alt' ),
                'right top'  => array( 'label' => __( 'Top Right', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-right-alt' ),
            ),
            array(
                'left center'   => array( 'label' => __( 'Left', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-left-alt' ),
                'center center' => array( 'label' => __( 'Center', 'opal-theme-framework' ), 'icon' => 'background-position-center-icon' ),
                'right center'  => array( 'label' => __( 'Right', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-right-alt' ),
            ),
            array(
                'left bottom'   => array( 'label' => __( 'Bottom Left', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-left-alt' ),
                'center bottom' => array( 'label' => __( 'Bottom', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-down-alt' ),
                'right bottom'  => array( 'label' => __( 'Bottom Right', 'opal-theme-framework' ), 'icon' => 'dashicons dashicons-arrow-right-alt' ),
            ),
        );

        if ($this->label){
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php
        }

        if ($this->description){
            ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php
        }
        ?>
        <div class="otf-control-content">
            <fieldset>
                <div class="background-position-control">
                    <?php foreach ($options as $group) : ?>
                        <div class="button-group">
                            <?php foreach ($group as $value => $input) : ?>
                                <label>
                                    <input class="screen-reader-text" name="<?php echo esc_attr($this->id) ?>" type="radio"
                                           value="<?php echo esc_attr( $value ); ?>" <?php checked($this->value(), $value) ?> <?php $this->link() ?>>
                                    <span class="button display-options position"><span
                                                class="<?php echo esc_attr( $input['icon'] ); ?>"
                                                aria-hidden="true"></span></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </fieldset>
        </div>
        <?php
    }
}