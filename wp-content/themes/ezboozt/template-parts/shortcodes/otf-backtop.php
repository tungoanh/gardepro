<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $type
 * @var $this WPBakeryShortCode_OTF_Base
 */
//Shortcode: [otf_backtop title="Top" class=""]

$atts = shortcode_atts(array(
    'title' => esc_html__("Top", 'ezboozt'),
    'class' => '',
), $atts, 'otf_backtop');
extract($atts);

?>
<div class="otf-backtop <?php echo esc_attr($el_class); ?> ">
    <a href="#" class="scrollup text-center d-block">
        <span class="icon fa fa-angle-up"></span>
        <span class="title d-block">
            <?php echo esc_html($title); ?>
        </span>
    </a>
</div>